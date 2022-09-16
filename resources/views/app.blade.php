<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="Description" content="Scarlet is a Arma 3™ Mod Installer for the Australian Armed Forces (AAF) community" />

        <title inertia>{{ config('app.name', 'Scarlet Updater') }}</title>

        <!-- Scripts -->
        @routes(null, csp_nonce())
        @vite('resources/scripts/main.ts')
        @inertiaHead
    </head>
    <body class="antialiased absolute top-0 bottom-0 h-full w-full bg-[#080e1f]">
        @inertia
    </body>
</html>
