@extends('yonetim.layouts.master')

{{ dd($request['neighborhood'][0]) }}

@section('title','Rapor Sonuç | '.config('app.name'))
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
                    <h1 class="m-0 text-dark">Rapor Sonuçları</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('yonetim.anasayfa') }}">Yardım Masası</a></li>
                        <li class="breadcrumb-item">Yardım Talepleri</li>
                        <li class="breadcrumb-item">Raporlar</li>
                        <li class="breadcrumb-item active">Rapor Sonuç</li>
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
             <table class="table table-bordered table-striped" id="helps-table" width="100%">
                 <thead>
                     <tr>
                         <td>Y.No</td>
                         <td>Ad Soyad</td>
                         <td>Telefon</td>
                         <td>Yardım Türü</td>
                         <td>Miktarı</td>
                         <td>Mahalle</td>
                         <td>Cadde & Sokak</td>
                         <td>Durum</td>
                         <td>K. Tarih</td>
                         <td>Son İşl. Tar.</td>
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
@include('yonetim.demands.modal')

@stop

@section('script')
<script src="/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="/js/plugins/datatables/dataTables.bootstrap4.js"></script>
<script src="/js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/js/plugins/datepicker/locales/bootstrap-datepicker.tr.js"></script>

<script type="text/javascript">


    $("#helps-table").DataTable({
        processing: true,
        serverSide: true,
        ajax : {
            url: '{{ route('report.createReportNoFilter') }}',
            method: 'post',
            data: {
                neighborhood: {{
                    $request['neighborhood']
                }},
                allneighborhood: '{{ $request['allneighborhood'] }}',
                helptypes: '{{ $request['helptypes'] }}',
                allhelptypes: '{{ $request['allhelptypes'] }}',
                statuses: '{{ $request['statuses'] }}',
                situation: '{{ $request['situation'] }}',
                first_date: '{{ $request['first_date'] }}',
                last_date: '{{ $request['last_date'] }}',
            }
        },
        order: [[ 8, "desc" ]],
        columns: [
            { data: 'id', name:'id'},
            { data: 'DT_RowData.full_name', name:'helps.first_name'},
            { data: 'DT_RowData.phone', name:'helpsphone'},
            { data: 'DT_RowData.help_types', name:'type.name'},
            { data: 'DT_RowData.quantity', name:'helpsquantity'},
            {data: 'DT_RowData.neighborhood',name: 'neighborhood.name'},
            { data: 'DT_RowData.street', name:'helps.street'},
            { data: 'DT_RowData.status', name:'helps.status.name'},
            { data: 'DT_RowData.date', name:'helps.created_at'},
            { data: 'DT_RowData.udate', name:'helps.updated_at'}
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

<script>
    $('#helpEdit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var quantity = button.data('quantity') // Extract info from data-* attributes
        var metrik = button.data('metrik')
        var helptypeid = button.data('helptypeid')
        var name = button.data('name')
        var neighborhoodid = button.data('neighborhoodid')
        var neighborhoodname = button.data('neighborhoodname')
        var street = button.data('street')
        var cityname = button.data('cityname')
        var gateno = button.data('gateno')
        var statsusid = button.data('statusid')
        var statusname = button.data('statusname')
        var helpid = button.data('helpid')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#modal-title-edit').text(helpid + " No'lu yardımı düzenliyorsunuz!")
        modal.find('#quantityLabel').text('Miktar (' + metrik + ')')
        modal.find('.modal-body #quantity').val(quantity)
        $('#helpTypes').append("<option id='helptypeid' value='" + helptypeid + "' selected>" + name + "</option>");
        $('#status').append("<option id='statusid' value='" + statsusid + "' selected>" + statusname + "</option>");
        $('#neighborhood').append("<option id='neighborhoodid' value='" + neighborhoodid + "' selected>" + neighborhoodname + "</option>");
        $('#street').val(street);
        $('#cityname').val(cityname);
        $('#gateno').val(gateno);
        $('#helpEditForm').append("<input type='hidden' id='helpid' name='helpId' value='" + helpid+ "' />");
    })

    $("#help_edit_cancel").click(function () {
        $('#helptypeid').remove();
        $('#statusid').remove();
        $('#helpid').remove();
        $('#neighborhoodid').remove();
    });

    $("#modaldismissedit").click(function () {
        $('#helptypeid').remove();
        $('#statusid').remove();
        $('#helpid').remove();
        $('#neighborhoodid').remove();
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
        var detail = button1.data('detail')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        $('#detail').val(detail);
        $('#modal-title-complete').text('Yardım Talebi Kapat: '+helpid)
        $('#complete').append("<input id='helpid' type='hidden' name='helpId' value='" + helpid + "' />");
    })

    $( "#complete-cancel" ).click(function() {
        $( "#helpid" ).remove();

    });

    $( "#modal-title-complete" ).click(function() {
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
    $('#deleted').on('show.bs.modal', function(event) {
        var button1 = $(event.relatedTarget) // Button that triggered the modal
        // Extract info from data-* attributes
        var helpid = button1.data('helpid')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        $('#delete').append("<a href='/yapilanyardim/sil/"+ helpid +"' type='button' id='deleteok' class='btn btn-primary'>" +
            "<i class='fa fa-check'> </i> Evet Silmek İstiyorum</a>"
        );
    })

    $( "#deletecancel" ).click(function() {
        $( "#deleteok" ).remove();

    });
</script>

<script type="text/javascript">
    var deneme = {
        linkSelector : "a#deneme",
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



    editer.init();
    deneme.init();
</script>

<script type="text/javascript">
    $('#first-date').mask('00.00.0000')
    $('#last-date').mask('00.00.0000')
    $('#first-date').datepicker({
        format: 'dd.mm.yyyy',
        autoclose: false,
        language: 'tr'
    });
    $('#last-date').datepicker({
        format: 'dd.mm.yyyy',
        autoclose: false,
        language: 'tr'
    });

</script>

@stop