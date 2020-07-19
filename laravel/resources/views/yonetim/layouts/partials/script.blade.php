<!-- jQuery -->
<script src="/js/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/js/plugins/morris/morris.min.js"></script>

-->
<!-- Sparkline -->
<script src="/js/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart
<script src="/js/plugins/knob/jquery.knob.js"></script>
-->
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/js/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->

<!-- Slimscroll -->
<script src="/js/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/js/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/js/adminlte.js"></script>

@if(config('sweetalert.animation.enable'))
    <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
@endif
<script src="/js/sweetalert2.all.js"></script>





@include('sweetalert::alert')
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script type="text/javascript">
    $('#change-password').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
    });

    $('#old-password').focusout(function () {
        var oldpassword = $('#old-password').val();
        if (oldpassword == "") {
            $('#old_password_alert').text("Eski şifre alanını boş bırakamazsını.");
            $('#old_password_alert').show();
        }else {
            $('#old_password_alert').hide();
        }
    });

    $('#newpassword1').focusout(function () {
        var password1 = $('#newpassword1').val();
        if (password1 == "") {
            $('#password1_alert').show();
        }else {
            sifrecontrol();
            $('#password1_alert').hide();
        }
    });

    $('#newpassword2').focusout(function () {
        var password1 = $('#newpassword2').val();
        if (password1 == "") {
            $('#password2_alert').show();
        }else {
            sifrecontrol();
            $('#password2_alert').hide();
        }
    });

    function sifrecontrol() {
        var password1 = $('#newpassword1').val();
        var password2 = $('#newpassword2').val();

        if (password1 != password2){
            $('#password_alert').show();
        }else {
            $('#password_alert').hide();
        }
    }



    var changePassword = {
        linkSelector : "a#change-password-button",
        init: function() {
            $(this.linkSelector).on('click', {self:this}, this.handleClick);
        },
        handleClick: function(event) {

            var oldpassword = $('#old-password').val();
            var password1 = $('#newpassword1').val();
            var password2 = $('#newpassword2').val();

            var c = true;

            if (oldpassword == ""){
                $('#old_password_alert').text("Eski şifre alanını boş bırakamazsını.");
                $('#old_password_alert').show();
                c = false;
            }else{
                $('#old_password_alert').hide();
            }

            if (password1 == ""){
                $('#password1_alert').show();
                c = false;
            }else{
                $('#password1_alert').hide();
            }

            if (password2 == ""){
                $('#password2_alert').show();
                c = false;
            }else{
                $('#password2_alert').hide();
            }

            if (password1 != password2){
                $('#password_alert').show();
                c = false;
            }else {
                $('#password_alert').hide();
            }

            if (c == false){
                return false
            }else {

                $.ajax({
                    type: 'POST',
                    url: "{{ route('control.oldpassword') }}",
                    data: "oldpassword="+ oldpassword,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(ajaxCevap) {
                        if (ajaxCevap == 0){
                            $('#old_password_alert').text("Eski şifrenizi yanlış girdiniz");
                            $('#old_password_alert').show();
                            return false;
                        }else {
                            $('#old_password_alert').hide();
                            event.preventDefault();
                            swal({
                                title: 'Şifrenizi değiştirmek istediğinize emin misiniz?',
                                text: "Şifreniz güncellenecek emin misiniz?",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Evet, değiştirmek istiyorum!',
                                cancelButtonText:'Hayır',
                                showLoaderOnConfirm: false,
                                preConfirm: function() {
                                    return new Promise(function(resolve) {
                                        $("#changePasswordForm").submit();
                                    });
                                },
                                allowOutsideClick: false
                            });
                        }
                    }
                });

            }

        },
    };

    changePassword.init();

</script>

<script src="/js/jquery.mask.min.js"></script>
<script type="text/javascript">

    function isNumberKeyNavbarPhone(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        var data = $('#navbar-search').val();
        if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
            return false;

        if (charCode==48 && (data.length == 0 || data == "("))
            return false;

        return true;
    }

    function isNumberKeyNvbarTc(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        var data = $('#tc_no').val();
        if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
            return false;

        if (charCode==48 && data.length == 0)
            return false;

        return true;
    }

    $('#navbar-select').change(function () {
        var select = $('#navbar-select').val();

        if (select == 0){
            $('#navbar-search').attr('disabled','true');
            $('#navbar-submit').attr('disabled','true');
        }else{
            $('#navbar-search').removeAttr('disabled');
            $('#navbar-submit').removeAttr('disabled');
        }


        if (select == 1){
            $('#navbar-neighborhoods').hide();
            $('#navbar-search-div').show();
            $('#navbar-search').mask('(000) 000 0000',{placeholder: "10 haneli telefon numarası"});
            $('#navbar-search').attr('onkeypress','return isNumberKeyNavbarPhone(event)');
        }
        if (select == 2 || select == 3){
            $('#navbar-neighborhoods').hide();
            $('#navbar-search-div').show();
            $('#navbar-search').val('');
            $('#navbar-search').unmask();
            $('#navbar-search').attr('onkeypress','return isNumberKeyNavbarPhone(event)');
            if (select == 2)
                $('#navbar-search').attr('placeholder','Talep numarası');
            else
                $('#navbar-search').attr('placeholder','Yapılan yardım numarası');
        }
        if (select == 4){
            $('#navbar-neighborhoods').hide();
            $('#navbar-search-div').show();
            $('#navbar-search').val('');
            $('#navbar-search').mask('00000000000',{placeholder: "11 haneli T.C. kimlik No"});
            $('#navbar-search').attr('onkeypress','return isNumberKeyNavbarTc(event)');
        }
        if (select == 5){
            $('#navbar-neighborhoods').show();
            $('#navbar-search-div').hide();
        }
        if (select == 6){
            $('#navbar-neighborhoods').hide();
            $('#navbar-search-div').show();
            $('#navbar-search').unmask();
            $('#navbar-search').removeAttr('onkeypress');
            $('#navbar-search').attr('placeholder','Sokak...');
        }
        if (select == 7){
            $('#navbar-neighborhoods').hide();
            $('#navbar-search-div').show();
            $('#navbar-search').unmask();
            $('#navbar-search').removeAttr('onkeypress');
            $('#navbar-search').attr('placeholder','Ad Soyad...');
        }
    });

</script>
