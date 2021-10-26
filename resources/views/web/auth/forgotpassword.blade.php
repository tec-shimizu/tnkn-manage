@extends('web.layouts.layout')

@section('main-content')
        <nav class="navbar navbar-light text-nowrap">
            <div class="container-fluid">
                <div>
                    パスワード再発行
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
                    <p>メールアドレスを入力してください</p>
                    <p>パスワード再設定のためにURLをお送りいたします</p>
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control" id="email" placeholder="メールアドレス" required>
                </div>

                <div class="col-auto mb-3">
                    <button type="submit" class="submit-btn btn btn-primary">送信</button>
                </div>

                <div class="col-auto mb-2">
                </div>
                
            </nav>
        </form>
@endsection