@extends('layouts.frontend')
@section('content')
@section('nav-item-tempat', 'active')
@push('css')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endpush
@push('style')
    <style>
      #map { 
        height: 500px;
        z-index: 1;
        border-radius: 20px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.15) !important
      }
    </style>
@endpush
    <div id="location"></div>
  <div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3>{{ $detail->name }}</h3>
          <span class="breadcrumb"><a href="/">Beranda</a>  >  <a href="#">Tempat</a>  >  {{ $detail->name }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="single-product section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="left-image">
            <div id="map"></div>
          </div>
        </div>
        <div class="col-lg-4 align-self-center">
          @if(session('success'))
          <div class="alert alert-success">
              {{session('success')}}
          </div>
          @endif
          @if(session('error'))
          <div class="alert alert-danger">
              {{session('error')}}
          </div>
          @endif
          <h4>{{ $detail->name }}</h4>
          <span class="price">{{ "Rp ".str_replace(",", ".", number_format($detail->price)) }}</span>
          {!! $detail->description !!}
          <form action="/cart/store" method="POST" id="qty" action="#">
            @csrf
            <input type="hidden" name="id" value="{{ $detail->id }}">
            <input type="hidden" name="grand_total" value="{{ $detail->price }}">
            @if (Auth::check())
              <button type="submit"><i class="fa fa-shopping-bag"></i> Tambah ke keranjang</button>
              @else
              <button disabled style="cursor: not-allowed" type="submit"><i class="fa fa-shopping-bag"></i> Tambah ke keranjang</button>
              <br><small><i>Silahkan masuk terlebih dahulu untuk melanjutkan</i></small>
            @endif
          </form>
          <ul>
            <li><span>Diposting Pada:</span> {{ date('d-m-Y', strtotime($detail->created_at)) }}</li>
          </ul>
        </div>
        <div class="col-lg-12">
          <div class="sep"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="more-info">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="tabs-content">
            <div class="row">
              <div class="nav-wrapper ">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Deskripsi</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Gambar ({{ count($detail->placeDetails) }})</button>
                  </li>
                </ul>
              </div>              
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                  {!! $detail->description !!}
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                  <div class="container">
                    <div class="row">
                        @foreach ($detail->placeDetails as $item)
                          <div class="col-lg col-sm-6 col-xs-12">
                            <div class="item">
                              <div class="thumb">
                                <a href="#"><img style="border-radius: 10px" src="{{ asset($item->images) }}" alt=""></a>
                              </div><br>
                              <span><i>{{ $item->description }}</i></span>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('js')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
  <script>
    let name = "{{ $detail->name }}";
    let lat = {{ $detail->latitude }};
    let long = {{ $detail->longitude }};
    let map = L.map('map').setView([lat, long], 13);

    let user_latitude = localStorage.getItem("latitude");
    let user_longitude = localStorage.getItem("longitude");

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    let waypoints = [];

    let bounds = new L.LatLngBounds();

    let json_latlong = [
      {
        "label" : `Lokasi <b>${name}</b> ada di sini!`,
        "lat": lat,
        "lng": long
      },
      {
        "label" : "Lokasi Anda",
        "lat": user_latitude,
        "lng": user_longitude
      }
    ];

    json_latlong.forEach(function(markerData) {
        let lat = parseFloat(markerData.lat);
        let lng = parseFloat(markerData.lng);
        bounds.extend([lat, lng]);
        let marker = L.marker([lat, lng]).addTo(map);

        marker.bindTooltip(markerData.label, {
            permanent: true,
            direction: 'top'
        }).openTooltip();

        waypoints.push(L.latLng(lat, lng));
    });

    map.fitBounds(bounds);

    let control = L.Routing.control({
        waypoints: waypoints,
        routeWhileDragging: true,
        vehicle: 'car',
        lineOptions: {
            styles: [{
                color: '#00a8ff',
                weight: 4
            }]
        }
    }).addTo(map);

    $('.leaflet-routing-container').remove();

  </script>
@endpush