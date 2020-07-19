@extends('yonetim.layouts.master')

@section('title','Yapılan Yardımlar | '.config('app.name'))
@section('header')

<link rel="stylesheet" href="/css/plugins/datatables/dataTables.bootstrap4.css">
@stop

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Yardımlar
                <a href="{{ route('yardimtalebi.storeIndex')  }}" class="btn btn-success">
                    <i class="fa fa-plus"></i> Yardım Talebi Ekle
                </a> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/anasayfa">Yardım Masası</a></li>
              <li class="breadcrumb-item active">Yardımlar</li>
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

          <!-- /.card-header -->
            <div class="card-body text-center">
                <span class="text-danger"><h3>Henüz hiç bir yardım yapılmadı.</h3></span>
            </div>
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

@stop