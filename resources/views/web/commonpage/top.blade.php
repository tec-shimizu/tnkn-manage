@extends('web.layouts.manage')

@section('main-content')
        <nav class="navbar navbar-light text-nowrap">
            @csrf
            @if (!empty($error))
                <div class="alert alert-danger mb-3" role="alert">
                    {{ $error }}
                </div>
            @endif

            <div class="container-fluid">
                <div>
                    ZOOMが未連携です
                </div>
            </div>
            <div class="container-fluid">
                <div>
                    3件お問い合わせが届いています
                </div>
            </div>
            <div class="container-fluid">
                <div>
                    お問い合わせフォームURLは現在非公開になっています
                </div>
            </div>
            <div class="container-fluid">
                <div>
                    お問い合わせフォームURL：https://wwwwwwwwwwwwwwwww
                </div>
            </div>
        </nav>

            <nav class="navbar navbar-light px-5 text-nowrap flex-column">
                <div class="col-auto mb-3 d-flex flex-row">
                    <div class="p-2">
                        <form method="get" action="/inquiry">
                            <button type="submit" class="submit-btn btn btn-primary">お問い合わせ情報管理</button>
                        </form>
                    </div>
                    <div class="p-2">
                        <form method="get" action="/form/inquiry">
                            <button type="submit" class="submit-btn btn btn-primary">お問い合わせフォーム管理</button>
                        </form>
                    </div>
                </div>
                
            </nav>
        </form>
@endsection