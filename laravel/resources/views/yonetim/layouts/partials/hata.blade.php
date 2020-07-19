<div class="col-md-12">
    <div class="alert alert-danger alert-alt">
        <strong><i class="fa fa-bug fa-fw"></i> Hatalar</strong><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
</div>