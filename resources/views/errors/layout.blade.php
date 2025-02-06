<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/x-icon">
    <title>@yield('title', 'Pollux - Simple Polling System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#fafafa]">
    @yield('content')
</body>

</html>
