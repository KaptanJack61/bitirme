@extends('yonetim.layouts.master')

@section('title', 'Y.No: '.$helps[0]->id.' | '.config('app.name'))
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
            <h1 class="m-0 text-dark">Yardım No: {{ $helps[0]->id }}
                </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/anasayfa">Yardım Masası</a></li>
              <li class="breadcrumb-item">Yardım Ara</li>
                <li class="breadcrumb-item">Yapılan Yardım Numarası</li>
                <li class="breadcrumb-item active">{{$helps[0]->id}}</li>
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
                  <th>Yardım Türü</th>
                  <th>Miktarı</th>
                  <th>Mahalle</th>
                  <th>Cadde & Sokak</th>
                  <th>Durum</th>
                <th class="text-center">K. Tarihi</th>
                  <th class="text-center">Son İşlem Tar.</th>
                <th class="text-right">İşlemler</th>
              </tr>
              </thead>
              <tbody>

              @foreach($helps as $help)

               <tr data-toggle="tooltip" data-placement="top" title="{{ $help->detail }}">

                  <td class="text-center">{{ $help->id }}</td>
                  <td>{{ $help->first_name." ".$help->last_name }}</td>
                        <td>{{ Helpers::phoneTextFormat($help->phone) }}</td>
                    <td>{{ $help->type->name }}</td>
                    <td>{{ $help->quantity." ".$help->type->metrik }}</td>
                    <td>{{ $help->neighborhood }}</td>
                    <td>
                        {{ $help->street." ".$help->cty_name. " No:".$help->gate_no  }}
                    </td>
                   <td>
                       @if($help->status->finisher == false and $help->status->id == 1)
                           <h5><span class="badge badge-pill badge-success">{{ $help->status->name }}</span></h5>
                       @elseif($help->status->finisher == true and $help->status->id == 5)
                           <h5><span class="badge badge-pill badge-danger">{{ $h->status->name }}</span></h5>
                       @elseif($help->status->finisher == false and $help->status->id != 1)
                           <h5><span class="badge badge-pill badge-warning">{{ $help->status->name }}</span></h5>
                       @elseif($help->status->finisher == true and $help->status->id != 5)
                           <h5><span class="badge badge-pill badge-secondary">{{ $help->status->name }}</span></h5>
                       @endif
                   </td>
                  <td class="text-center">{{ date('d.m.Y', strtotime($help->created_at)) }}</td>
                        <td class="text-center">{{ date('d.m.Y', strtotime($help->updated_at)) }}</td>
                  <td class="text-center">
                    @if($help->status->finisher==false)
                          <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                             data-target="#completed"
                             data-helpid="{{$help->id}}"
                          >
                              <i class="fa fa-check"></i>
                          </a>
                          <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                             data-target="#helpEdit"
                             data-helpid="{{$help->id}}"
                             data-quantity="{{$help->quantity}}"
                             data-metrik="{{$help->type->metrik}}"
                             data-helptypeid="{{$help->type->id}}"
                             data-name="{{$help->type->name}}"
                             data-statusid="{{$help->status->id}}"
                             data-statusname="{{$help->status->name}}"
                             data-street="{{$help->street}}"
                             data-cityname="{{$help->city_name}}"
                             data-gateno="{{$help->gate_no}}"
                          >
                              <i class="fa fa-edit"></i>
                          </a>

                          <a id="sil" href="{{route('yardimtalebi.destroy',['id'=>$help->id])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Sil">
                              <i class="fa fa-trash"></i>
                          </a>
                      @else
                          <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                             data-target="#completed"
                             data-helpid="{{$help->id}}"
                          >
                              <i class="fa fa-edit"></i>
                          </a>
                      @endif
                      <a id="copy" href="{{route('yardimtalebi.copyHelpInfo',['id'=>$help->id])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Kopyala">
                          <i class="fa fa-copy"></i>

                  </td>
                </tr>
               @endforeach
              </tbody>
              <tfoot>
              <tr>
                  <th>#</th>
                  <th>Ad Soyad</th>
                  <th>Telefon</th>
                  <th>Yardım Türü</th>
                  <th>Miktarı</th>
                  <th>Mahalle</th>
                  <th>Cadde & Sokak</th>
                  <th>Durum</th>
                  <th class="text-center">K. Tarihi</th>
                  <th class="text-center">Son İşlem Tar.</th>
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
            serverSide: false,
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
            "order": [[ 0, "desc" ]],
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
        var street = button.data('street')
        var cityname = button.data('cityname')
        var gateno = button.data('gateno')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#quantityLabel').text('Miktar (' + metrik + ')')
        modal.find('.modal-body #quantity').val(quantity)
        modal.find('.modal-body #street').val(street)
        modal.find('.modal-body #cityname').val(cityname)
        modal.find('.modal-body #gateno').val(gateno)
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