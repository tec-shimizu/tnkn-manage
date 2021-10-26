お問い合わせありがとうございます。
送信された内容は以下になります。

__________________________________________________

名前：　　　　{{$contact->name}}

Eメール：　　 {{$contact->email}}

ミーティングURL：
{{$contact->join_url}}

ミーティングパスワード：
{{$contact->password}}

開始時間：
{{$contact->start_at}}

ミーティング時間変更はこちらから：
{{env('APP_URL').'/form/alter?hash='.$contact->hash}}

ミーティングのキャンセルはこちら：
{{env('APP_URL').'/form/delete?hash='.$contact->hash}}

お問い合わせ内容：
{{$contact->content}}

__________________________________________________