@extends('layouts.frontend')
@section('content')
@section('nav-item-tempat', 'active')
<div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3>Persewaan Kami</h3>
          <span class="breadcrumb"><a href="/">Beranda</a> > Tempat</span>
        </div>
      </div>
    </div>
  </div>
  <div class="section trending">
    <div class="container">
      <div class="row trending-box">
        @foreach ($data as $item)
            <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items col-md-6 adv">
                <div class="item">
                    <div class="thumb">
                    <a href="{{ url('/detail/'.$item->id) }}"><img src="{{ asset($item->placeDetails[0]->images) }}" alt=""></a>
                    <span class="price">{{ "Rp ".str_replace(",", ".", number_format($item->price)) }}</span>
                    </div>
                    <div class="down-content">
                    <h4>{{ $item->name }}</h4>
                    <span class="category">{!! $item->description !!}</span>
                    <a href="{{ url('/detail/'.$item->id) }}" class="mt-3"><i class="fa fa-shopping-bag"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
      </div>
      <div class="row">
        <div class="col-lg-12">
          <ul class="pagination">
            {!! $data->links() !!}
        </div>
      </div>
    </div>
  </div>
@endsection