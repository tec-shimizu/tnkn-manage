@extends('web.layouts.layout')

@section('main-content')
        <nav class="navbar navbar-light text-nowrap">
            <div class="container-fluid">
                <div>
                    パスワード再設定
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
                    <p>新しいパスワードを入力し、「パスワードを再設定する」</p>
                    <p>ボタンをクリックしてください</p>
                </div>

                <div class="mb-3">
                    <input type="password" name="password_new" class="form-control" id="password_new" placeholder="新しいパスワード" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="password_confirm" class="form-control" id="password_confirm" placeholder="新しいパスワード（確認）" required>
                </div>

                <div class="mb-3">
                    <input type="checkbox" name="chk"  id="chk">
                    <label for="chk" class="form-label">パスワードを表示する</label>
                </div>

                <div class="col-auto mb-3">
                    <button type="submit" class="submit-btn btn btn-primary">更新</button>
                </div>

                <div class="col-auto mb-2">
                </div>
                
            </nav>
        </form>
@endsection