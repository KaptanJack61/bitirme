<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title', "Yönetim Paneli | ".config('app.name'))</title>

  @include('yonetim.layouts.partials.header')
  @yield('header')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  @include('yonetim.layouts.partials.navbar')
  @include('yonetim.layouts.partials.sidebar')
  @yield('content')
  @include('yonetim.layouts.partials.footer')
</div>
@include('yonetim.layouts.partials.script')

@yield('script')
<!-- ./wrapper -->
</body>
</html>
