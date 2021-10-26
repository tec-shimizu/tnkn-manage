<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>solution1</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <style>
            *{
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }
            html{
                font-size: 16px;
            }
            .main-content{
                padding: 8rem;
            }
            .submit-btn{
                margin-left: auto;
                display: block;
            }
            .err{
                color: crimson;
            }
        </style>
    </head>
    <body>
        <div class="container p-5">
            <div class="my-3">
                @yield('main-content')
            </div>
        </div>
    </body>
</html>
