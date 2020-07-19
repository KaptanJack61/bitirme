<script src="https://cdn.ckeditor.com/4.13.0/full/ckeditor.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    var options = {
        filebrowserImageBrowseUrl: '/dosya-yoneticisi?type=Images',
        filebrowserImageUploadUrl: '/dosya-yoneticisi/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/dosya-yoneticisi?type=Files',
        filebrowserUploadUrl: '/dosya-yoneticisi/upload?type=Files&_token=',
        height: 450
    };

</script>

<script>
    CKEDITOR.replace('editor1', options);
    $('#lfm').filemanager('image');
</script>
