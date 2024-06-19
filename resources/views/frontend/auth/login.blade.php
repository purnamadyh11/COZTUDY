@extends('layouts.frontend-auth')
@section('content')
<div class="page-heading header-text p-5">
  <div class="container p-0">
    <div class="row">
      <div class="col-sm-12 p-0">
        <h3>Masuk</h3>
        <span class="breadcrumb">Masuk untuk melanjutkan, atau daftar jika belum mempunyai akun.</span>
      </div>
    </div>
  </div>
</div>
<div class="features">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="item" style="padding-bottom: 95px;">
          @if(session('error'))
          <div class="alert alert-warning">
            <b>Opps!</b> {{session('error')}}
          </div>
          @endif
          <form action="{{ route('actionlogin') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="" class="form-label fw-medium">Email</label>
              <input type="text" name="email" class="form-control" placeholder="Masukkan Email...">
            </div>
            <div class="form-group">
              <label for="" class="form-label fw-medium">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Masukkan Password...">
            </div>
            <div class="form-group" style="float: right;">
              <button type="submit"
                class="btn btn-md btn-outline-success text-white btn-success mt-4 justify-content-end">Masuk</button>
              <a href="/register" class="btn btn-md btn-outline-dark mt-4 justify-content-end">Ke halaman
                Registrasi</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection()