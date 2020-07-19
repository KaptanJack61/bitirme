@extends('yonetim.layouts.master')

@section('title','Yardım Talebi Düzenle | '.config('app.name'))

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
                        <h1 class="m-0 text-dark">Yardım Talebi Düzenle</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/anasayfa">Yönetim Paneli</a></li>
                            <li class="breadcrumb-item">Yardım Talepleri</li>
                            <li class="breadcrumb-item active">Yardım Talebi Düzenle</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <!-- Main content -->
        <section class="content">
            <form role="form" id="yardimtalebi" method="post" name="yazi" action="{{ route('yardimtalebi.update',['id' => $demand->id]) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="row">

                <!-- TODO: HATA GÖSTERİMİ YAPILACAK -->

                <div class="col-md-4">
                    <!-- general form elements -->
                    <div class="card card-warning">
                        <div class="card-header text-center">
                            <h3 class="card-title">Kişi Bilgileri</h3>
                        </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ad *</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                </div>
                                                <input id="first-name" type="text" class="form-control" name="first_name"
                                                       placeholder="Ahmet"
                                                       tabindex="0"
                                                       onkeypress="return isNumericKey(event)"
                                                       @if(is_null(old('first_name')))
                                                       value="{{ $first_name }}"
                                                       @else
                                                       value="{{ old('first_name') }}"
                                                       @endif
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Soyad *</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                </div>
                                                <input id="last-name" type="text" class="form-control" name="last_name"
                                                       placeholder="Yenilnez"
                                                       tabindex="0"
                                                       onkeypress="return isNumericKey(event)"
                                                       @if(is_null(old('last_name')))
                                                       value="{{ $last_name }}"
                                                       @else
                                                       value="{{ old('last_name') }}"
                                                       @endif
                                                >
                                            </div>

                                        </div>
                                    </div>

                                    <div id="name_alert" class="alert alert-danger col-md-12" role="alert" style="display: none">
                                        Adı ve ya Soyadını boş bıraktınız
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">T.C. Kimlik</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-id-badge"></i></span>
                                                </div>
                                                <input id="tc_no" type="text" class="form-control" name="tc_no"
                                                       placeholder="11 haneli T.C. kimlik No giriniz"
                                                       tabindex="0"
                                                       onkeypress="return isNumberKeyTc(event)"
                                                       maxlength="11"
                                                       minlength="11"
                                                       @if(is_null(old('tc_no')))
                                                       value="{{ $tc_no }}"
                                                       @else
                                                       value="{{ old('tc_no') }}"
                                                        @endif
                                                >
                                            </div>
                                        </div>
                                        <div id="tc_no_alert" class="alert alert-danger" role="alert" style="display: none">
                                            T.C. Kimlik Numarasını yanlış girdiniz.
                                            <ul>
                                                <li>11 haneli olacak şekilde giriniz.</li>
                                                <li>Ya da boş bırakınız..</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Telefon *</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                </div>
                                                <input id="phone" type="text" class="form-control" name="phone"
                                                       placeholder="10 haneli giriniz."
                                                       tabindex="0"
                                                       onkeypress="return isNumberKeyPhone(event)"
                                                       minlength="10"
                                                       maxlength="11"
                                                       @if(is_null(old('phone')))
                                                       value="{{ $demand->phone }}"
                                                       @else
                                                       value="{{ old('phone') }}"
                                                        @endif
                                                >
                                            </div>

                                        </div>

                                        <div id="phone_alert" class="alert alert-danger" role="alert" style="display: none">
                                            Telefon numarasını boş bıraktını ya da eksik girdiniz.
                                            <ul>
                                                <li>10 Haneli olcak şekilde giriniz.</li>
                                            </ul>
                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">E-Mail</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-at"></i></span>
                                                </div>
                                                <input id="email" type="email" class="form-control" name="email"
                                                       placeholder="ornek@serdivan.bel.tr"
                                                       tabindex="0"
                                                       @if(is_null(old('email')))
                                                       value="{{ $email }}"
                                                       @else
                                                       value="{{ old('email') }}"
                                                        @endif
                                                >
                                            </div>
                                        </div>
                                        <div id="email_alert" class="alert alert-danger" role="alert" style="display: none">
                                            Email adresini yanlış girdiniz.
                                            <ul>
                                                <li>ornek@domain.com formatında giriniz.</li>
                                                <li>Ya da boş bırakınız.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer text-right">

                            </div>

                    </div>
                </div>

                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-warning">
                        <div class="card-header text-center">
                            <h3 class="card-title">Talep Bilgileri</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <div id="general_alert_one" class="alert alert-danger col-md-12" role="alert" style="display: none">
                                    <span class="text-bold"><i>En az bir tane yardım kalemine giriş yapmalısınız.</i></span>
                                </div>

                                <div id="warning-one" class="alert alert-light col-md-12" role="alert">
                                    <span class="text-bold"><i>En az bir tane yardım kalemine giriş yapmalısınız.</i></span>
                                </div>

                                @include('yonetim.demands.helps_types')

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mahalle *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-city"></i></span>
                                            </div>
                                            <select id="neighborhood" class="form-control" name="neighborhood">
                                                <option value="0" selected>Mahalle seçiniz</option>
                                                @foreach($neighborhoods as $n)
                                                    @if(is_null(old('neigborhood')))
                                                        @if ($n->id == $neighborhood_id )
                                                            <option value="{{ $neighborhood_id }}" selected>{{ $n->name }} Mah.</option>
                                                        @else
                                                            <option value="{{ $neighborhood_id }}">{{ $n->name }} Mah.</option>
                                                        @endif

                                                    @else
                                                        @if (old('neighborhood') == $neighborhood_id )
                                                            <option value="{{ $neighborhood_id }}" selected>{{ $n->name }} Mah.</option>
                                                        @else
                                                            <option value="{{ $neighborhood_id }}">{{ $n->name }} Mah.</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Cadde & Sokak *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-street-view"></i></span>
                                            </div>
                                            <input id="street" type="text" class="form-control" name="street"
                                                   placeholder="Yıldız Sokak"
                                                   tabindex="0"
                                                   @if(is_null(old('street')))
                                                    value="{{ $street }}"
                                                   @else
                                                   value="{{ old('street') }}"
                                                   @endif
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Site Adı</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-building"></i></span>
                                            </div>
                                            <input id="city_name" type="text" class="form-control" name="city_name"
                                                   placeholder="Yaşam Sitesi"
                                                   tabindex="0"
                                                   @if(is_null(old('city_name')))
                                                   value="{{ $city_name }}"
                                                   @else
                                                   value="{{ old('city_name') }}"
                                                    @endif
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Kapı Numarası</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-torii-gate"></i></span>
                                            </div>
                                            <input id="gate-no" type="text" class="form-control" name="gate_no"
                                                   placeholder="8B"
                                                   tabindex="0"
                                                   @if(is_null(old('gate_no')))
                                                   value="{{ $gate_no }}"
                                                   @else
                                                   value="{{ old('gate_no') }}"
                                                    @endif
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin-top: 10px;">
                                    <label for="exampleInputPassword1">Açıklama</label>
                                    <div class="form-group">
                                            <textarea id="detail" class="form-control" name="detail" style="width: 100%">@if(is_null(old('detail'))){{ $detail }}@else{{ old('detail') }}@endif
                                            </textarea>
                                    </div>
                                    <!-- /.card -->
                                </div>

                                <div id="general_alert" class="alert alert-danger col-md-12" role="alert" style="display: none">
                                    <span class="text-bold"><i>* ile işaretlenmiş alanların doldurulması zorunludur.</i></span>
                                </div>

                                <div id="warning" class="alert alert-light col-md-12" role="alert">
                                    <span class="text-bold"><i>* ile işaretlenmiş alanların doldurulması zorunludur.</i></span>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer text-right">
                            <a href="#" id="guncelle" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Güncelle">
                                <i class="fa fa-check"></i> Güncelle
                            </a>
                            <button type="reset" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Temizle">
                                <i class="fa fa-trash"></i> Temizle
                            </button>
                            <a id="iptal" href="{{ route('yardimtalepleri.demands') }}" data-toggle="tooltip" data-placement="top" title="Vazgeç">
                                <i class="btn btn-danger"><span class="fa fa-times"></span> Vazgeç</i>
                            </a>
                        </div>

                    </div>
                </div>

                <!-- /.card -->

                <!-- /.col -->
            </div>

            </form>
            <!-- /.row -->
        </section>
        <!-- /.content -->
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop
@section('script')
@include('yonetim.helps.script')

@stop
