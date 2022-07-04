<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#070e20]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Scarlet Updater') }}</title>
    @routes(null, csp_nonce())
    @vite
</head>
<body class="antialiased absolute top-0 bottom-0 h-full w-full">
    @inertia
</body>
</html>
