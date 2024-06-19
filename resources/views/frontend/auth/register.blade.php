@extends('layouts.frontend-auth')
@section('content')
<div class="page-heading header-text p-5">
  <div class="container p-0">
    <div class="row">
      <div class="col-sm-12 p-0">
        <h3>Daftar</h3>
        <span class="breadcrumb">Daftar untuk melanjutkan, atau masuk jika sudah mempunyai akun.</span>
      </div>
    </div>
  </div>
</div>
<div class="features">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="item" style="padding-bottom: 95px;">
          @if(session('message'))
          <div class="alert alert-success">
              {{session('message')}}
          </div>
          @endif
          <form action="{{route('actionregister')}}" method="post">
            @csrf
            <div class="form-group">
              <label for="" class="form-label fw-medium">Nama</label>
              <input type="text" name="name" class="form-control" placeholder="Masukkan Nama...">
            </div>
            <div class="form-group">
              <label for="" class="form-label fw-medium">Email</label>
              <input type="text" name="email" class="form-control" placeholder="Masukkan Email...">
            </div>
            <div class="form-group">
              <label for="" class="form-label fw-medium">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Masukkan Password...">
            </div>
            <div class="form-group" style="float: right;">
              <button class="btn btn-md btn-outline-success text-white btn-success mt-4 justify-content-end">Daftar</button>
              <a href="/login" class="btn btn-md btn-outline-dark mt-4 justify-content-end">Ke halaman Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection()