<!DOCTYPE html>
<html @yield('html.tags')>
<head>
    @yield('page.head')
</head>
<body @yield('body.tags')>
@yield('content')
@yield('footer.scripts')
</body>
</html>