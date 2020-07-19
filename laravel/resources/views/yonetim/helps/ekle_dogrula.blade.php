@extends('yonetim.layouts.master')

@section('title','Yardım Talebi Girişi Doğrulama| '.config('app.name'))
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
                        <h1 class="m-0 text-dark">Yardım Talebi Girişi Doğrulama
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/anasayfa">Yardım Masası</a></li>
                            <li class="breadcrumb-item">Yardım Talepleri</li>
                            <li class="breadcrumb-item">Yardım Talebi Ekle</li>
                            <li class="breadcrumb-item active">Yardım Talebi Doğrula</li>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="col-md-12">
                                        <span class="text-black text-bold font-size-2"><h2>{{ $request->first_name." ".$request->last_name }}</h2></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="text-black-50 text-bold font-size-2"><h4>Tel: {{ $request->phone }}</h4></span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="text-info text-bold font-size-2">
                                            <h4>Adres: {{$neighborhood." ".$request->street." ".
                                                        $request->city_name." No: ".$request->gate_no}}</h4></span>
                                    </div>

                                    @if($request->detail!="")
                                    <div class="col-md-12">
                                        <span class="text-black text-bold font-size-2"><h4>Açıklama: {{ $request->detail }}</h4></span>
                                    </div>
                                    @endif
                                </div>

                                <div class="col-md-5 text-right">

                                        <a href="#" id="all" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="İstenen tüm yardımlar verilsin">

                                                        <i class="fa fa-plus"> </i> İstenen tüm yardımlar verilsin
                                        </a><br /><br />

                                        <a href="#" id="only" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Sadece verilmeyen yardımlar verilsin">

                                                        <i class="fa fa-plus-circle"> </i> Sadece verilmeyen yardımlar verilsin

                                        </a><br /><br />

                                        <a id="iptal" href="{{ route('yonetim.anasayfa') }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Yeni yardım verilmesin">
                                            <i class="fa fa-window-close"> </i> Yardım vermekten vazgeç
                                        </a>

                                       <div class="col-md-12">

                                        <form role="form" id="yardimtalebi-ozel" method="post" name="yazi" action="{{ route('yardimtalebi.verify.store') }}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="first_name" value="{{ $request->first_name }}" />
                                            <input type="hidden" name="last_name" value="{{ $request->last_name }}" />
                                            <input type="hidden" name="phone" value="{{ $request->phone }}" />
                                            <input type="hidden" name="tc_no" value="{{ $request->tc_no }}" />
                                            <input type="hidden" name="email" value="{{ $request->email }}" />
                                            <input type="hidden" name="neighborhood" value="{{ $request->neighborhood }}" />
                                            <input type="hidden" name="street" value="{{ $request->street }}" />
                                            <input type="hidden" name="city_name" value="{{ $request->city_name }}" />
                                            <input type="hidden" name="gate_no" value="{{ $request->gate_no }}" />
                                            <input type="hidden" name="detail" value="{{ $request->detail }}" />
                                            <input type="hidden" name="onlyGiven" value="1" />

                                            @foreach($helpTypes as $h)
                                                @if($h->isSingle==false and $request[$h->slug]!=null)
                                                    <input type="hidden" name="{{$h->slug}}" value="{{$request[$h->slug]}}" />
                                                @endif

                                                    @if($h->isSingle==true and in_array($h->id,$helpListOnControl)==false and $request[$h->slug]!=null)
                                                        <input type="hidden" name="{{$h->slug}}" value="{{$request[$h->slug]}}" />
                                                    @endif

                                            @endforeach
                                        </form>

                                        <form role="form" id="yardimtalebi" method="post" name="yazi" action="{{ route('yardimtalebi.verify.store') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                            <input type="hidden" name="first_name" value="{{ $request->first_name }}" />
                                            <input type="hidden" name="last_name" value="{{ $request->last_name }}" />
                                            <input type="hidden" name="phone" value="{{ $request->phone }}" />
                                            <input type="hidden" name="tc_no" value="{{ $request->tc_no }}" />
                                            <input type="hidden" name="email" value="{{ $request->email }}" />
                                            <input type="hidden" name="neighborhood" value="{{ $request->neighborhood }}" />
                                            <input type="hidden" name="street" value="{{ $request->street }}" />
                                            <input type="hidden" name="city_name" value="{{ $request->city_name }}" />
                                            <input type="hidden" name="gate_no" value="{{ $request->gate_no }}" />
                                            <input type="hidden" name="detail" value="{{ $request->detail }}" />
                                            <input type="hidden" name="onlyGiven" value="0" />
                                            @foreach($helpTypes as $h)
                                                <input type="hidden" name="{{$h->slug}}" value="{{$request[$h->slug]}}" />
                                            @endforeach
                                        </form>
                                       </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <hr class="alert-info" style="width: 100%">
                                </div>
                                 <div class="col-md-12 row">
                                     <div class="col-md-6">
                                         <div class="col-md-12 text-center">
                                             <span class="text-danger fon"><h4><u>Karşılanan yardım talepleri</u></h4></span>
                                         </div>
                                         <table id="yardim" class="table table-bordered table-striped">
                                             <thead>
                                             <tr>
                                                 <th class="text-center" style="width: 60px">#</th>
                                                 <th style="width: 200px">Yardım Türü</th>
                                                 <th>Miktarı</th>
                                                 <th style="width: 140px">Durum</th>
                                                 <th class="text-right" style="width: 110px">Kayıt Tarihi</th>
                                                 <th class="text-right" style="width: 120px">Son İşl.Tarihi</th>
                                             </tr>
                                             </thead>
                                             <tbody>

                                             @foreach($helpList as $hl)
                                                 @foreach($hl as $h)
                                                     @if($h->type->isSingle==true and in_array($h->type->id,$helpListOnControl))
                                                         @if($h->status->id == 7)
                                                              <tr style="background-color: red; color: white" data-toggle="tooltip" data-placement="top" title="{{ $h->detail }}">
                                                         @else
                                                             <tr style="background-color: yellow">
                                                         @endif
                                                     @else
                                                         <tr>

                                                             @endif
                                                             <td class="text-center">{{ $h->id }}</td>
                                                             <td>{{ $h->type->name }}</td>
                                                             <td>{{ $h->quantity." ".$h->type->metrik }}</td>
                                                             <td>{{ $h->status->name }}</td>

                                                             <td class="text-right">
                                                                 {{ date('d.m.Y', strtotime($h->created_at)) }}
                                                             </td>
                                                             <td class="text-right">
                                                                 {{ date('d.m.Y', strtotime($h->updated_at)) }}
                                                             </td>

                                                         </tr>
                                                         @endforeach
                                                         @endforeach
                                             </tbody>

                                         </table>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="col-md-12 text-center">
                                             <span class="text-danger"><h4><u>Güncel istenen yardım talepleri</u></h4></span>
                                         </div>
                                         <table id="yardiml" class="table table-bordered table-striped">
                                             <thead>
                                             <tr>
                                                 <th class="text-center" style="width: 60px">#</th>
                                                 <th style="width: 200px">Yardım Türü</th>
                                                 <th>Miktarı</th>
                                             </tr>
                                             </thead>
                                             <tbody>
                                             @php($x=1)
                                             @foreach($helpTypes as $h)
                                                 @if($request[$h->slug] != null)
                                                     @if($h->isSingle==true and in_array($h->id,$helpListOnControl))
                                                         <tr style="background-color: #00c0ef">
                                                     @else
                                                         <tr>
                                                             @endif
                                                             <td class="text-center">{{ $x }}</td>
                                                             <td>{{ $h->name }}</td>
                                                             <td>{{ $request[$h->slug]." ".$h->metrik }}</td>
                                                         </tr>
                                                         @php($x++)
                                                     @endif
                                                     @endforeach
                                             </tbody>

                                         </table>
                                     </div>
                                 </div>

                            </div>
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
<br/><br/><br/><br/>
@stop

@section('script')
    <script src="/js/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/js/plugins/datatables/dataTables.bootstrap4.js"></script>

    <script type="text/javascript">
        var all = {
            linkSelector : "a#all",
            init: function() {
                $(this.linkSelector).on('click', {self:this}, this.handleClick);
            },
            handleClick: function(event) {
                event.preventDefault();
                swal({
                    title: 'Onaylamak istediğinize emin misiniz?',
                    text: "İstenen tüm yardımları eklemek istediğinizden emin misiniz?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, eklemek istiyorum!',
                    cancelButtonText:'Hayır',
                    showLoaderOnConfirm: false,
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            $("#yardimtalebi").submit();
                        });
                    },
                    allowOutsideClick: false
                });
            },
        };

        var ozel = {
            linkSelector : "a#only",
            init: function() {
                $(this.linkSelector).on('click', {self:this}, this.handleClick);
            },
            handleClick: function(event) {
                event.preventDefault();
                swal({
                    title: 'Onaylamak istediğinize emin misiniz?',
                    text: "Sadece verilmeyen yardımları eklemek istediğinizden emin misiniz?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, eklemek istiyorum!',
                    cancelButtonText:'Hayır',
                    showLoaderOnConfirm: false,
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            $("#yardimtalebi-ozel").submit();
                        });
                    },
                    allowOutsideClick: false
                });
            },
        };

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
                    text: "Yardım ekleme ekranından ayrılacaksınız.",
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

        all.init();
        ozel.init();
        iptal.init();
    </script>



@stop