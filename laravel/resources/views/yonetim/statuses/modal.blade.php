<div class="modal fade" id="helpTypeEdit" tabindex="-1" role="dialog" aria-labelledby="helpTypeEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Durum Bilgisi Güncelle</h5>
            </div>
            <div class="modal-body">
                <form id="helpTypeEditForm" action="{{ route('statuses.update') }} " method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Durum Bilgisi</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div id="name_alert" class="alert alert-danger" role="alert" style="display: none">
                        Durum Bilgisi alanını boş bırakamazsınız.
                    </div>


                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">İlgili yardım talebini kapatıyor mu?</label>
                        <select id="finisher" name="finisher" class="form-control">
                            <option value="1">Evet</option>
                            <option value="0">Hayır</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="guncelle" type="button" class="btn btn-success" >
                    <i class="fa fa-check"></i> Güncelle
                </button>
                <button type="button" id="help_type_edit_cancel" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="helpTypeAdd" tabindex="-1" role="dialog" aria-labelledby="helpTypeAddLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Durum Bilgisi Ekle</h5>
            </div>
            <div class="modal-body">
                <form id="helpTypeAddForm" action="{{ route('statuses.store') }} " method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Durum Bilgisi</label>
                        <input type="text" class="form-control" id="nameAdd" name="name">
                    </div>
                    <div id="name_add_alert" class="alert alert-danger" role="alert" style="display: none">
                        Durum Bilgisi alanını boş bırakamazsınız.
                    </div>


                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">İlgili yardım talebini kapatıyor mu?</label>
                        <select id="finisher" name="finisher" class="form-control">
                            <option value="1">Evet</option>
                            <option value="0">Hayır</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="ekle" type="button" class="btn btn-success" >
                    <i class="fa fa-check"></i> Ekle
                </button>
                <button type="button" id="help_type_add_cancel" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
            </div>
        </div>
    </div>
</div>




