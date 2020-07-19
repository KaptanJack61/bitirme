
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', config('app.name'))</title>
    @include('frontend.layouts.partials.header')
    @yield('header')
</head>
<body>
@include('frontend.layouts.partials.navbar')
<div class="container">
    <div class="row">
        @yield('content')

    </div>
</div>
@include('frontend.layouts.partials.footer')
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts for this template -->
<script src="js/clean-blog.min.js"></script>
@yield('script')
<!-- ./wrapper -->
</body>
</html>






