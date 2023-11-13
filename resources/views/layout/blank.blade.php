<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title class="title">Sis Billing</title>
    <link rel="icon" href="{{ asset('public/logo.png') }}" type="image/x-icon">
    @include('layout.headerlink')
</head>
<body style="background-color: transparent">
    @yield('content')
        <div style="background-color:white; position: fixed; bottom: 10px; padding:2px 8px 2px 8px; border-radius:20px; right:20px; font-weight:bold;color:rgb(149, 136, 136)">
            &copy; Copyright GKS
        </div>
    @include('layout.footerlink')
</body>
</html>