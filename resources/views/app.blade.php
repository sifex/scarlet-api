<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css"
          integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous"/>
    <title>Laravel</title>
    @routes
    @vite
    @auth
        <script>
            var user = {{ Illuminate\Support\Js::from(Auth::user()) }};
        </script>
    @endauth
</head>
<body class="antialiased absolute top-0 bottom-0 h-full w-full">
@inertia
</body>
</html>
