@extends('frontend.layouts.master')

@section('content')
<div class="col-lg-8 col-md-10 mx-auto">

    @foreach($yazilar as $yazi)

    <div class="post-preview">
        <a href="{{'/'.$yazi->slug}}">
            <h2 class="post-title">
                {{$yazi->baslik}}
            </h2>
            <h3 class="post-subtitle">
                {!! $yazi->ozet !!}
            </h3>
        </a>
        <p class="post-meta">
            @if($yazi->yazar!=null)
                Yazar: <a href="/yazar/{{$yazi->yazar->slug}}">{{$yazi->yazar->name}}</a>
            @else
                Yazar: Sistem
            @endif
                Tarih: <b>{{ date('d.m.Y', strtotime($yazi->created_at)) }}</b>
        </p>
    </div>
    <hr>

    @endforeach
        <!-- Pager -->
    <div class="clearfix">
        <a class="btn btn-primary float-right" href="#">Önceki Yazılar &rarr;</a>
    </div>
</div>
@endsection
