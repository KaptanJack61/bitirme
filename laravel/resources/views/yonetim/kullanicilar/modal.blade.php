<div class="modal fade" id="change-password" tabindex="-1" role="dialog" aria-labelledby="change-passwordLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Şifre Değiştir</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" action="{{ route('change.password') }} " method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="message-text" class="col-form-label" id="quantityLabel">Eski Şifre</label>
                        <input type="password" min="1" class="form-control" id="old-password" name="oldpassword">
                    </div>
                    <div id="old_password_alert" class="alert alert-danger" role="alert" style="display: none">

                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label" id="quantityLabel">Yeni şifre</label>
                        <input type="password" min="1" class="form-control" id="newpassword1" name="newpassword1">
                    </div>
                    <div id="password1_alert" class="alert alert-danger" role="alert" style="display: none">
                        Şifre alanını boş bırakamazsınız
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label" id="quantityLabel">Yeni şifre tekrar</label>
                        <input type="password" min="1" class="form-control" id="newpassword2" name="newpassword2">
                    </div>
                    <div id="password2_alert" class="alert alert-danger" role="alert" style="display: none">
                        Şifre tekrar alanını boş bırakamazsınız
                    </div>

                    <div id="password_alert" class="alert alert-danger" role="alert" style="display: none">
                        Girilen şifreler birbiri ile aynı değil
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <a href="#" id="change-password-button" type="button" class="btn btn-success" >
                    <i class="fa fa-check"></i> Şifremi Değiştir
                </a>
                <button type="button" id="help_edit_cancel" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
            </div>
        </div>
    </div>
</div>
