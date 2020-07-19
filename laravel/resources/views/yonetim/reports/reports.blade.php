@extends('yonetim.layouts.master')

@section('title','Raporlar | '.config('app.name'))
@section('header')

<link rel="stylesheet" href="/css/plugins/datatables/dataTables.bootstrap4.css">
<link rel="stylesheet" href="/css/magic-check.min.css">


@stop

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Rapor Oluştur
                </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('yonetim.anasayfa') }}">Yardım Masası</a></li>
              <li class="breadcrumb-item active">Rapor Oluştur</li>
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
          <form id="report" method="post" action="{{ route('report.create') }}">
              {{ csrf_field() }}
          <div class="card-body">
              <div class="row">
              <div class="col-md-4 row" style="background-color: #ffefc1; border-radius: 10px">
                  <div class="col-md-12 text-center border-bottom border-dark mb-2">
                      <label>Mahalleler</label>
                  </div>
                  @php($y=0)
                  @foreach($neighborhoods as $n)
                      @php($y++)
                      <div class="col-md-4 text-left">
                          @if(old('neighborhood'))
                            @if(in_array($n->id,old('neighborhood')))
                              <input class="magic-checkbox neighborhood" type="checkbox" name="neighborhood[]" id="{{$n->slug}}" value="{{$n->id}}" checked>
                            @else
                              <input class="magic-checkbox neighborhood" type="checkbox" name="neighborhood[]" id="{{$n->slug}}" value="{{$n->id}}">
                            @endif
                          @else
                              <input class="magic-checkbox neighborhood" type="checkbox" name="neighborhood[]" id="{{$n->slug}}" value="{{$n->id}}">
                          @endif

                          <label class="font-size-4 ml-4 mt" for="{{$n->slug}}" style="font-weight: normal">
                                    {{ $n->name }}
                            </label>
                      </div>
                  @endforeach
                  <div class="col-md-4 text-left">

                      @if(old('allneighborhood'))
                        <input class="magic-checkbox" type="checkbox" name="allneighborhood" id="tummahalle" value="1" checked>
                      @else
                          <input class="magic-checkbox" type="checkbox" name="allneighborhood" id="tummahalle" value="1">
                      @endif

                      <label class="font-size-4 ml-4 mt" for="tummahalle" style="font-weight: normal">
                          <b>Hepsi*</b>
                      </label>
                  </div>
              </div>

                  <div class="col-md-3 row ml-3" style="background-color: #ffefc1; border-radius: 10px">
                      <div class="col-md-12 text-center border-bottom border-dark mb-2">
                          <label>Yardım Türleri</label>
                      </div>
                      @php($z=0)
                      @php($helpType = Helpers::getHelpTypes())
                      @foreach($helpType as $h)
                          @php($z++)
                          <div class="col-md-12 text-left">
                              @if(old('helptypes'))
                                  @if(in_array($h->id,old('helptypes')))
                                        <input class="magic-checkbox helptype" type="checkbox" name="helptypes[]" id="{{$h->slug}}" value="{{$h->id}}" checked>
                                  @else
                                        <input class="magic-checkbox helptype" type="checkbox" name="helptypes[]" id="{{$h->slug}}" value="{{$h->id}}">
                                  @endif
                              @else
                                  <input class="magic-checkbox helptype" type="checkbox" name="helptypes[]" id="{{$h->slug}}" value="{{$h->id}}">
                              @endif

                              <label class="font-size-4 ml-4 mt" for="{{$h->slug}}" style="font-weight: normal">
                                  {{ $h->name }}
                              </label>
                          </div>
                      @endforeach
                      <div class="col-md-12 text-left">
                          @if(old('helptypes'))
                                <input class="magic-checkbox" type="checkbox" name="allhelptypes" id="tum-yardimturleri" value="1" checked>
                          @else
                              <input class="magic-checkbox" type="checkbox" name="allhelptypes" id="tum-yardimturleri" value="1">
                          @endif

                          <label class="font-size-4 ml-4 mt" for="tum-yardimturleri" style="font-weight: normal">
                              <b>Hepsi *</b>
                          </label>
                      </div>
                  </div>

                  <div class="col-md-2 row ml-2">
                      <div class="col-md-12" style="background-color: #ffefc1; border-radius: 10px">
                      <div class="col-md-12 text-center border-bottom border-dark mb-2">
                          <label>Durum Bilgileri</label>
                      </div>
                      @php($x=0)
                      @foreach($statuses as $s)
                              @php($x++)
                              <div class="col-md-12 text-left">
                                  @if(old('statuses'))
                                      @if(in_array($s->id,old('statuses')))
                                          <input class="magic-checkbox status-{{ $s->finisher }}" type="checkbox" name="statuses[]" id="{{$s->id}}" value="{{ $s->id }}" checked>
                                      @else
                                          <input class="magic-checkbox status-{{ $s->finisher }}" type="checkbox" name="statuses[]" id="{{$s->id}}" value="{{ $s->id }}">
                                      @endif
                                  @else
                                      <input class="magic-checkbox status-{{ $s->finisher }}" type="checkbox" name="statuses[]" id="{{$s->id}}" value="{{ $s->id }}">
                                  @endif

                                  <label class="font-size-4 ml-4 mt" for="{{$s->id}}" style="font-weight: normal">
                                      {{ $s->name }}
                                  </label>
                              </div>
                      @endforeach
                      </div>
                      <div class="col-md-12 mt-2" style="background-color: #ffefc1; border-radius: 10px">
                      <div class="col-md-12 text-center border-bottom border-dark mb-2">
                          <label>Açık & Kapalı</label>
                      </div>

                      <div class="col-md-12 text-left">
                          @if(old('situation') == 1)
                              <input class="magic-radio" type="radio" name="situation" id="aciktalepler" value="1" checked>
                          @else
                              <input class="magic-radio" type="radio" name="situation" id="aciktalepler" value="1">
                          @endif

                          <label class="font-size-4 ml-4 mt"  for="aciktalepler" style="font-weight: normal">
                              Açık Talepler
                          </label>
                      </div>
                      <div class="col-md-12 text-left">
                          @if(old('situation') == 2)
                              <input class="magic-radio" type="radio" name="situation" id="kapalitalepler" value="2" checked>
                          @else
                              <input class="magic-radio" type="radio" name="situation" id="kapalitalepler" value="2">
                          @endif


                          <label class="font-size-4 ml-4 mt"  for="kapalitalepler" style="font-weight: normal">
                              Kapalı Talepler
                          </label>
                      </div>

                          <div class="col-md-12 text-left">
                              @if(old('situation') == 3)
                                  <input class="magic-radio" type="radio" name="situation" id="tumtalepler" value="3" checked>
                              @else
                                  <input class="magic-radio" type="radio" name="situation" id="tumtalepler" value="3">
                              @endif


                              <label class="font-size-4 ml-4 mt"  for="tumtalepler" style="font-weight: normal">
                                  Hepsi
                              </label>
                          </div>
                      <div class="col-md-12 text-left">
                          @if(old('situation') == 0 or (old('situation') != 1 and old('situation') != 2 and old('situation') != 3))
                              <input class="magic-radio" type="radio" name="situation" id="ozeltalepler" value="0" checked>
                          @else
                              <input class="magic-radio" type="radio" name="situation" id="ozeltalepler" value="0">
                          @endif

                          <label class="font-size-4 ml-4 mt" for="ozeltalepler"  style="font-weight: normal">
                              Özel Seçim
                          </label>
                      </div>
                      </div>
                  </div>

                <div class="col-md-3 row ml-2">
                  <div class="col-md-12" style="background-color: #ffefc1; border-radius: 10px;">
                      <div class="col-md-12 text-center border-bottom border-dark mb-2 mt-0">
                          <label>Tarih Aralığı</label>
                      </div>
                      <div class="col-md-12">
                          <div class="col-md-12 text-center">
                              <input id="first-date"  type="text" class="form-control" placeholder="Baş. Tarihi" name="first_date" value="{{ old('first_date') }}">
                          </div>

                          <div class="col-md-12 text-left mt-2">
                              <input id="last-date" type="text" class="form-control" placeholder="Bitiş. Tarihi" name="last_date" value="{{ old('last_date') }}">
                          </div>

                      </div>
                  </div>
                  <div class="col-md-12 mt-2" style="background-color: #ffefc1; border-radius: 10px;">
                        <div class="col-md-12 text-center border-bottom border-dark mb-2 mt-0">
                            <label>Birden fazla yardım alma durumu</label>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-12 text-left">
                                @if(old('samehelp') == 1)
                                    <input class="magic-radio" type="radio" name="samehelp" id="samehelp" value="1" checked>
                                @else
                                    <input class="magic-radio" type="radio" name="samehelp" id="samehelp" value="1">
                                @endif

                                <label class="font-size-4 ml-4 mt"  for="samehelp" style="font-weight: normal">
                                    1'den fazla yardım alanlar
                                </label>
                            </div>
                            <div class="col-md-12 text-left">
                                @if(old('samehelp') == 2)
                                    <input class="magic-radio" type="radio" name="samehelp" id="sameonehelp" value="2" checked>
                                @else
                                    <input class="magic-radio" type="radio" name="samehelp" id="sameonehelp" value="2">
                                @endif

                                <label class="font-size-4 ml-4 mt"  for="sameonehelp" style="font-weight: normal">
                                    Aynı yardımı birden fazla alanlar
                                </label>
                            </div>
                            <div class="col-md-12 text-left">
                                @if(old('samehelp') == 0 or (old('samehelp') != 1 and old('samehelp') != 2))
                                    <input class="magic-radio" type="radio" name="samehelp" id="nofiltersamehelp" value="0" checked>
                                @else
                                    <input class="magic-radio" type="radio" name="samehelp" id="nofiltersamehelp" value="0">
                                @endif

                                <label class="font-size-4 ml-4 mt" for="nofiltersamehelp"  style="font-weight: normal">
                                    Kısıtlama Yok
                                </label>
                            </div>

                        </div>
                    </div>
                  <div class="col-md-12 mt-2" style="background-color: #ffefc1; border-radius: 10px;">
                      <div class="col-md-12 text-center border-bottom border-dark mb-2 mt-0">
                          <label>Rapor Türü</label>
                      </div>
                      <div class="col-md-12">
                          <div class="col-md-12 text-left">
                              @if(old('rapor') == 1 or old('rapor') != 2)
                                  <input class="magic-radio" type="radio" name="rapor" id="excel" value="1" checked>
                              @else
                                  <input class="magic-radio" type="radio" name="rapor" id="excel" value="1">
                              @endif

                              <label class="font-size-4 ml-4 mt"  for="excel" style="font-weight: normal">
                                  Excel Listesi Al
                              </label>
                          </div>
                          <div class="col-md-12 text-left">
                              @if(old('rapor') == 2)
                                  <input class="magic-radio" type="radio" name="rapor" id="ekran" value="2" checked>
                              @else
                                  <input class="magic-radio" type="radio" name="rapor" id="ekran" value="2">
                              @endif

                              <label class="font-size-4 ml-4 mt"  for="ekran" style="font-weight: normal">
                                  Ekranda Listele
                              </label>
                          </div>


                      </div>
                  </div>



              </div>
              </div>


          </div>
          <div class="card-footer text-right">
              <a href="#" class="btn btn-success text-left" id="create_report">
                  <label class="fa fa-cog"> </label> Rapor Oluştur
              </a>

              <button type="reset" class="btn btn-warning text-left" id="clear">
                  <label class="fa fa-eraser"> </label> Temizle
              </button>

              <a href="{{ route('yonetim.anasayfa') }}" class="btn btn-danger text-left" id="iptal">
                  <label class="fa fa-times"> </label> Vazgeç
              </a>
          </div>
          </form>
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
<br /><br /><br /><br />


@stop

@section('script')
    <script src="/js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="/js/plugins/datepicker/locales/bootstrap-datepicker.tr.js"></script>
    <script type="text/javascript">
        $('#first-date').mask('00.00.0000')
        $('#last-date').mask('00.00.0000')
        $('#first-date').datepicker({
            format: 'dd.mm.yyyy',
            autoclose: true,
            language: 'tr'
        });
        $('#last-date').datepicker({
            format: 'dd.mm.yyyy',
            autoclose: true,
            language: 'tr'
        });

        function changeChooseNeighborhood() {
            var checked = $( ".neighborhood:checked" ).length;
            var hepsi = {{ $y }};

            if(hepsi == checked) {
                $('#tummahalle').prop('checked', true);

            }else {
                $('#tummahalle').prop('checked', false);

            }
        }

        function changeChooseHelpType() {
            var checked = $( ".helptype:checked" ).length;
            var hepsi = {{ $z }};

            if(hepsi == checked) {
                $('#tum-yardimturleri').prop('checked', true);

            }else {
                $('#tum-yardimturleri').prop('checked', false);
            }
        }

        $('#tummahalle').change(function () {
            if(this.checked) {
                $('.neighborhood').prop('checked', true);
            }else{
                $('.neighborhood').prop('checked', false);
            }
        });

        $('.neighborhood').change(function () {

                changeChooseNeighborhood();

        });

        $('#tum-yardimturleri').change(function () {
            if(this.checked) {
                $('.helptype').prop('checked', true);
            }else {
                $('.helptype').prop('checked', false);
            }
        });

        $('.helptype').change(function () {
            changeChooseHelpType();
        });

        function changeChooseStatus() {
            var acik = $( ".status-0:checked" ).length;
            var kapali = $( ".status-1:checked" ).length;
            var hepsi = {{ $x }};

            $('#aciktalepler').prop('checked', false);
            $('#kapalitalepler').prop('checked', false);

            if(hepsi == acik + kapali) {
                $('#tumtalepler').prop('checked', true);
                $('#ozeltalepler').prop('checked', false);

            }else {
                $('#tumtalepler').prop('checked', false);
                $('#ozeltalepler').prop('checked', true);

            }
        }

        $('.status-0').change(function () {
            changeChooseStatus();

        });

        $('.status-1').change(function () {
            changeChooseStatus();

        });

        $('#aciktalepler').change(function () {
            if(this.checked) {
                $('.status-0').prop('checked', true);
                $('.status-1').prop('checked', false);
            }
        });

        $('#kapalitalepler').change(function () {
            if(this.checked) {
                $('.status-0').prop('checked', false);
                $('.status-1').prop('checked', true);
            }
        });

        $('#tumtalepler').change(function () {
            if(this.checked) {
                $('.status-0').prop('checked', true);
                $('.status-1').prop('checked', true);
            }
        });

        $('#ozeltalepler').change(function () {
            changeChooseStatus();
        });


    </script>

    <script type="text/javascript">


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
                    text: "Raporlama ekranından ayrılacaksınız.",
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
            linkSelector : "a#create_report",
            init: function() {
                $(this.linkSelector).on('click', {self:this}, this.handleClick);
            },
            handleClick: function(event) {
                event.preventDefault();
                var data = $( "#excel:checked" ).length;
                if (data != 1) {
                    swal({
                        title: 'Emin misiniz?',
                        text: "Rapor oluşturmak istediğinizden emin misiniz?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Evet, oluşturmak istiyorum!',
                        cancelButtonText:'Hayır',
                        showLoaderOnConfirm: false,
                        preConfirm: function() {
                            return new Promise(function(resolve) {
                                $("#report").submit();
                            });
                        },
                        allowOutsideClick: false
                    });
                }else {
                    return new Promise(function(resolve) {
                        $("#report").submit();
                    });
                }

            },
        };

        iptal.init();
        ekle.init();

    </script>

@stop