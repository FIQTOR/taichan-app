<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/global.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    @vite('resources/css/app.css')
    <title>@yield('title', $title) - {{ config('app.name') }}</title>
</head>

<body>
    @include('components/navbar')
    @yield('content')
    @include('components/footer')
</body>

</html>
