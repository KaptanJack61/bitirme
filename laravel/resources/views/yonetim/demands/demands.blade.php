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
            <h1 class="m-0 text-dark">Yardım Talepleri
                <a href="{{ route('yardimtalebi.storeIndex')  }}" class="btn btn-success">
                    <i class="fa fa-plus"></i> Yardım Talebi Ekle
                </a> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/anasayfa">Yönetim Paneli</a></li>
              <li class="breadcrumb-item active">Yardım Talepleri</li>
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
            <table id="yardimlar" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th class="text-center">#</th>
                  <th>Ad Soyad</th>
                  <th>Telefon</th>
                <th>Adet</th>
                <th>Adres</th>
                <th class="text-center">Tarihi</th>
                <th class="text-right">İşlemler</th>
              </tr>
              </thead>
              <tbody>
              @foreach($demands as $d)
                @php($dd = Helpers::getDemandsDetails($d->id))
                <tr>
                  <td class="text-center">{{ $d->id }}</td>
                  <td>{{ $dd['full_name'] }}</td>
                    <td>{{Helpers::phoneTextFormat($d->phone)}}</td>
                    <td>{{ count(json_decode($d->helps)) }}</td>
                    <td>{{ $dd['address'] }}</td>
                  <td class="text-center">{{ date('d.m.Y', strtotime($d->created_at)) }}</td>
                  <td class="text-right">
                    <a id="duzenle" href="{{route('yardimtalebi.all.updateIndex',['id'=>$d->id])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Düzenle">
                      <i class="fa fa-edit"></i>
                    </a>

                      <a id="sil" href="{{route('yardimtalebi.all.destroy',['id'=>$d->id])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Sil">
                          <i class="fa fa-trash"></i>
                      </a>

                    <a id="goruntule" href="{{route('yardimtalebi.all.detail',['id'=>$d->id])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Görüntüle">
                      <i class="fa fa-eye"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
              </tbody>
              <tfoot>
              <th class="text-center">#</th>
              <th>Ad Soyad</th>
              <th>Telefon</th>
              <th>Adet</th>
              <th>Adres</th>
              <th class="text-center">Tarihi</th>
              <th class="text-right">İşlemler</th>
              </tfoot>
            </table>
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
<br /><br /><br /><br />
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
            },
            "order": [[ 6, "desc" ]]
        });
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



@stop