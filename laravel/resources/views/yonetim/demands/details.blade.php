@extends('yonetim.layouts.master') @section('title','Yardım Talebi | '.config('app.name')) @section('header')

    <link rel="stylesheet" href="/css/plugins/datatables/dataTables.bootstrap4.css"> @stop @section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Yardım Talebi
                        </h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/anasayfa">Yönetim Paneli</a></li>
                            <li class="breadcrumb-item">Yardım Talepleri</li>
                            <li class="breadcrumb-item">Yardım Talebi Ekle</li>
                            <li class="breadcrumb-item active">Yardım Talebi</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
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
                                        <span class="text-black text-bold font-size-2"><h5>{{ $detail }}</h5></span>
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

                                    @if ($closed == false)
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

                                            <a id="delete" href="{{route('yardimtalebi.all.destroy',['id'=>$demand_no])}}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Sil">
                                                <i class="fa fa-trash"></i> Sil
                                            </a>

                                            <a id="kapatma" href="#" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Hepsini kapat">
                                                <i class="fa fa-reply-all"></i> Toplu Kapatma
                                            </a>

                                        </div>
                                    @endif


                                    <br />
                                    <table id="yardimlar" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="width: 60px">#</th>
                                            <th style="width: 150px">Yardım Türü</th>
                                            <th>Miktar</th>
                                            <th style="width: 150px;">Kayıt Tarihi</th>
                                            <th style="width: 150px;">Son İşlem Tarihi</th>
                                            <th style="width: 150px">Durum</th>
                                            <th class="text-right islemler" style="width: 150px;">İşlemler</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($helpList as $h)
                                            <tr>
                                                <td class="text-center">{{ $h->id }}</td>
                                                <td>{{ $h->type->name }}</td>
                                                <td class="align-items-center">
                                                    @if ($h->status->finisher == true)
                                                        {{ $h->quantity." ".$h->type->metrik }}
                                                        <input type="hidden" class="form-control input-sm" name="{{ $h->id }}" value="{{ $h->quantity }}">
                                                    @else
                                                    <span id="miktar" class="onaylanan_miktar_span">{{ $h->quantity." ".$h->type->metrik }}</span>
                                                    <div class="row onaylanan_miktar_inputs" style="display: none">
                                                        <div class="col-2">
                                                            <input type="number" min="1" class="form-control input-sm" name="{{ $h->id }}" value="{{ $h->quantity }}" style="border-color: #0a90eb">
                                                        </div>
                                                        <div class="col-10"> {{  $h->type->metrik }} </div>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>{{ date('d.m.Y', strtotime($h->created_at)) }}</td>
                                                <td>{{ date('d.m.Y', strtotime($h->updated_at)) }}</td>
                                                <td>
                                                    @if($h->status->finisher == false and $h->status->id == 1)
                                                        <h5><span class="badge badge-pill badge-success">{{ $h->status->name }}</span></h5>
                                                    @elseif($h->status->finisher == true and $h->status->id == 5)
                                                        <h5><span class="badge badge-pill badge-danger">{{ $h->status->name }}</span></h5>
                                                    @elseif($h->status->finisher == false and $h->status->id != 1)
                                                        <h5><span class="badge badge-pill badge-warning">{{ $h->status->name }}</span></h5>
                                                    @elseif($h->status->finisher == true and $h->status->id != 5)
                                                        <h5><span class="badge badge-pill badge-secondary">{{ $h->status->name }}</span></h5>
                                                    @endif
                                                </td>




                                                <td class="text-center islemler">
                                                    @if ($h->status->finisher == false)

                                                        <a class="btn btn-success btn-sm" title="Tamamla" data-toggle="modal" data-target="#completed" data-helpid="{{$h->id}}">
                                                            <i class="fa fa-check"></i>
                                                        </a>

                                                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                                                           data-target="#helpEdit"
                                                           data-helpid="{{$h->id}}"
                                                           data-quantity="{{$h->quantity}}"
                                                           data-metrik="{{$h->type->metrik}}"
                                                           data-helptypeid="{{$h->type->id}}"
                                                           data-name="{{$h->type->name}}"
                                                           data-statusid="{{$h->status->id}}"
                                                           data-statusname="{{$h->status->name}}"
                                                        >
                                                            <i class="fa fa-edit"></i>
                                                        </a>

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
                                            <th>Miktar</th>
                                            <th>Durum</th>
                                            <th>Kayıt Tarihi</th>
                                            <th>Son İşlem Tarihi</th>
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
    <br/>
    <br/>
    <br/>
    <br/>
    @include('yonetim.demands.modal')
    @stop @section('script')
    <script src="/js/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/js/plugins/datatables/dataTables.bootstrap4.js"></script>
    <script>
        $(function() {
            $("#yardimlar").DataTable({
                "language": {
                    "lengthMenu": "Sayfada _MENU_ kayıt göster",
                    "infoEmpty": " Kayıt yok",
                    "search": "Ara:",
                    "decimal": ",",
                    "emptyTable": "Tabloda herhangi bir veri mevcut değil",
                    "info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                    "infoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
                    "infoPostFix": "",
                    "infoThousands": ".",
                    "loadingRecords": "Yükleniyor...",
                    "processing": "İşleniyor...",
                    "zeroRecords": "Eşleşen kayıt bulunamadı",
                    "paginate": {
                        "first": "İlk",
                        "last": "Son",
                        "next": "Sonraki",
                        "previous": "Önceki"
                    },
                    "aria": {
                        "sortAscending": ": artan sütun sıralamasını aktifleştir",
                        "sortDescending": ": azalan sütun soralamasını aktifleştir"
                    }
                }
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
    <script>
        var deleter = {
            linkSelector: "a#delete",
            init: function() {
                $(this.linkSelector).on('click', {
                    self: this
                }, this.handleClick);
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
                    cancelButtonText: 'Hayır',
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

        var sil = {
            linkSelector: "a#sil",
            init: function() {
                $(this.linkSelector).on('click', {
                    self: this
                }, this.handleClick);
            },
            handleClick: function(event) {
                event.preventDefault();
                var self = event.data.self;
                var link = $(this);
                swal({
                    title: 'Silmek istediğinize emin misiniz?',
                    text: "Yardım silinecek. Bu işlemin geri dönüşü yok!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, silmek istiyorum!',
                    cancelButtonText: 'Hayır',
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
        sil.init();

    </script>

    <script>
        $( "#editAllInputToggle" ).click(function() {
            $( ".onaylanan_miktar_span" ).toggle();
            $( ".onaylanan_miktar_inputs" ).toggle();
            $( "#editAllInputSubmit" ).toggle();
            $( "#editAllInputCancel" ).toggle();
            $( "#editAllInputToggle" ).toggle();
            $( "#editAllInputWithPerson" ).toggle();
            $( "#delete" ).toggle();
            $( ".islemler" ).toggle();

        });

        $( "#editAllInputCancel" ).click(function() {
            $( ".onaylanan_miktar_span" ).toggle();
            $( ".onaylanan_miktar_inputs" ).toggle();
            $( "#editAllInputSubmit" ).toggle();
            $( "#editAllInputCancel" ).toggle();
            $( "#editAllInputToggle" ).toggle();
            $( "#editAllInputWithPerson" ).toggle();
            $( "#delete" ).toggle();
            $( ".islemler" ).toggle();

        });




    </script>

    <script type="text/javascript">
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


    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            var data = $('#phone').val();
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            if (charCode == 48 && data.length == 0)
                return false;

            return true;
        }

        $('#quantity').focusout(function() {
            var data = $("#quantity").val();
            if (data == "") {
                $('#quantity_alert').show();
            } else {
                $('#quantity_alert').hide();
            }
        });
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