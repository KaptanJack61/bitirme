@extends('yonetim.layouts.master')

@section('title','Yardım Türleri | '.config('app.name'))
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
            <h1 class="m-0 text-dark">Yardım Türleri
                <a href="#" class="btn btn-success" data-toggle="modal"
                   data-target="#helpTypeAdd"

                >
                    <i class="fa fa-plus"></i> Yardım Türü Ekle
                </a> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/anasayfa">Yardım Masası</a></li>
              <li class="breadcrumb-item active">Yardım Türleri</li>
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
                <th class="text-center" style="width: 70px">#</th>
                <th>Yardım Türü</th>
                  <th class="text-center" style="width: 100px">Metrik</th>
                <th class="text-center" style="width: 120px">Kontrol Var mı?</th>
                <th class="text-center" style="width: 150px">İşlemler</th>
              </tr>
              </thead>
              <tbody>
              @foreach($helpTypes as $ht)
                <tr>
                  <td class="text-center">{{ $ht->id }}</td>
                    <td>{{ $ht->name }}</td>
                    <td>{{ $ht->metrik }}</td>
                    <td  class="text-center">
                        @if($ht->isSingle == true)
                            Evet
                        @else
                            Hayır
                        @endif
                    </td>
                  <td class="text-center">
                      <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                         data-target="#helpTypeEdit"
                         data-metrik="{{$ht->metrik}}"
                         data-helptypeid="{{$ht->id}}"
                         data-name="{{$ht->name}}"
                         data-control="{{$ht->isSingle}}"
                      >
                          <i class="fa fa-edit"></i>
                      </a>
                      <a id="sil" href="{{ route('yardimturu.destroy',['id' => $ht->id]) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Sil">
                          <i class="fa fa-trash"></i>
                      </a>
                    <a id="goruntule" href="{{ route('yardimturu.showByAllHelps',['id' => $ht->id]) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Görüntüle">
                      <i class="fa fa-eye"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
              </tbody>
              <tfoot>
              <tr>
                  <th class="text-center">#</th>
                  <th>Yardım Türü</th>
                  <th>Metrik</th>
                  <th>Kontrol Var mı?</th>
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
<br/><br /><br /><br />

@include('yonetim.helptypes.modal')

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
        var metrik = button.data('metrik')
        var helptypeid = button.data('helptypeid')
        var name = button.data('name')
        var control = button.data('control')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body #metrik').val(metrik)
        modal.find('.modal-title').text(name + ' Güncelle')
        modal.find('.modal-body #name').val(name)
        if (control == 1) {
            $('#isSingle').append("<option id='control-modal' value='"+ control +"' selected>Evet</option>");
        }else {
            $('#isSingle').append("<option id='control-modal' value='"+ control +"' selected>Hayır</option>");
        }
        $('#helpTypeEditForm').append("<input type='hidden' id='helptypeid' name='helpId' value='" + helptypeid+ "' />");
    })

    $("#help_type_edit_cancel").click(function () {
        $('#helptypeid').remove();
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

    $("#metrik").focusout(function () {
        var data = $("#metrik").val();
        if (data == "") {
            $('#metrik_alert').show();
        } else {
            $('#metrik_alert').hide();
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
            var metrik = $("#metrik").val();
            if (name == "") {
                if (metrik == ""){
                    $('#name_alert').show();
                    $('#metrik_alert').show();
                }else {
                    $('#name_alert').show();
                    $('#metrik_alert').hide();
                }

            } else {
                if(metrik == ""){
                    $('#name_alert').hide();
                    $('#metrik_alert').show();
                }else {
                    $('#name_alert').hide();
                    $('#metrik_alert').hide();
                    swal({
                        title: 'Güncellemek istediğinize emin misiniz?',
                        text: "Yardım türünü güncellemek istediğinize emin misiniz?",
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

    $("#metrikAdd").focusout(function () {
        var data = $("#metrikAdd").val();
        if (data == "") {
            $('#metrik_add_alert').show();
        } else {
            $('#metrik_add_alert').hide();
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
            var metrik = $("#metrikAdd").val();
            if (name == "") {
                if (metrik == ""){
                    $('#name_add_alert').show();
                    $('#metrik_add_alert').show();
                }else {
                    $('#name_add_alert').show();
                    $('#metrik_add_alert').hide();
                }

            } else {
                if(metrik == ""){
                    $('#name_add_alert').hide();
                    $('#metrik_add_alert').show();
                }else {
                    $('#name_alert').hide();
                    $('#metrik_add_alert').hide();
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
            }

        },
    };

    ekle.init();
</script>


@stop