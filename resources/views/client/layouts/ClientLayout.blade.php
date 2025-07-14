<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Galaxy</title>
    @include('client.layouts.partials.head')
</head>

<body>
    @include('client.layouts.partials.header')

    <div class="container">
        @yield('content')
    </div>

    @include('client.layouts.partials.footer')

</body>

</html>