<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') - Scarlet</title>
    <link rel="stylesheet" href="/v2/css/app.css">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
    <link href="https://fonts.googleapis.com/css?family=Exo+2:200,300,400,500" rel="stylesheet">

    @yield('styles')

</head>
<body>

@yield('content')
<script src="//code.jquery.com/jquery-2.2.4.min.js"></script>

@yield('scripts')
</body>
</html>
