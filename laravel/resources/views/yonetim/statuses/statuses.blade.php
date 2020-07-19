@extends('yonetim.layouts.master')

@section('title','Durum Bilgileri | '.config('app.name'))
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
            <h1 class="m-0 text-dark">Durum Bilgileri
                <a href="#" class="btn btn-success" data-toggle="modal"
                   data-target="#helpTypeAdd"

                >
                    <i class="fa fa-plus"></i> Durum Bilgisi Ekle
                </a> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/anasayfa">Yardım Masası</a></li>
              <li class="breadcrumb-item active">Durum Bilgileri</li>
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
            <table id="helptypestable" class="table table-bordered table-striped">
              <thead>
              <tr>
                  <td style="width: 40px">#</td>
                <th style="width: 150px">Durum Bilgisi</th>
                  <th class="text-center">İlgili yardım talebini kapatıyor mu?</th>
                <th class="text-center" style="width: 130px">İşlemler</th>
              </tr>
              </thead>
              <tbody>
              @foreach($statuses as $s)
                <tr>
                    <td class="text-center">{{ $s->id }}</td>
                    <td>{{ $s->name }}</td>
                    <td  class="text-center">
                        @if($s->finisher == true)
                            Evet
                        @else
                            Hayır
                        @endif
                    </td>
                  <td class="text-center">
                      <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                         data-target="#helpTypeEdit"
                         data-statusid="{{$s->id}}"
                         data-name="{{$s->name}}"
                         data-finisher="{{$s->finisher}}"
                      >
                          <i class="fa fa-edit"></i>
                      </a>
                      <a id="sil" href="{{ route('statuses.destroy',['id' => $s->id]) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Sil">
                          <i class="fa fa-trash"></i>
                      </a>
                    <a id="goruntule" href="{{ route('statuses.showByAllHelps',['id' => $s->id]) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Görüntüle">
                      <i class="fa fa-eye"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
              </tbody>
              <tfoot>
              <tr>
                  <th>#</th>
                  <th>Durum Bilgisi</th>
                  <th class="text-center" style="width: 100px">İlgili yardım talebini kapatıyor mu?</th>
                  <th class="text-center" style="width: 150px">İşlemler</th>
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
<br/><br /><br /><br />

@include('yonetim.statuses.modal')

@stop

@section('script')
<script src="/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="/js/plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
        $("#helptypestable").DataTable({
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
                },
                "order": [[ 0, "desc" ]],
            }
        });
    });
</script>

<script type="text/javascript">
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
                text: "Yardım türü silinecek. Bu işlemin geri dönüşü yok!",
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

    deleter.init();
</script>

<script>
    $('#helpTypeEdit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
         // Extract info from data-* attributes
        var statusid = button.data('statusid')
        var name = button.data('name')
        var finisher = button.data('finisher')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('"' +name + '" Güncelle')
        modal.find('.modal-body #name').val(name)
        if (finisher == 1) {
            $('#finisher').append("<option id='control-modal' value='"+ finisher +"' selected>Evet</option>");
        }else {
            $('#finisher').append("<option id='control-modal' value='"+ finisher +"' selected>Hayır</option>");
        }
        $('#helpTypeEditForm').append("<input type='hidden' id='statusid' name='statusId' value='" + statusid + "' />");
    })

    $("#help_type_edit_cancel").click(function () {
        $('#statusid').remove();
        $('#control-modal').remove();
    });

    $("#name").focusout(function () {
        var data = $("#name").val();
        if (data == "") {
            $('#name_alert').show();
        } else {
            $('#name_alert').hide();
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
            var name = $("#name").val();
            if (name == "") {
                $('#name_alert').show();
            } else {

                    $('#name_alert').hide();

                    swal({
                        title: 'Güncellemek istediğinize emin misiniz?',
                        text: "Durum bilgisini güncellemek istediğinize emin misiniz?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Evet, güncellemek istiyorum!',
                        cancelButtonText: 'Hayır',
                        showLoaderOnConfirm: false,
                        preConfirm: function() {
                            return new Promise(function(resolve) {
                                $("#helpTypeEditForm").submit();
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
    $('#helpTypeAdd').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        // Extract info from data-* attributes


        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)


    })

    $("#help_type_add_cancel").click(function () {
        $('#control-modal').remove();
    });

    $("#nameAdd").focusout(function () {
        var data = $("#nameAdd").val();
        if (data == "") {
            $('#name_add_alert').show();
        } else {
            $('#name_add_alert').hide();
        }
    });

    var ekle = {
        linkSelector: "#ekle",
        init: function() {
            $(this.linkSelector).on('click', {
                self: this
            }, this.handleClick);
        },
        handleClick: function(event) {
            event.preventDefault();
            var name = $("#nameAdd").val();
            if (name == "") {
                    $('#name_add_alert').show();
            } else {
                    $('#name_alert').hide();
                    swal({
                        title: 'Eklemek istediğinize emin misiniz?',
                        text: "Yardım türünü eklemek istediğinize emin misiniz?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Evet, güncellemek istiyorum!',
                        cancelButtonText: 'Hayır',
                        showLoaderOnConfirm: false,
                        preConfirm: function() {
                            return new Promise(function(resolve) {
                                $("#helpTypeAddForm").submit();
                            });
                        },
                        allowOutsideClick: false
                    });


            }

        },
    };

    ekle.init();
</script>


@stop