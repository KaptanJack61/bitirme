@extends('frontend.layouts.master')

@section('title', $yazi->baslik.' | '.config('app.name'))
@section('sayfatitle',$yazi->baslik)
@section('sayfaalttitle',"")
@section('arkaplan',"url('".$yazi->anagorsel."')")

@section('content')
    <article>
<div class="col-lg-8 col-md-10 mx-auto">

    {!! $yazi->icerik !!}

</div>
    </article>
@endsection
