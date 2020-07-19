@extends('yonetim.layouts.master')

@section('title','Kullanıcılar | '.config('app.name'))
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
            <h1 class="m-0 text-dark">Kullanıcılar
                <a href="{{ route('yonetim.kullanicilar.ekle') }}" class="btn btn-success">
                    <i class="fa fa-plus"></i> Kullanıcı Ekle
                </a> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/anasayfa">Yardım Masası</a></li>
              <li class="breadcrumb-item active">Kullanıcılar</li>
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
            <table id="kullanicilar" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th class="text-center">#</th>
                  <th class="text-center">Foto</th>
                <th>Ad Soyad</th>
                  <th>Mail</th>
                <th>Aktif</th>
                  <th>Yönetici</th>
                <th class="text-center">Kayıt Tarihi</th>
                <th class="text-center">İşlemler</th>
              </tr>
              </thead>
              <tbody>
              @php($x=1)
              @foreach($kullanicilar as $kullanici)
                <tr>
                  <td class="text-center">{{ $x }}</td>
                  <td class="text-center"><img id="holder" src="{{url($kullanici->photo)}}" width="30" height="30"></td>
                    <td>{{ $kullanici->name }}</td>
                    <td>{{ $kullanici->email }}</td>
                    <td>
                        @if($kullanici->active==0)
                            Pasif
                        @else
                            Aktif
                        @endif
                    </td>
                    <td>
                        @if($kullanici->admin==1)
                            Admin
                        @else
                            Normal
                        @endif
                    </td>
                  <td class="text-center">{{ date('d.m.Y', strtotime($kullanici->created_at)) }}</td>
                  <td class="text-center">
                    <a id="duzenle" href="/kullanicilar/duzenle/{{ $kullanici->id }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Düzenle">
                      <i class="fa fa-edit"></i>
                    </a>
                      @if($kullanici->id != Auth::guard('yonetim')->user()->id)
                      <a id="sil" href="/kullanicilar/sil/{{ $kullanici->id }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Sil">
                          <i class="fa fa-trash"></i>
                      </a>
                      @endif
                    <a id="goruntule" target="_blank" href="/kullanici/{{ $kullanici->slug }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Görüntüle">
                      <i class="fa fa-eye"></i>
                    </a>
                  </td>
                </tr>
                @php($x++)
              @endforeach
              </tbody>
              <tfoot>
              <tr>
                  <th class="text-center">#</th>
                  <th>Foto</th>
                  <th>Ad Soyad</th>
                  <th>Mail</th>
                  <th>Aktif</th>
                  <th>Yönetici</th>
                  <th class="text-center">Kayıt Tarihi</th>
                  <th class="text-center">İşlemler</th>
              </tr>
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

@stop

@section('script')
<script src="/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="/js/plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
        $("#kullanicilar").DataTable({
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
                text: "Kullanıcı düzenleme ekranına yönlendirileceksiniz?",
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
                text: "Kullanıcı silinecek. Bu işlemin geri dönüşü yok!",
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