@extends('yonetim.layouts.master')

@section('title','Yardım Talepleri | '.config('app.name'))
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
            <h1 class="m-0 text-dark">Yardım Talebi
              <a href="{{ route('yardimtalebi.storeIndex')  }}" class="btn btn-success">
                  <i class="fa fa-plus"></i> Yardım Talebi Ekle
              </a> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/anasayfa">Yardım Masası</a></li>
                  <li class="breadcrumb-item">Yardım Talepleri</li>
                  <li class="breadcrumb-item">Yardım Talebi Ekle</li>
                  <li class="breadcrumb-item active">Yardım Talebi</li>
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
              <div class="col-md-8">
                  <div class="col-md-12">
                      <span class="text-black-50 text-bold font-size-2"><h1>{{ $full_name }}</h1></span>
                  </div>
                  <div class="col-md-12">
                      <span class="text-black-50 text-bold font-size-2"><h3>Tel: {{ $phone }}</h3></span>
                  </div>
                  <div class="col-md-4">
                  <span class="text-info text-bold font-size-4">
                      <h3>Adres: {{$address}}</h3></span>
                  </div>
                  <div class="col-md-12">
                      <span class="text-black text-bold font-size-2"><h5>Açıklama: {{ $detail }}</h5></span>
                  </div>
              </div>



              <div class="col-md-4 text-center">
                  <div class="col-md-12">
                      <span class="text-danger" style="font-size: 6em">{{$demand_no}}</span>
                  </div>

                  <div class="col-md-12">
                      <span class="text-danger text-bold font-size-4"><h3>Talep Numarası</h3></span>
                  </div>

              </div>




                  <form class="form-control" id="editAllInputForm" action="{{ route('yardimtalebi.edit',['id'=>$demand_no]) }} " method="post">
                      {{ csrf_field() }}

                      <div class="col-md-12 text-right">
                          <button id="editAllInputSubmit"  style="display: none" type="submit" class="btn btn-success" title="Güncelle">
                              <i class="fa fa-check"></i> Güncelle
                          </button>

                          <a id="editAllInputCancel" href="#" style="display: none" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Vazgeç">
                              <i class="fa fa-trash"></i> Vazgeç
                          </a>

                          <button id="editAllInputToggle" type="button" class="btn btn-warning" title="Düzenle">
                              <i class="fa fa-edit"></i> Yardım Miktarlarını Düzenle
                          </button>

                          <a id="editAllInputWithPerson" href="{{route('yardimtalebi.all.updateIndex',['id' => $demand_no])}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Kişi Bilgileri İle Düzenle">
                              <i class="fa fa-edit"></i> Kişi Bilgileri İle Düzenle
                          </a>

                          <a id="sil" href="{{route('yardimtalebi.all.destroy',['id'=>$demand_no])}}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Sil">
                              <i class="fa fa-trash"></i> Sil
                          </a>
                      </div>
                      <br />

            <table id="yardimlar" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th class="text-center" style="width: 60px">#</th>
                <th style="width: 200px">Yardım Türü</th>
                  <th>Miktarı</th>
                <th class="text-center islemler" style="width: 90px">İşlemler</th>
              </tr>
              </thead>
              <tbody>
              @foreach($helpList as $h)
                  @if($h->status->finisher == true)
                      <tr style="background-color: #00cc66">
                  @else
                      <tr>
                  @endif

                  <td class="text-center">{{ $h->id }}</td>
                    <td>{{ $h->type->name }}</td>
                    <td>
                        @if($h->status->finisher == true)
                            {{ $h->quantity." ".$h->type->metrik }}
                        @else
                            <span id="miktar" class="onaylanan_miktar_span">{{ $h->quantity." ".$h->type->metrik }}</span>
                            <div class="row onaylanan_miktar_inputs" style="display: none">
                                <div class="col-2">
                                    <input type="number" min="1" class="form-control input-sm" name="{{ $h->id }}" value="{{ $h->quantity }}" style="border-color: #00c0ef">
                                </div>
                                <div class="col-10"> {{  $h->type->metrik }} </div>
                            </div>
                        @endif

                    </td>

                    <td class="text-center islemler">
                        @if($h->status->finisher == false)
                            <a id="sil" href="{{route('yardimtalebi.destroy',['id'=>$h->id])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Sil">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endif

                  </td>

                </tr>
              @endforeach
              </tbody>
              <tfoot>
              <tr>
                  <th class="text-center">#</th>
                  <th>Yardım Türü</th>
                  <th>Miktarı</th>
                  <th class="text-center islemler">İşlemler</th>
              </tr>
              </tfoot>
            </table>
                  </form>
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
<script>
    $(function () {
        $("#yardimlar").DataTable({
            "language": {
                "lengthMenu": "Sayfada _MENU_ kayıt göster",
                "infoEmpty":" Kayıt yok",
                "search" : "Ara:",
                "decimal": ",",
                "emptyTable": "Tabloda herhangi bir veri mevcut değil",
                "info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "infoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                "infoPostFix":    "",
                "infoThousands":  ".",
                "loadingRecords": "Yükleniyor...",
                "processing":     "İşleniyor...",
                "zeroRecords":    "Eşleşen kayıt bulunamadı",
                "paginate": {
                    "first":    "İlk",
                    "last":     "Son",
                    "next":     "Sonraki",
                    "previous": "Önceki"
                },
                "aria": {
                    "sortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sortDescending": ": azalan sütun soralamasını aktifleştir"
                }
            }
        });
    });
</script>

<script>
    $( "#editAllInputToggle" ).click(function() {
        $( ".onaylanan_miktar_span" ).toggle();
        $( ".onaylanan_miktar_inputs" ).toggle();
        $( "#editAllInputSubmit" ).toggle();
        $( "#editAllInputCancel" ).toggle();
        $( "#editAllInputToggle" ).toggle();
        $( "#editAllInputWithPerson" ).toggle();
        $( "#sil" ).toggle();
        $( ".islemler" ).toggle();

    });

    $( "#editAllInputCancel" ).click(function() {
        $( ".onaylanan_miktar_span" ).toggle();
        $( ".onaylanan_miktar_inputs" ).toggle();
        $( "#editAllInputSubmit" ).toggle();
        $( "#editAllInputCancel" ).toggle();
        $( "#editAllInputToggle" ).toggle();
        $( "#editAllInputWithPerson" ).toggle();
        $( "#sil" ).toggle();
        $( ".islemler" ).toggle();

    });


</script>

<script type="text/javascript">
    var editer = {
        linkSelector : "a#duzenle",
        init: function() {
            $(this.linkSelector).on('click', {self:this}, this.handleClick);
        },
        handleClick: function(event) {
            event.preventDefault();
            var self = event.data.self;
            var link = $(this);
            swal({
                title: 'Düzenlemek istediğinize emin misiniz?',
                text: "Yardım talebini düzenleme ekranına yönlendirileceksiniz?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, düzenlemek istiyorum!',
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

    var deleter = {
        linkSelector : "a#sil",
        init: function() {
            $(this.linkSelector).on('click', {self:this}, this.handleClick);
        },
        handleClick: function(event) {
            event.preventDefault();
            var self = event.data.self;
            var link = $(this);
            swal({
                title: 'Silmek istediğinize emin misiniz?',
                text: "Yardım talebi silinecek. Bu işlemin geri dönüşü yok!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, silmek istiyorum!',
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

    editer.init();
    deleter.init();
</script>

<script>
    var guncelle1 = {
        linkSelector: "#editAllInputSubmit",
        init: function() {
            $(this.linkSelector).on('click', {
                self: this
            }, this.handleClick);
        },
        handleClick: function(event) {
            event.preventDefault();
            swal({
                title: 'Güncellemek istediğinize emin misiniz?',
                text: "Yardımı istediğinizden emin misiniz?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, güncellemek istiyorum!',
                cancelButtonText: 'Hayır',
                showLoaderOnConfirm: false,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $("#editAllInputForm").submit();
                    });
                },
                allowOutsideClick: false
            });

        },
    };

    guncelle1.init();
</script>

@stop