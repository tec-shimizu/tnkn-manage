<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendresetmail(Request $request)
    {
        // @todo DBからメールアドレスを検索
        // @todo 該当した場合はパスワード再設定メールを送信し、該当しない場合は何もしない
        // 完了ページに遷移
        //return redirect(RouteServiceProvider::);
        return view('web/auth/sentresetmail');
    }

    public function index()
    {
        // @todo パラメータを解析してDBのデータと一致するかチェック
        if (false) {
            // エラー設定
            return redirect('/error')->withErrors([
                'error' => '有効期限が切れたか無効なURLです',
            ]);
        }
        return view('web/auth/resetpassword');
    }

    public function resetpassword()
    {
        // @todo バリデーション
        // @todo DB登録
        // @todo メール送信

        return view('web/auth/completeresetpassword');
    }
}
