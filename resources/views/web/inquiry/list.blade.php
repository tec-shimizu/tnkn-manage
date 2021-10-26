@extends('web.layouts.manage')

@section('main-content')
        <nav class="navbar navbar-light text-nowrap">
            @csrf
            @if (!empty($error))
                <div class="alert alert-danger mb-3" role="alert">
                    {{ $error }}
                </div>
            @endif
        </nav>

        <h1>お問い合わせ一覧</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ステータス</th>
                    <th>受付日時</th>
                    <th>氏名</th>
                    <th>会社名</th>
                    <th>操作</th>
                </tr>
            </thead>

                <tbody>
                    @forelse ($data['Inquiry'] as $record)
                    <tr>
                        <td>{{ $record['id'] }}</td>
                        <td>{{ $record['status_name'] }}</td>
                        <td>{{ $record['created']}}</td>
                        <td>{{ $record['sei'] }}{{ $record['mei'] }}</td>
                        <td>{{ $record['company_name'] }}</td>
                        </td>
                        <td>
                            <nav class="navbar navbar-light px-5 text-nowrap flex-column">
                                <div class="col-auto mb-3 d-flex flex-row">
                                    <div class="p-2">
                                        <button type="button" class="submit-btn btn btn-primary" onclick="location.href='/inquiry/refer/{{$record['id']}}';">照会</button>
                                    </div>
                                    <div class="p-2">
                                        <button type="button" class="submit-btn btn btn-primary" onclick="location.href='/inquiry/edit/{{$record['id']}}';">回答</button>
                                    </div>
                                </div>
                                
                            </nav>
                        </td>
                    </tr>
                    @empty
                        <h2>お問い合わせはありません</h2>
                    @endforelse
                </tbody>
            </table>

        </form>
@endsection