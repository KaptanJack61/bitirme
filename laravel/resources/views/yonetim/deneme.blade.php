@extends('yonetim.layouts.master')

@section('title','Deneme | '.config('app.name'))

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
                        <h1 class="m-0 text-dark">Deneme Ekranı</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/kontrolpaneli/anasayfa">Yönetim Paneli</a></li>
                            <li class="breadcrumb-item active">Deneme Ekranı</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <form role="form" id="yazilar" method="post" name="yazi" action="/kontrolpaneli/deneme/dosya"
              enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="file"
                   id="avatar" name="avatar"
            >

            <button type="submit" value="Submit">Submit</button>
        </form>

        <!-- Main content -->
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">


                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12">
                                <label>Açıklama</label>
                                <div class="form-group">
                                    <textarea id="editor1" name="aciklama" style="width: 100%"></textarea>
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-12">
                                <label>Açıklama</label>
                                <div class="form-group">
                                    <textarea id="editor2" name="aciklama" style="width: 100%"></textarea>
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="input-group">
   <span class="input-group-btn">
     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
       <i class="fa fa-picture-o"></i> Dosya seç
     </a>
   </span>
                                <input id="thumbnail" class="form-control" type="text" name="filepath">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;">


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

    @include('yonetim.layouts.partials.ckeditor')

    <script>
        ClassicEditor
            .create(document.querySelector('#editor2'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                link: {
                    options: [
                        {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                        {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                        {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'},
                    ]
                },
            })
            .catch(error => {
                console.log(error);
            });
    </script>



@stop
