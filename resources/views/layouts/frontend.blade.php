<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Aplikasi Rental</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('frontend') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/fontawesome.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/owl.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    @stack('css')
<!--

TemplateMo 589 lugx gaming

https://templatemo.com/tm-589-lugx-gaming

-->
  </head>

<body>

  @stack('style')

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="/" class="logo">
                        {{-- <img src="{{ asset('frontend') }}/assets/images/logo.png" alt="" style="width: 158px;"> --}}
                        <h1 style="font-size: 23px">RentalKu</h1>
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                      <li><a href="/" class="@yield('nav-item-beranda')">Beranda</a></li>
                      <li><a href="/product" class="@yield('nav-item-tempat')">Tempat</a></li>
                      @if (Auth::check())
                          <li><a href="/cart" class="@yield('nav-item-keranjang')">Keranjang</a></li>
                          <li><a href="{{route('actionlogout')}}"><i class="fa fa-user" style="font-size: 12px;margin-right:5px"></i> {{ Auth::user()->name }} │ Keluar</a></li>
                          @else
                          <li><a href="/login">Masuk</a></li>
                      @endif
                  </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  @yield('content')

  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p>Copyright © {{ date('Y') }} StudioProjectID <a rel="nofollow" href="https://templatemo.com" target="_blank">Design: TemplateMo</a></p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('frontend') }}/vendor/jquery/jquery.min.js"></script>
  <script src="{{ asset('frontend') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="{{ asset('frontend') }}/assets/js/isotope.min.js"></script>
  <script src="{{ asset('frontend') }}/assets/js/owl-carousel.js"></script>
  <script src="{{ asset('frontend') }}/assets/js/counter.js"></script>
  <script src="{{ asset('frontend') }}/assets/js/custom.js"></script>
  <script src="{{ asset("global") }}/js/location.js"></script>
  <script src="{{ asset('global/js/swal.js') }}"></script>
  <script src="{{ asset("global") }}/js/swal-helper.js"></script>

  <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="6ce72ad1-3f94-40ac-b5d8-4a54c8da8c67";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
  @stack('js')
  </body>
</html>