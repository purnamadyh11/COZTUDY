@extends('layouts.back-office')

@section('title', 'Dashboard')
@section('title-desc', 'Kita mulai dari sini')
@section('content')
  <div class="box-header with-border">
    <h3 class="box-title">Title</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
  <h4>Selamat Datang <b>{{Auth::user()->name}}</b></h4>
  </div>
@endsection