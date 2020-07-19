<div class="modal fade" id="helpEdit" tabindex="-1" role="dialog" aria-labelledby="helpEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modal-title-edit"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modaldismissedit">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="helpEditForm" action="{{ route('yapilanyardim.update') }} " method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Mahalle</label>
                        <select id="neighborhood" name="neighborhood" class="form-control">
                            @foreach($neighborhoods as $n)
                                <option value="{{$n->id}}">{{$n->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="message-text" class="col-form-label">Cadde & Sok.</label>
                            <input type="text" class="form-control" id="street" name="street" placeholder="Yıldız Sokak">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="message-text" class="col-form-label">Site Adı</label>
                            <input type="text" class="form-control" id="cityname" name="city_name" placeholder="Yaşam Sitesi">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="message-text" class="col-form-label">Kapı No</label>
                            <input type="text" class="form-control" id="gateno" name="gate_no" placeholder="8B">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Yardım Türü</label>
                        <select id="helpTypes" name="helpType" class="form-control">
                            @php($helpTypes = Helpers::getHelpTypes())
                            @foreach($helpTypes as $h)
                                <option value="{{$h->id}}">{{$h->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label" id="quantityLabel"></label>
                        <input type="number" min="1" class="form-control" id="quantity" name="quantity">
                    </div>
                    <div id="quantity_alert" class="alert alert-danger" role="alert" style="display: none">
                        Miktar alanını düzgün doldurmadınız
                        <ul>
                            <li>Miktar alanını boş bırakamazsını.</li>
                            <li>Miktar alanına 0 (sıfır) giremezsiniz.</li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">İşlem Durumu</label>
                        <select id="status" name="status" class="form-control">
                            @php($status = Helpers::getStatus())
                            @foreach($status as $s)
                                @if ($s->finisher == false)
                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="guncelle" type="button" class="btn btn-success" >
                    <i class="fa fa-check"></i> Güncelle
                </button>
                <button type="button" id="help_edit_cancel" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="completed" tabindex="-1" role="dialog" aria-labelledby="completedLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modal-title-complete"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modaldismisscomplete">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="complete" action="{{ route('yapilanyardim.complete') }} " method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Sonuçlandır</label>
                        @php($statuses = Helpers::getStatus())
                        <select id="helpTypes" name="helpType" class="form-control" required>
                            @foreach($statuses as $s)
                                @if($s->finisher == true)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Açıklama</label>
                        <textarea class="form-control" id="detail" width="100%" rows="4" name="detail"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="tamamla" type="button" class="btn btn-success" >
                    <i class="fa fa-check"></i> Tamamla
                </button>
                <button type="button" id="complete-cancel" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleted" tabindex="-1" role="dialog" aria-labelledby="deletedLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Silmek istediğinize emin misiniz?</span>
            </div>
            <div class="modal-footer" id="delete">
                <button type="button" id="deletecancel" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
            </div>
        </div>
    </div>
</div>

