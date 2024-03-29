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
            <table id="yardimlar" class="table table-bordered table-striped" width="100%">
              <thead>
              <tr>
                <th class="text-center">#</th>
                  <th>Ad Soyad</th>
                  <th>Telefon</th>
                  <th>Adet</th>
                  <th>Mahalle</th>
                  <th>Adres</th>
                  <th>Durum</th>
                  <th>Kayıt Tarihi</th>
                  <th>Son İşlem Tarihi</th>
                  <th>İşlemler</th>
              </tr>
              </thead>
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

@include('yonetim.demands.modal')

@section('script')
<script src="/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="/js/plugins/datatables/dataTables.bootstrap4.js"></script>
<script type="text/javascript">
    $("#yardimlar").DataTable({
        processing: true,
        serverSide: true,
        ajax : '{{ route('yardimtalepleri.getDemands') }}',
        order: [[ 0, "desc" ]],
        columns: [
            { data: 'id', name:'id'},
            { data: 'DT_RowData.full_name', name:'people.first_name'},
            { data: 'DT_RowData.phone', name:'people.phone'},
            { data: 'DT_RowData.sum', searchable: false, orderable: false},
            { data: 'DT_RowData.neighborhood',name: 'neighborhoods.name'},
            { data: 'DT_RowData.street', name:'people.street'},
            { data: 'status', searchable: false, orderable: false},
            { data: 'DT_RowData.date', name:'created_at'},
            { data: 'DT_RowData.udate', name:'updated_at'},
            { data: 'islemler', name: 'islemler', orderable: false, searchable: false}
        ],
        language: {
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

    $('#deleted').on('show.bs.modal', function(event) {
        var button1 = $(event.relatedTarget) // Button that triggered the modal
        // Extract info from data-* attributes
        var demandid = button1.data('demandid')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        $('#delete').append("<a href='/yardimtalebi/sil/"+ demandid +"' type='button' id='deleteok' class='btn btn-primary'>" +
            "<i class='fa fa-check'> </i> Evet Silmek İstiyorum</a>"
        );
    })

    $( "#deletecancel" ).click(function() {
        $( "#deleteok" ).remove();

    });
</script>



@stop