@extends('yonetim.layouts.master')

@section('title',$kategori->kategoriadi.' | Kategori Düzenle | '.config('app.name'))

@section('header')
    <link rel="stylesheet" href="/css/plugins/select2/select2.min.css">
@stop

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Kategori Düzenle</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/kontrolpaneli/anasayfa">Yönetim Paneli</a></li>
                            <li class="breadcrumb-item">Kategoriler</li>
                            <li class="breadcrumb-item">Kategori Düzenle</li>
                            <li class="breadcrumb-item active"> {{$kategori->kategoriadi}}</li>

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
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-warning">
                        <div class="card-header text-center">
                            <h3 class="card-title">Kategori Bilgileri</h3>
                        </div>
                        <form role="form" id="kategori" method="post" name="referans" action="/kontrolpaneli/kategoriler/duzenle/{{$kategori->id}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Adı</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-align-justify"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="kategoriadi"
                                                       placeholder="Kategori Adı"
                                                       value="{{ $kategori->kategoriadi }}"
                                                >
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1">Üst Kategori</label>
                                        <div class="form-group">

                                            <select class="form-control select2" name="ustkategori" style="width: 100%;">
                                                <option value="0" selected>Ana Kategori</option>
                                                @foreach($kategoriler as $kat)
                                                    @if($kat->id != $kategori->id)
                                                        @if ($kat->id==$kategori->parent_id)
                                                            <option value="{{$kat->id}}" selected>{{ $kat->kategoriadi }}</option>
                                                        @else
                                                            <option value="{{$kat->id}}">{{ $kat->kategoriadi }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Açıklama</label>
                                        <div class="form-group">
                                            <textarea id="editor1" name="aciklama" style="width: 100%; height: 1000px">
                                                {{ $kategori->aciklama }}
                                            </textarea>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer text-right">
                                <a href="/kontrolpaneli/kategoriler/duzenle/" id="ekle" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Güncelle"><i class="fa fa-check"></i></a>
                                <button type="reset" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Temizle"><i class="fa fa-trash"></i></button>
                                <a id="iptal" href="{{ route('yonetim.kategoriler') }}" data-toggle="tooltip" data-placement="top" title="Vazgeç">
                                    <i class="btn btn-danger"><span class="fa fa-times"></span></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- general form elements -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Önemli Not</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            Sözleşmeler firmalarla yapılan anlaşmaların belgesidir. Bir firmaya yağ toplama kaydı girilebilmesi ve ödeme yapılamabilmesi için sözleşme kaydı gereklidir.
                        </div>


                        <!-- /.card-body -->


                    </div>

                </div>
                <!-- /.card -->

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
    <script src="/js/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/js/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="/js/plugins/select2/select2.full.min.js"></script>
    <script src="/js/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">

        $('.select2').select2();
        var iptal = {
            linkSelector : "a#iptal",
            init: function() {
                $(this.linkSelector).on('click', {self:this}, this.handleClick);
            },
            handleClick: function(event) {
                event.preventDefault();
                var self = event.data.self;
                var link = $(this);
                swal({
                    title: 'İptal etmek istediğinize emin misiniz?',
                    text: "Kategori düzenleme ekranından ayrılacaksınız.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, iptal etmek istiyorum!',
                    cancelButtonText:'Hayır',
                    showLoaderOnConfirm: false,
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            window.location = link.attr('href');
                        });
                    },
                    allowOutsideClick: false
                });
            },
        };

        var ekle = {
            linkSelector : "a#ekle",
            init: function() {
                $(this.linkSelector).on('click', {self:this}, this.handleClick);
            },
            handleClick: function(event) {
                event.preventDefault();
                swal({
                    title: 'Güncellemek istediğinize emin misiniz?',
                    text: "Kategori bilgilerinin doğruluğundan emin misiniz?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, güncellemek istiyorum!',
                    cancelButtonText:'Hayır',
                    showLoaderOnConfirm: false,
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            $("#kategori").submit();
                        });
                    },
                    allowOutsideClick: false
                });
            },
        };

        iptal.init();
        ekle.init();
    </script>
    <script>
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            ClassicEditor
                .create(document.querySelector('#editor1'))
                .then(function (editor) {
                    // The editor instance
                })
                .catch(function (error) {
                    console.error(error)
                })
        })
    </script>



@stop
