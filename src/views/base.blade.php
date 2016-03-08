<!DOCTYPE html>
<html @foreach(Page::getHtmlTags() AS $k=>$v){{$k}}="{{$v}}" @endforeach>
<head>
{!! Page::renderHead() !!}
@stack('head')
</head>
<body @foreach(Page::getBodyTags() AS $k=>$v){{$k}}="{{$v}}" @endforeach>
@yield('body')
<!--bottom page-->
{!! Page::renderFooter() !!}
</body>
</html>