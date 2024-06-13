<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard | Skote - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    @include('layouts.includes.head')
    @yield('head')
</head>

<body data-sidebar="dark">
    @include('layouts.includes.header')

    @include('layouts.includes.sidebar')

    @yield('content')

    @include('layouts.includes.footer')

    @include('layouts.includes.foot')
    
    @yield('scripts')
</body>

</html>
