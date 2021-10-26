@extends('web.layouts.layout')

@section('main-content')
        <nav class="navbar navbar-light text-nowrap">
            <div class="container-fluid">
                <div>
                    エラーが発生しました。
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

                
                <div class="col-auto mb-3">
                    <button type="submit" class="submit-btn btn btn-primary">戻る</button>
                </div>
                
                <div class="col-auto mb-2">
                </div>

            </nav>
        </form>
@endsection