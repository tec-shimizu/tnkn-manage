<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Meeting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use DateTimeZone;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ZoomApiController extends Controller
{
    //
    protected function me(){
        $user = auth()->user();
        $client = new \GuzzleHttp\Client([
            'headers' => ['Authorization' => 'Bearer '.$user->access_token]
        ]);
        Log::debug("access_token:".$user->access_token);
        $res = $client->request('GET','https://api.zoom.us/v2/users/me');
        $result = json_decode($res->getBody()->getContents());
        // dd($result);
        return $result;
    }

    protected function checkRefresh(){
        $user = auth()->user();
        $token_expires =  new \DateTime($user->zoom_expires_in);
        $now = new \DateTime();

        if($now >= $token_expires){
            $basic = base64_encode(env('ZOOM_CLIENT_ID').':'.env('ZOOM_CLIENT_SECRET'));
            $client = new \GuzzleHttp\Client([
                'headers' => ['Authorization' => 'Basic '.$basic]
            ]);
            $res = $client->request('POST','https://zoom.us/oauth/token',[
                'query' => [
                    'grant_type'=>'refresh_token',
                    'refresh_token'=>$user->refresh_token
                ]
            ]);
            $result = json_decode($res->getBody()->getContents());

            $user->access_token= $result->access_token;
            $user->refresh_token= $result->access_token;
            $unixTime = time();
            $user->zoom_expires_in= date("Y-m-d H:i:s",$unixTime+$result->expires_in);
            $user->save();
            return $user;
        }
        return $user;
    }

    public function newReserve(Request $request) {
        $newmeeting = new Meeting();
        if (!$request->has('reserve')) {
            return $this->prereserve($request, $newmeeting);
        } else {
            return $this->reserve($request, $newmeeting);
        }
    }

    public function updateReserve(Request $request) {
        if(isset($request['hash'])){
            $hash = $request['hash'];
            $meeting = Meeting::where('hash', $hash)->first();
            Log::debug("ZoomApiController#updateReserve meeting:".print_r($meeting));
            if(!empty($meeting)) {
                if (!$request->has('reserve')) {
                    return $this->prereserve($request, $meeting);
                } else {
                    return $this->reserve($request, $meeting);
                }
            }
        }
        return $this->newReserve($request);
    }


    public function prereserve(Request $request, Meeting $meeting) {
        $validator = Validator::make($request->all(),[
            'email'=>'required|email:rfc',
            'yourname'=>'required',
            'companyname'=>'required',
            'startAt'=>'date|required',
            'content'=>'required|max:1000',
        ]);

        $error = $validator->getMessageBag()->toArray();

        if ($validator->fails()) {
            return view('form',compact('error'));
        }
        // $start_at_for_calc = explode("T", $request->start_at);
        $start_at_for_calc = str_replace("T", " ", $request->startAt);
        $start = new \DateTime($start_at_for_calc);
        $format = $start->format('Y年m月d日 H時i分');
        Log::debug("ZoomApiController#prereserve has prereserve:".$request->has('prereserve'));
        Log::debug("ZoomApiController#prereserve meeting.id:".$meeting->id);
        Log::debug("ZoomApiController#prereserve request->start_at:".$request->startAt);
        Log::debug("ZoomApiController#prereserve start_at_for_calc:".$format);

        $meeting->name = $request->yourname;
        $meeting->company_name = $request->companyname;
        $meeting->email = $request->email;
        $meeting->content = $request->content;
        $meeting->category = '0'; //仮埋め
        $meeting->is_prereserve = true;
        // $meeting->hash = Hash::make((new \DateTime())->format('YmdHis')."_".mt_rand());
        $meeting->hash = substr(base_convert(bin2hex(openssl_random_pseudo_bytes(64)),16,36),0,64);
        $meeting->is_canceled = false;
        $meeting->start_at = $start;
        $meeting->save();

        return redirect('/admin/form/confirm')->with([
            'form_id'=>$meeting->id,
            'name'=>$request->yourname,
            'companyname'=>$request->companyname,
            'content'=>$request->content,
            'start_time'=>$format
        ]);
    }

    public function reserve(Request $request, Meeting $meeting) {
        if (!$request->has('reserve')) {
            return $this->prereserve($request, $meeting);
        }

        $validator = Validator::make($request->all(),[
            'email'=>'required|email:rfc',
            'yourname'=>'required',
            'companyname'=>'required',
            'startAt'=>'date|required',
            'content'=>'required|max:1000',
        ]);

        $error = $validator->getMessageBag()->toArray();

        if ($validator->fails()) {
            return view('form',compact('error'));
        }
        
        // @todo 更新
        if ($request->filled($meeting->zoom_meeting_id)) {
            $meeting = $this->createMeeting($request, $meeting);
        } else {
            $meeting = $this->updateMeeting($request, $meeting);
        }

        $format = $meeting->start_at->format('Y年m月d日 H時i分');
        // $meeting->start_at = $format;
        // $mail = new ContactMail($meeting);
        // Mail::to($request->email)->send($mail);

        return redirect('/admin/form/confirm')->with([
            'form_id'=>$meeting->id,
            'name'=>$request->yourname,
            'companyname'=>$request->companyname,
            'content'=>$request->content,
            'start_time'=>$format
        ]);
    }


    public function createMeeting(Request $request, Meeting $meeting){

        $user = $this->checkRefresh();
        $user = auth()->user();

        $zoom_user = $this->me();

        $url = 'https://api.zoom.us/v2/users/'.$zoom_user->id.'/meetings';
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => 'Bearer '.$user->access_token,
                'Content-Type'=>'application/json'
            ],
        ]);

        $topic = $request->companyname.' '.$request->yourname.'様 ご相談';
        $meeting_password = substr(base_convert(bin2hex(openssl_random_pseudo_bytes(9)),16,36),0,9);
        Log::debug("startAt:".$request->startAt);
        $requestJson = [
            \GuzzleHttp\RequestOptions::JSON => [
                'topic' => $topic,
                'type' => 2,
                'start_time' => $request->startAt.":00",
                // 'start_time' => $startAt->format('Y-m-dTH:i:s'),
                'duration' => 30,
                // 'schedule_for' => $request->email, // 有料プラン
                'timezone' => "Asia/Tokyo",
                'password' => $meeting_password,
                // 'agenda' => $request->content // 有料プラン？入れても変わらない
                // 'settings' => array(
                //     'join_before_host' => 'true',
                //     'mute_upon_entry' => 'true',
                //     'use_pmi' => 'false',
                //     'waiting_room' => 'false'
                // )
            ]
        ];
        Log::debug("requestJson:".print_r($requestJson,true));
        $res = $client->request('POST',$url,$requestJson);
        $result = json_decode($res->getBody()->getContents());

        $meeting->name = $request->yourname;
        $meeting->company_name = $request->companyname;
        $meeting->email = $request->email;
        $meeting->content = $request->content;
        $meeting->category = '0'; //仮埋め
        
        $start = new \DateTime($result->start_time, new DateTimeZone('Europe/London'));
        // Log::debug("result_start_date(London):".$start->format('Y m d H i'));
        $start->setTimezone(new DateTimeZone('Asia/Tokyo'));
        // Log::debug("result_start_date(Tokyo):".$start->format('Y m d H i'));
        $meeting->start_at = $start;
        $meeting->is_prereserve = false;
        $meeting->hash = substr(base_convert(bin2hex(openssl_random_pseudo_bytes(64)),16,36),0,64);
        $meeting->is_canceled = false;

        $meeting->zoom_meeting_id = $result->id;
        $meeting->zoom_join_url = $result->join_url;
        $meeting->zoom_start_url = $result->start_url;
        $meeting->zoom_password = $result->password;
        $meeting->save();

        return $meeting;

    }

    public function updateMeeting(Request $request, Meeting $meeting){

        $user = $this->checkRefresh();
        $user = auth()->user();

        $zoom_user = $this->me();

        // $url = 'https://api.zoom.us/v2/users/'.$zoom_user->id.'/meetings';
        $url = 'https://api.zoom.us/v2/meetings/'.$meeting->zoom_meeting_id;
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => 'Bearer '.$user->access_token,
                'Content-Type'=>'application/json'
            ],
        ]);

        $topic = $request->companyname.' '.$request->yourname.'様 ご相談';
        $meeting_password = substr(base_convert(bin2hex(openssl_random_pseudo_bytes(9)),16,36),0,9);
        $start_at_for_zoom = $request->startAt.":00";
        $start_at_for_db = new \DateTime(str_replace("T", " ", $request->startAt));
        // Log::debug("startAt:".$request->startAt);
        // Log::debug("start_at_for_zoom:".$start_at_for_zoom);
        // Log::debug("start_at_for_db:".$start_at_for_db->format('Y m d H i'));
        $requestJson = [
            \GuzzleHttp\RequestOptions::JSON => [
                'topic' => $topic,
                'type' => 2,
                'start_time' => $start_at_for_zoom,
                // 'start_time' => $startAt->format('Y-m-dTH:i:s'),
                'duration' => 30,
                // 'schedule_for' => $request->email, // 有料プラン
                'timezone' => "Asia/Tokyo",
                'password' => $meeting_password,
                // 'agenda' => $request->content // 有料プラン？入れても変わらない
                // 'settings' => array(
                //     'join_before_host' => 'true',
                //     'mute_upon_entry' => 'true',
                //     'use_pmi' => 'false',
                //     'waiting_room' => 'false'
                // )
            ]
        ];
        Log::debug("requestJson:".print_r($requestJson,true));
        $res = $client->request('PATCH',$url,$requestJson);
        $result = json_decode($res->getBody()->getContents());

        $meeting->name = $request->yourname;
        $meeting->company_name = $request->companyname;
        $meeting->email = $request->email;
        $meeting->content = $request->content;
        $meeting->category = '0'; //仮埋め
        
        $meeting->start_at = $start_at_for_db;
        $meeting->is_prereserve = false;
        $meeting->hash = substr(base_convert(bin2hex(openssl_random_pseudo_bytes(64)),16,36),0,64);
        $meeting->is_canceled = false;

        // 基本情報は変わらない。（結果が返ってこない）
        // $meeting->zoom_meeting_id = $result->id;
        // $meeting->zoom_join_url = $result->join_url;
        // $meeting->zoom_start_url = $result->start_url;
        // $meeting->zoom_password = $result->password;
        $meeting->save();

        return $meeting;

    }

    public function closeMeeting(Request $request){
        
        if(isset($request['hash'])){
            $hash = $request['hash'];
            $meeting = Meeting::where('hash',$hash)->first();

            if(!empty($meeting)) {
                $meeting->close_at = new \DateTime();
                $meeting->save();
                return redirect()->route('amdinbase');
            }

    
        }

        return redirect()->route('base');
    }

    public function adminMeetingAlter(Request $request){
        
        if(isset($request['hash'])){
            $hash = $request['hash'];
            $meeting = Meeting::where('hash',$hash)->first();
            $start_at_for_screen = substr(str_replace(" ", "T", $meeting->start_at), 0, 16);
            Log::debug("ZoomApiController#adminMeetingAlter start_at_for_screen:".$start_at_for_screen);
            $meeting->start_at_for_screen = $start_at_for_screen;
    
            if(!empty($meeting)) return view('adminmeetingalter', compact('meeting'));
        }

        return redirect()->route('base');
    }

    public function adminMeetingExecuteConfirm(Request $request){
        
        if(isset($request['hash'])){
            $hash = $request['hash'];
            $meeting = Meeting::where('hash',$hash)->first();

            if(!empty($meeting)) return view('adminmeetingexecuteconfirm', compact('meeting'));
        }

        return redirect()->route('base');

    }

    public function adminMeetingExecute(Request $request){
        
        if(isset($request['hash'])){
            $hash = $request['hash'];
            $meeting = Meeting::where('hash',$hash)->first();

            $errorinfo = array();
            if(empty($meeting) || $meeting->is_canceled == '1') {
                $error[] = '会議情報が不正です。情報を確認してください。';
            }

            // 会議情報に実行日時を更新する
            $meeting->meeting_at = new \DateTime();
            $meeting->save();
            return view('adminmeetingexecute', compact('meeting', 'errorinfo'));
        }

        return redirect()->route('base');

    }

    public function adminMeetingDeleteConfirm(Request $request){
        
        if(isset($request['hash'])){
            $hash = $request['hash'];
            $meeting = Meeting::where('hash',$hash)->first();

            if(!empty($meeting)) return view('adminmeetingdelete');
        }

        return redirect()->route('base');
    }

    public function adminMeetingDeleteComplete(Request $request){
        
        if(isset($request['hash'])){
            $hash = $request['hash'];
            $meeting = Meeting::where('hash',$hash)->first();

            if(!empty($meeting)){
                $meeting->is_canceled = true;
                $meeting->save();
                return redirect()->route('adminmeetingdeletecomplete');
            }
        }

        return redirect()->route('base');
    }
}
