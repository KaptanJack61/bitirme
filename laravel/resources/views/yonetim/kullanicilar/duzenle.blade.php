@extends('yonetim.layouts.master')

@section('title',$kullanici->name.' | Kullanıcı Düzenle | '.config('app.name'))

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
                        <h1 class="m-0 text-dark">Kullanıcı Düzenle</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/anasayfa">Yardım Masası</a></li>
                            <li class="breadcrumb-item">Kullanıcılar</li>
                            <li class="breadcrumb-item">Kullanıcı Düzenle</li>
                            <li class="breadcrumb-item active">{{$kullanici->name}}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <!-- Main content -->
        <section class="content">
            <form role="form" id="kullanicilar" method="post" name="yazi" action="/kullanicilar/duzenle/{{$kullanici->id}}" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="row">
                <div class="col-md-10">
                    <!-- general form elements -->
                    <div class="card card-warning">
                        <div class="card-header text-center">
                            <h3 class="card-title">Kullanıcı Bilgileri</h3>
                        </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ad Soyad</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="adsoyad"
                                                       placeholder="John Doe"
                                                       @if(old('adsoyad')!="")
                                                        value="{{old('adsoyad')}}"
                                                       @else
                                                        value="{{$kullanici->name}}"
                                                       @endif
                                                >
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Kullanıcı Adı</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="username"
                                                       placeholder="ad.soyad"
                                                       @if(old('username')!="")
                                                       value="{{old('username')}}"
                                                       @else
                                                       value="{{$kullanici->username}}"
                                                        @endif
                                                >
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Şifre</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-unlock"></i></span>
                                                </div>
                                                <input type="password" class="form-control" name="password">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Şifre Tekrar</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-unlock"></i></span>
                                                </div>
                                                <input type="password" class="form-control" name="password2">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">E-Mail</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-at"></i></span>
                                                </div>
                                                <input type="email" class="form-control" name="email"
                                                       placeholder="ornek@serdivan.bel.tr"
                                                       @if(old('email')!="")
                                                       value="{{ old('email') }}"
                                                       @else
                                                       value="{{$kullanici->email}}"
                                                    @endif
                                                >
                                            </div>

                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> Yönetici</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user-tie"></i></span>
                                                </div>
                                                <select class="form-control" name="admin">
                                                    @if(old('admin')!="")
                                                        @if(old('admin')==1)
                                                            <option value="1" selected>Admin</option>
                                                            <option value="0">Normal</option>
                                                        @else
                                                            <option value="1">Admin</option>
                                                            <option value="0" selected>Normal</option>
                                                        @endif
                                                    @else
                                                        @if($kullanici->admin==1)
                                                            <option value="1" selected>Admin</option>
                                                            <option value="0">Normal</option>
                                                        @else
                                                            <option value="1">Admin</option>
                                                            <option value="0" selected>Normal</option>
                                                        @endif
                                                    @endif
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <label for="exampleInputPassword1">Fotoğraf</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                        <i class="fa fa-picture-o"></i>
                                                    </a>
                                                </span>
                                                <input id="thumbnail" class="form-control" type="text" name="fotograf"
                                                       @if(old('fotograf')!="")
                                                       value="{{old('fotograf')}}"
                                                       @else
                                                       value="{{$kullanici->photo}}"
                                                    @endif
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Aktif & Pasif</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-check"></i></span>
                                                </div>
                                                <select class="form-control" name="aktif">
                                                    @if(old('aktif')!="")
                                                        @if(old('aktif')==1)
                                                            <option value="1" selected>Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        @else
                                                            <option value="1">Aktif</option>
                                                            <option value="0" selected>Pasif</option>
                                                        @endif
                                                    @else
                                                        @if($kullanici->active==1)
                                                            <option value="1" selected>Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        @else
                                                            <option value="1">Aktif</option>
                                                            <option value="0" selected>Pasif</option>
                                                        @endif
                                                    @endif
                                                </select>
                                            </div>



                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <label for="exampleInputPassword1">Özgeçmiş</label>
                                        <div class="form-group">
                                            <textarea id="editor2" name="detail" style="width: 100%">
                                                @if(old('detail')!="")
                                                    {{ old('detail') }}
                                                @else
                                                    {{ $kullanici->detail }}
                                                @endif
                                            </textarea>
                                        </div>
                                        <!-- /.card -->
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer text-right">
                                <a href="/kontrolpaneli/kullanicilar/ekle/" id="guncelle" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Güncelle"><i class="fa fa-check"></i></a>
                                <button type="reset" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Temizle"><i class="fa fa-trash"></i></button>
                                <a id="iptal" href="{{ route('yonetim.kullanicilar') }}" data-toggle="tooltip" data-placement="top" title="Vazgeç">
                                    <i class="btn btn-danger"><span class="fa fa-times"></span></i>
                                </a>
                            </div>

                    </div>
                </div>

                <div class="col-md-2">
                    <!-- general form elements -->
                    <div class="card card-warning">
                        <div class="card-header text-center">
                            <h3 class="card-title">Profil Fotoğrafı</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(old('fotograf')!="")
                                    <img id="holder" width="100%" src="{{url(old('fotograf'))}}" style="margin-top: -10px; margin-bottom: -10px;">
                                @else
                                    <img id="holder" width="100%" src="{{url($kullanici->photo)}}" style="margin-top: -10px; margin-bottom: -10px;">
                                @endif
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-right">
                            <a href="/kontrolpaneli/kullanicilar/ekle/" id="guncelle" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Güncelle"><i class="fa fa-check"></i></a>
                            <button type="reset" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Temizle"><i class="fa fa-trash"></i></button>
                            <a id="iptal" href="{{ route('yonetim.kullanicilar') }}" data-toggle="tooltip" data-placement="top" title="Vazgeç">
                                <i class="btn btn-danger"><span class="fa fa-times"></span></i>
                            </a>
                        </div>

                    </div>
                </div>

                <!-- /.card -->

                <!-- /.col -->
            </div></form>
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
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    @include('yonetim.layouts.partials.ckeditor')
    <script>
        var options2 = {
            height: 200
        };
    </script>

    <script>
        CKEDITOR.replace('editor2', options2);
    </script>

    <script>
        $('#lfm').filemanager('image');
    </script>


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
                    text: "Kullanıcı düzenleme ekranından ayrılacaksınız.",
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
            linkSelector : "a#guncelle",
            init: function() {
                $(this.linkSelector).on('click', {self:this}, this.handleClick);
            },
            handleClick: function(event) {
                event.preventDefault();
                swal({
                    title: 'Güncellemek istediğinize emin misiniz?',
                    text: "Kullanıcı bilgilerinin doğruluğundan emin misiniz?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, güncellemek istiyorum!',
                    cancelButtonText:'Hayır',
                    showLoaderOnConfirm: false,
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            $("#kullanicilar").submit();
                        });
                    },
                    allowOutsideClick: false
                });
            },
        };

        iptal.init();
        ekle.init();
    </script>
@stop
