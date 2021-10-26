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
                    お問い合わせ一覧
                </div>
            </div>
        </nav>

            <nav class="navbar navbar-light px-5 text-nowrap flex-column">
                <div class="col-auto mb-3 d-flex flex-row">
                    <div class="p-2">
                        <form method="get" action="">
                            <button type="submit" class="submit-btn btn btn-primary">お問い合わせ情報管理</button>
                        </form>
                    </div>
                    <div class="p-2">
                        <form method="get" action="">
                            <button type="submit" class="submit-btn btn btn-primary">お問い合わせフォーム管理</button>
                        </form>
                    </div>
                </div>
                
            </nav>

            @if($data)
        <div class="alert alert-danger mb-3" role="alert">
            <h4 class="alert-heading">お問い合わせはありません。</h4>
            <p>このシステムをご利用する場合、Zoomとの連携を行ってください。</p>
            <a href="{{$zoomOuthLink}}" class="btn btn-danger">Zoomと連携</a>
        </div>
        @else
            <a href="{{'/admin/form'}}" class="btn btn-primary">会議を予約する</a>
            <br>
            <br>
            <h1>予約一覧</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>お客様名</th>
                        <th>会社名</th>
                        <th>アドレス</th>
                        <th>ミーティング開始日</th>
                        <th>ステータス</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($meetings as $meeting)
                    <tr class="@if($meeting->is_canceled) table-danger @endif">
                        <td>{{ $meeting->name }}</td>
                        <td>{{ $meeting->company_name }}</td>
                        <td>{{ $meeting->email }}</td>
                        <td>{{ $meeting->start_at }}</td>
                        <td>{{ $meeting->status}}</td>
                        </td>
                        <td>
                            @if ($meeting->is_canceled)
                                <b>この予約はキャンセルされました。</b>
                            @elseif ($meeting->is_closed)
                                <b>この予約は会議が終了しました。</b>
                            @else
                                @if (!$meeting->is_prereserve)
                                    <a href="{{'/admin/meeting/executeconfirm?hash='.$meeting->hash}}" class="btn btn-primary">今すぐ実施する</a>
                                @endif
                                @if ($meeting->can_close)
                                    <a href="{{'/admin/meeting/close?hash='.$meeting->hash}}" class="btn btn-primary">会議終了</a>
                                @endif
                                <a href="{{'/admin/meeting/alter?hash='.$meeting->hash}}" class="btn btn-success">予約を変更</a>
                                <a href="{{'/admin/meeting/delete?hash='.$meeting->hash}}" class="btn btn-danger">予約を削除</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <h2>まだミーティングを受け付けていません。</h2>
                    @endforelse
                </tbody>
            </table>
        @endif

        </form>
@endsection