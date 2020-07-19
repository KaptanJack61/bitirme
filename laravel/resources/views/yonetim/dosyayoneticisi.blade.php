@extends('yonetim.layouts.master')

@section('title','Dosya Yöneticisi | '.config('app.name'))
@section('header')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@stop

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dosya Yöneticisi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/kontrolpaneli/anasayfa">Yönetim Paneli</a></li>
              <li class="breadcrumb-item active">Dosya Yöneticisi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
  <!-- Main content -->
  <section class="content">
      <div class="row">
      <div class="col-12">


        <div class="card">
           <iframe width="100%" height="700" src="/dosya-yoneticisi?type=file" style="border: none"></iframe>

            <!--<div style="height: 600px;">
                <div id="fm"></div>
            </div> -->
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@stop

@section('script')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@stop