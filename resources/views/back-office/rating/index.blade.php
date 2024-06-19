@extends('layouts.back-office')

@section('title', 'Master')
@section('title-desc', 'Data utama')

@section('content')
<div class="box-header with-border">
    <h3 class="box-title">Data Rating</h3>
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
    </div>
</div>
<div class="box-body">
    <table class="table table-bordered" style="width:100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Produk/Tempat</th>
                <th>Rating</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('js')
<script src="{{ asset('back-office/page/js/rating.js') }}"></script>
@endpush