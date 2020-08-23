@extends('yonetim.layouts.master')

@section('title', 'Talep No: '.$demand->id.' | '.config('app.name'))
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
            <h1 class="m-0 text-dark">Yardım Talebi No: {{ $demand->id }}
                </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/anasayfa">Yardım Masası</a></li>
              <li class="breadcrumb-item">Yardım Ara</li>
                <li class="breadcrumb-item">Yardım Talebi Numarası</li>
                <li class="breadcrumb-item active">{{$demand->id}}</li>
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
                  <th>Yardım Sayısı</th>
                  <th>Mahalle</th>
                  <th>Cadde & Sokak</th>
                <th class="text-center">K. Tarihi</th>
                  <th class="text-center">Son İşlem Tar.</th>
                  <th>Durum</th>
                <th class="text-right">İşlemler</th>
              </tr>
              </thead>
              <tbody>
               <tr>
               <tr>
                   <td class="text-center">{{ $demand->id }}</td>
                   <td>{{ $full_name }}</td>
                   <td>{{ $phone }}</td>
                   <td>{{ $count }} adet</td>
                   <td>{{ $neighborhood }}</td>
                   <td>{{ $address }}</td>
                   <td class="text-center">{{ date('d.m.Y', strtotime($demand->created_at)) }}</td>
                   <td class="text-center">{{ date('d.m.Y', strtotime($demand->updated_at)) }}</td>

                   @if ($closed == $count)
                       <td><h5><span class="badge badge-pill badge-secondary">Tamamlandı</span></h5></td>
                   @elseif ($open == $count)
                       <td><h5><span class="badge badge-pill badge-success">İşleme Alındı</span></h5></td>
                   @else
                       <td><h5><span class="badge badge-pill badge-warning">{{ $closed }} Adet Tamamlandı</span></h5></td>
                   @endif

                   <td class="text-right">
                       <a id="duzenle" href="{{route('yardimtalebi.all.updateIndex',['id'=>$demand->id])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Düzenle">
                           <i class="fa fa-edit"></i>
                       </a>

                       <a id="sil" href="{{route('yardimtalebi.all.destroy',['id'=>$demand->id])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Sil">
                           <i class="fa fa-trash"></i>
                       </a>

                       <a id="goruntule" href="{{route('yardimtalebi.all.detail',['id'=>$demand->id])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Görüntüle">
                           <i class="fa fa-eye"></i>
                       </a>
                   </td>
               </tr>
              </tbody>
              <tfoot>
              <tr>
                  <th>#</th>
                  <th>Ad Soyad</th>
                  <th>Telefon</th>
                  <th>Yardım Sayısı</th>
                  <th>Mahalle</th>
                  <th>Cadde & Sokak</th>
                  <th class="text-center">K. Tarihi</th>
                  <th class="text-center">Son İşlem Tar.</th>
                  <th>Durum</th>
                  <th class="text-right">İşlemler</th>
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
<br /><br /><br /><br />
@include('yonetim.demands.modal')

@stop

@section('script')
<script src="/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="/js/plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
        $("#yardimlar").DataTable({
            processing: true,
            serverSide: false,
            order: [[ 7, "desc" ]],
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
        });
    });
</script>

<script>
    $('#helpEdit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var quantity = button.data('quantity') // Extract info from data-* attributes
        var metrik = button.data('metrik')
        var helptypeid = button.data('helptypeid')
        var name = button.data('name')
        var statsusid = button.data('statusid')
        var statusname = button.data('statusname')
        var helpid = button.data('helpid')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#quantityLabel').text('Miktar (' + metrik + ')')
        modal.find('.modal-body #quantity').val(quantity)
        $('#helpTypes').append("<option id='helptypeid' value='" + helptypeid + "' selected>" + name + "</option>");
        $('#status').append("<option id='statusid' value='" + statsusid + "' selected>" + statusname + "</option>");
        $('#helpEditForm').append("<input type='hidden' id='helpid' name='helpId' value='" + helpid+ "' />");
    })

    $("#help_edit_cancel").click(function () {
        $('#helptypeid').remove();
        $('#statusid').remove();
        $('#helpid').remove();
    });

    $("#quantity").focusout(function () {
        var data = $("#quantity").val();
        if (data == "" || data == 0) {
            $('#quantity_alert').show();
        } else {
            $('#quantity_alert').hide();
        }
    });

    var guncelle = {
        linkSelector: "#guncelle",
        init: function() {
            $(this.linkSelector).on('click', {
                self: this
            }, this.handleClick);
        },
        handleClick: function(event) {
            event.preventDefault();
            var data = $("#quantity").val();
            if (data == "" || data == 0) {
                $('#quantity_alert').show();
            } else {
                $('#quantity_alert').hide();
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
                            $("#helpEditForm").submit();
                        });
                    },
                    allowOutsideClick: false
                });
            }

        },
    };

    guncelle.init();
</script>

<script>
    $('#completed').on('show.bs.modal', function(event) {
        var button1 = $(event.relatedTarget) // Button that triggered the modal
        // Extract info from data-* attributes
        var helpid = button1.data('helpid')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        $('#complete').append("<input id='helpid' type='hidden' name='helpId' value='" + helpid + "' />");
    })

    $( "#complete-cancel" ).click(function() {
        $( "#helpid" ).remove();

    });

    var tamamla = {
        linkSelector: "button#tamamla",
        init: function() {
            $(this.linkSelector).on('click', {
                self: this
            }, this.handleClick);
        },
        handleClick: function(event) {
            event.preventDefault();
            swal({
                title: 'Yardım talebini kapatmak istediğinizden emin misiniz?',
                text: "Yardımı istediğinizden emin misiniz?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, kapatmak istiyorum!',
                cancelButtonText: 'Hayır',
                showLoaderOnConfirm: false,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $("#complete").submit();
                    });
                },
                allowOutsideClick: false
            });
        },
    };

    tamamla.init();

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