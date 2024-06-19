@extends('layouts.back-office')

@section('title', 'Master')
@section('title-desc', 'Data utama')

@section('content')
<div class="box-header with-border">
    <h3 class="box-title">Data Tempat <button type="button" class="btn btn-xs btn-success add"><i class="fa fa-plus"></i></button></h3>
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
                <th>Nama</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>

    <!-- dynamic modal -->
    <div class="modal">
        <div class="modal-dialog modal-full mt-2" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b class="title-modal">...</b>
                    <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-place" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control name" name="name" placeholder="Masukkan Nama Tempat...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control latitude" name="latitude" placeholder="Masukkan Latitude...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control longitude" name="longitude" placeholder="Masukkan Longitude...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" id="ckeditor" class="description" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harga</label>
                            <input type="text" class="form-control price dengan-rupiah" name="price" placeholder="Masukkan Harga...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" id="" class="form-control status">
                                <option selected disabled>Pilih Status</option>
                                <option value="1">Ready</option>
                                <option value="2">Booked</option>
                                <option value="3">Closed</option>
                            </select>
                        </div>
                        <hr>
                        <h4><b>Tambahkan Detail Gambar</b></h4>
                        <div class="alert alert-info alert-cover">
                            <i class="fa fa-info-circle"></i> Gambar pertama akan <strong>menjadi cover</strong>
                        </div>
                        <div class="detail"></div>
                        <button type="button" class="btn mt-2 btn-sm btn-primary add-detail">Tambah <i class="fa fa-image ml-1"></i></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="action btn btn-success btn-md" data-type="">...</button>
                    <button type="button" class="btn btn-secondary close-modal btn-md" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('back-office/page/js/place.js') }}"></script>
@endpush