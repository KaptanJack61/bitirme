<script src="/js/jquery.mask.min.js"></script>
    <script src="/js/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript">

    $('.select2').select2();
        var iptal = {
        linkSelector : "a#iptal",
            init: function() {
        $(this.linkSelector).on('click', {self:this}, this.handleClick);
            },
            handleClick: function(event) {
        event.preventDefault();
        var self = event.data.self;
        var link = $(this);
        swal({
                    title: 'İptal etmek istediğinize emin misiniz?',
                    text: "Yardım ekleme ekranından ayrılacaksınız.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, iptal etmek istiyorum!',
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

        var ekle = {
    linkSelector : "a#ekle",
            init: function() {
        $(this.linkSelector).on('click', {self:this}, this.handleClick);
            },
            handleClick: function(event) {

            var first_name = $('#first-name').val();
            var last_name = $('#last-name').val();
            var neighborhood = $('#neighborhood').val();
            var street = $('#street').val();
            var phone = $('#phone').val();

            var c = false;

            if(first_name == ""){
                error('#name_alert','#first-name',true);
                c = true;
            }

            if(last_name == ""){
                error('#name_alert','#last-name',true);
                c = true;
            }

            if(neighborhood == 0){
                $('#neighborhood').css('border-color','red');
                c = true;
            }

            if(street == ""){
                $('#street').css('border-color','red');
                c = true;
            }

            if(phone == "" && phone.length != 14){
                error('#phone_alert','#phone',true);
                c = true;
            }

            var dizi = [];
            @php($x=0)
            @foreach($helpTypes as $h)
                if ($("#{{ $h->slug}}").val()==""){
                    dizi.push("{{$h->slug}}");
                }
                @php($x++)
            @endforeach

            var x = {{$x}};

            if (x==dizi.length){
                $('#warning-one').hide();
                $('#general_alert_one').show();
                return false;
            }else {
                $('#warning-one').show();
                $('#general_alert_one').hide();
            }

            if (c == true){
                $('#warning').hide();
                $('#general_alert').show();
                return false
            }else {


            event.preventDefault();
            swal({
                        title: 'Eklemek istediğinize emin misiniz?',
                        text: "Yardım talebini eklemek istediğinizden emin misiniz?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Evet, eklemek istiyorum!',
                        cancelButtonText:'Hayır',
                        showLoaderOnConfirm: false,
                        preConfirm: function() {
                return new Promise(function(resolve) {
                    $("#yardimtalebi").submit();
                });
            },
                        allowOutsideClick: false
                    });
                }

    },
        };

        iptal.init();
        ekle.init();

    </script>

<script>
    var guncelle = {
        linkSelector : "a#guncelle",
        init: function() {
            $(this.linkSelector).on('click', {self:this}, this.handleClick);
        },
        handleClick: function(event) {

            var first_name = $('#first-name').val();
            var last_name = $('#last-name').val();
            var neighborhood = $('#neighborhood').val();
            var street = $('#street').val();
            var phone = $('#phone').val();

            var c = false;

            if(first_name == ""){
                error('#name_alert','#first-name',true);
                c = true;
            }

            if(last_name == ""){
                error('#name_alert','#last-name',true);
                c = true;
            }

            if(neighborhood == 0){
                $('#neighborhood').css('border-color','red');
                c = true;
            }

            if(street == ""){
                $('#street').css('border-color','red');
                c = true;
            }

            if(phone == "" && phone.length != 14){
                error('#phone_alert','#phone',true);
                c = true;
            }

            var dizi = [];
            @php($x=0)
                    @foreach($helpTypes as $h)
            if ($("#{{ $h->slug}}").val()==""){
                dizi.push("{{$h->slug}}");
            }
                    @php($x++)
                    @endforeach

            var x = {{$x}};

            if (x==dizi.length){
                $('#warning-one').hide();
                $('#general_alert_one').show();
            }else {
                $('#warning-one').show();
                $('#general_alert_one').hide();
            }

            if (c == true){
                $('#warning').hide();
                $('#general_alert').show();
                return false
            }else {


                event.preventDefault();
                swal({
                    title: 'Güncellemek istediğinize emin misiniz?',
                    text: "Yardım talebini güncellemek istediğinizden emin misiniz?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, güncellemek istiyorum!',
                    cancelButtonText:'Hayır',
                    showLoaderOnConfirm: false,
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            $("#yardimtalebi").submit();
                        });
                    },
                    allowOutsideClick: false
                });
            }

        },
    };

    guncelle.init();
</script>

    <script type="text/javascript">
        function isNumberKeyPhone(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            var data = $('#phone').val();
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return false;

            if (charCode==48 && (data.length == 0 || data == "("))
                return false;

            return true;
        }

        function isNumberKeyTc(evt)
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

        function isNumericKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return true;
            return false;
        }
    </script>
    <script type="text/javascript">

        function error(idAlert,id,p) {
            if(p == true) {
                $(idAlert).show();
                $(id).css("border-color","red");
            }else{
                $(idAlert).hide();
                $(id).removeAttr("style");
            }
        }

        $( document ).ready(function() {
            @php($x=0)
            var dizi2 =[];
            @foreach($helpTypes as $h)
            dizi2.push("{{$h->slug}}");
            $( "#{{$h->slug}}" )
                .focusout(function() {
                        var data = $("#{{$h->slug}}").val();
                        if(data != ""){
                            $('#warning-one').show();
                            $('#general_alert_one').hide();
                        }else {
                            y = 0;

                            @foreach($helpTypes as $h2)
                                if ($("#{{$h2->slug}}").val()=="") {
                                    y++
                                }
                            @endforeach

                            if (y==dizi2.length){
                                $('#warning-one').hide();
                                $('#general_alert_one').show();
                            }
                        }
                    }
                );
            @php($x++)
            @endforeach

            $( "#tc_no" )
            .focusout(function() {
                var data = $('#tc_no').val();
                if(data.length != 11 && data!=""){
                    error('#tc_no_alert','#tc_no',true);
                    }else{
                    error('#tc_no_alert','#tc_no',false);
                    }
            }
            );

            $('#phone').mask('(000) 000 0000').focusout(function () {
                var data = $('#phone').val();
                if(data.length != 14){
                    error('#phone_alert','#phone',true);
                }else{
                    error('#phone_alert','#phone',false);
                }
            });

            $('#first-name').focusout(function () {
                var data = $('#first-name').val();
                if (data != ""){
                    error('#null','#first-name',false);
                    if ($('#last-name').val() != "")
                        error('#name_alert','#first-name',false);
                }else {
                    error('#name_alert','#first-name',true);
                }
            });

            $('#last-name').focusout(function () {
                var data = $('#last-name').val();
                if (data != ""){
                    error('#null','#last-name',false);
                    if ($('#first-name').val() != "")
                        error('#name_alert','#last-name',false);
                }else {
                    error('#name_alert','#last-name',true);
                }
            });

            $('#email').focusout(function () {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                var data = $('#email').val();
                if(!regex.test(data) && data != "") {
                    error('#email_alert','#email',true);
                }else{
                    error('#email_alert','#email',false);
                }
            });

            $( "#neighborhood" )
            .change(function() {
                var data = $('#neighborhood').val();
                if (data != 0) {
                    error('#null', '#neighborhood', false);
                    if ($('#street').val() != "") {
                        error('#general_alert', '#neighborhood', false);
                        error('#warning', '#null', true);
                    }
                }else {
                    error('#general_alert','#neighborhood',true);
                    error('#warning','#null',false);
                }
            }
            );

            $( "#street" )
            .focusout(function() {
                var data = $('#street').val();
                if (data != ""){
                    error('#null','#street',false);
                    if ($('#neighborhood').val() != 0){
                        error('#general_alert','#street',false);
                        error('#warning','#null',true);
                    }
                }else {
                    error('#general_alert','#street',true);
                    error('#warning','#null',false);
                }
            }
            );

        });
    </script>

