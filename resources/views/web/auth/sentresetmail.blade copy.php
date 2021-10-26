@extends('web.layouts.layout')

@section('main-content')
        <nav class="navbar navbar-light text-nowrap">
            <div class="container-fluid">
                <div>
                    パスワード再設定用のメールを送信しました
                </div>
            </div>
        </nav>
        <form method="get" action="/">

            <nav class="navbar navbar-light shadow-sm px-5 text-nowrap flex-column">
                @csrf
                @if (!empty($error))
                    <div class="alert alert-danger mb-3" role="alert">
                        {{ $error }}
                    </div>
                @endif

                <div class="mb-3">
                    <p>対象のメールアドレスにメールを送信しました</p>
                    <p>※登録されていないメールアドレスの場合にはメールは届きません</p>
                </div>

                <div class="col-auto mb-3">
                    <button type="submit" class="submit-btn btn btn-primary">ログイン画面に戻る</button>
                </div>
                
                <div class="col-auto mb-2">
                </div>

            </nav>
        </form>
@endsection
