<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Meeting\ZoomController;
use App\Http\Controllers\Common\FaqController;
use App\Http\Controllers\Inquiry\InquiryController;
use App\Http\Controllers\Form\InquiryFormController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () { return view('welcome'); });

// ログイン表示
Route::get('/', function () { return view('web/auth/login'); });
// ログイン実行
Route::post('/', [LoginController::class, 'login'])->name('root');

Route::get('/error', function() { return view('web/commonpage/error'); });

// パスワード忘れ表示
Route::get('/forgotpassword', function () { return view('web/auth/forgotpassword'); });
// パスワード忘れ送信
Route::post('/forgotpassword', [ForgotPasswordController::class, 'sendresetmail']);
// パスワード忘れ送信完了
//Route::get('/sentresetmail', function () { return view('web/auth/sentresetmail'); });

// パスワード再設定表示
Route::get('/resetpassword', [ForgotPasswordController::class, 'index']);
// パスワード再設定実行
Route::post('/resetpassword', [ForgotPasswordController::class, 'resetpassword']);
// パスワード再設定実行完了
//Route::get('/', function () { return view('web/auth/completeresetpassword'); });


Auth::routes();
{
    // TOP
    Route::get('/top', function () { return view('web/commonpage/top'); });

    // ログアウト
    Route::get('/logout', [LogoutController::class, 'logout']);

    // パスワード変更
    Route::get('/changepassword', [ChangePasswordController::class, 'index']);

    // パスワード変更実行
    Route::post('/changepassword', [ChangePasswordController::class, 'change']);

    // ZOOM連携
    Route::get('/zoom', [ZoomController::class, 'index']);

    // ZOOM連携 実行
    Route::post('/zoom/connect', [ZoomController::class, 'connect']);

    // ZOOM連携 解除
    Route::post('/zoom/disconnect', [ZoomController::class, 'disconnect']);

    // お問い合わせ情報一覧
    Route::get('/inquiry', [InquiryController::class, 'index']);

    // お問い合わせ情報一覧検索
    Route::post('/inquiry/search/{page}', [InquiryController::class, 'search']);

    // お問い合わせ情報照会
    Route::get('/inquiry/refer/{id}', [InquiryController::class, 'refer']);

    // お問い合わせ情報編集
    Route::get('/inquiry/edit/{id}', [InquiryController::class, 'edit']);

    // お問い合わせ情報 回答
    Route::post('/inquiry/answer', [InquiryController::class, 'answer']);

    // お問い合わせ情報 ZOOM予約
    Route::post('/inquiry/book', [InquiryController::class, 'bookZoom']);

    // お問い合わせ情報 ZOOM予約取消
    Route::post('/inquiry/cancel', [InquiryController::class, 'cancelZoom']);

    // お問い合わせ情報 備考記入
    Route::post('/inquiry/remarks', [InquiryController::class, 'registerRemarks']);

    // お問い合わせフォーム編集
    Route::get('form/inquiry', [InquiryFormController::class, 'index']);

    // お問い合わせフォーム編集更新
    Route::post('form/inquiry/update', [InquiryFormController::class, 'update']);

    // FAQ
    Route::get('faq', function () { return view('faq/index'); });

    // FAQ ダウンロード
    Route::get('faq/download', [FaqController::class, 'download']);

}
