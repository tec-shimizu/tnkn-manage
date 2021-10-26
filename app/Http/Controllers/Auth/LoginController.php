<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * ログイン処理
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        // とりあえず中に入る
        return redirect('/top');

        $credential = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credential)) {
            // ログインに成功したら認証情報をセッションにセットし、トップに遷移
            $request->session()->regenerate();
            return redirect('/top');
            //return redirect()->intended('top');
        }

        // ログインに失敗したらエラーで返す
        return back()->withErrors([
            'error' => 'メールアドレスまたはパスワードが間違っています。',
            //'email' => 'メールまたはパスワードが一致しません。',
        ]);
        //return view('login')->with('error','メールアドレスまたはパスワードが間違っています。');

    }

    /**
     * ログアウト処理
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
        //return redirect()->route('base');
    }

}
