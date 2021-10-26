@extends('web.layouts.layout')

@section('main-content')
        <nav class="navbar navbar-light text-nowrap">
            <div class="container-fluid">
                <div>
                    つなかんへのログイン
                </div>
            </div>
        </nav>
        <form method="post" action="">

            <nav class="navbar navbar-light shadow-sm px-5 text-nowrap flex-column">
                @csrf
                @if (!empty($error))
                    <div class="alert alert-danger mb-3" role="alert">
                        {{ $error }}
                    </div>
                @endif

                <div class="mb-3">
                    <!--<label for="email" class="form-label">メールアドレス</label>-->
                    <input type="email" name="email" size="20" class="form-control" id="email" placeholder="メールアドレス" required>
                </div>

                <div class="mb-3">
                    <!--<label for="password" class="form-label">パスワード</label>-->
                    <input type="password" name="password" class="form-control" id="password" placeholder="パスワード" required>
                </div>

                <div class="mb-3">
                    <input type="checkbox" name="chk"  id="chk">
                    <label for="chk" class="form-label">次回からメールアドレスの入力を省略</label>
                </div>

                <div class="col-auto mb-3">
                    <button type="submit" class="submit-btn btn btn-primary">ログイン</button>
                </div>
                
                <div class="mb-3">
                    <a href="/forgotpassword">パスワードを忘れた方はこちら</a>
                </div>
                
                <div class="col-auto mb-2">
                </div>

            </nav>
        </form>
@endsection