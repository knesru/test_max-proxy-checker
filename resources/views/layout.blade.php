<!Doctype html>
<html>
<head>
<title>{{ $title }}</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script type="application/javascript" src="{{asset('js/app.js')}}"></script>
</head>
<body>
<div class="content-wrapper">
@yield('content', 'Default content')
</div>
</body>
</html>
