<?php

namespace App\Http\Controllers\Inquiry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * お問い合わせ情報一覧表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // @todo データの取得
        $list = collect([
            'Inquiry' => [
                ['id' => '1', 'status' => '2', 'status_name' => '回答済み', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '1', 'person_in_charge' => '清水大輔'],
                ['id' => '2', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '3', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '4', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '5', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
            ]
        ]);

        return view('web/inquiry/list',
            ['data' => $list,]
       );

    }

    public function search()
    {
        // @todo データの取得
        $list = collect([
            'Inquiry' => [
                ['id' => '1', 'status' => '2', 'status_name' => '回答済み', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '1', 'person_in_charge' => '清水大輔'],
                ['id' => '2', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '3', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '4', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '5', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
            ]
        ]);

        return view('web/inquiry/list',
            ['data' => $list,]
       );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refer($id)
    {
        // @todo 権限チェック
        // @todo データ取得
        
        $list = collect([
            'Inquiry' => [
                ['id' => '1', 'status' => '2', 'status_name' => '回答済み', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '1', 'person_in_charge' => '清水大輔'],
                ['id' => '2', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '3', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '4', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '5', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
            ]
        ]);

        return view('web/inquiry/detail',
            [
                'mode' => 'refer',
                'data' => $list,
            ]
       );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // @todo 権限チェック
        // @todo データ取得
        
        $list = collect([
            'Inquiry' => [
                ['id' => '1', 'status' => '2', 'status_name' => '回答済み', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '1', 'person_in_charge' => '清水大輔'],
                ['id' => '2', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '3', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '4', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
                ['id' => '5', 'status' => '1', 'status_name' => '未回答', 'created' => '2021-08-09 15:00', 'sei' => 'テスト', 'mei' => '太郎', 'company_name' => '電通テックテスト', 'person_in_charge_id' => '', 'person_in_charge' => ''],
            ]
        ]);

        return view('web/inquiry/detail',
        [
            'mode' => 'update',
            'data' => $list,
        ]
   );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
