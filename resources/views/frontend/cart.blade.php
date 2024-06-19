@extends('layouts.frontend')
@section('content')
@section('nav-item-keranjang', 'active')
<div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3>Keranjang</h3>
          <span class="breadcrumb"><a href="/">Beranda</a> > Keranjang</span>
        </div>
      </div>
    </div>
  </div>
  <div class="section">
    <div class="container mt-3">
      <form action="/transaction/store" method="POST">
        @csrf
        <div class="row trending-box">
          @foreach ($data as $item)
            <div class="list-cart">
              <!-- Keperluan post -->
              <input type="hidden" name="place_id[]" value="{{ $item->cartDetail[0]->place->id }}">
              <input type="hidden" name="price[]" value="{{ $item->cartDetail[0]->place->price }}">
              <div class="row mb-5">
                <div class="col-12 trending-items">
                  <div class="item p-4">
                    <h4><button type="button" data-id="{{ $item->id }}" class="btn btn-sm btn-danger delete-item"><i class="fa fa-times"></i></button> {{ $item->code }}</h4>
                    <div class="row mt-2">
                      <div class="col-2">
                        <img class="rounded" src="{{ $item->cartDetail[0]->place->placeDetails[0]->images }}" alt="">
                      </div>
                      <div class="col">
                        <h5 class="fw-bold">{{ $item->cartDetail[0]->place->name }}</h5>
                        {!! $item->cartDetail[0]->place->description !!}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <br><span class="price bg-success text-white rounded p-2">{{ "Rp ".str_replace(",", ".", number_format($item->cartDetail[0]->place->price)) }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <button type="submit" class="btn btn-success btn-block btn-md" style="float: right"> Checkout</button>
      </form>
    </div>
  </div>
  <div class="section">
    <div class="container">
      <hr>
      <h4>Belum dibayar</h4>
      <table class="table table-striped table-responsive table-borederd">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Grand Total</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transaction as $item)
              <tr>
                <td>{{ $item->code }}</td>
                <td>{{ "Rp ".str_replace(",", ".", number_format($item->grand_total)) }}</td>
                <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
                <td>
                  <button data-id="{{ $item->id }}" data-total="{{ $item->grand_total }}" class="btn btn-sm btn-success bayar">Bayar</button>
                  <button data-id="{{ $item->id }}" class="btn btn-sm btn-danger batal">Batal</button>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="section">
    <div class="container">
      <hr>
      <h4>Sudah dibayar</h4>
      <table class="table table-striped table-responsive table-borederd">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Grand Total</th>
            <th>Tanggal Bayar</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transactiondone as $itemdone)
              <tr>
                <td>{{ $itemdone->code }}</td>
                <td>{{ "Rp ".str_replace(",", ".", number_format($itemdone->grand_total)) }}</td>
                <td>{{ date('d-m-Y H:i:s', strtotime($itemdone->updated_at)) }}</td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@push('js')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
      $('.delete-item').click(function(){
        let id = $(this).data('id');
        let elem = $(this);
        swalConfirm('hapus', function(){
          $.ajax({
            url : `/cart/delete/${id}`,
            type : "GET",
            success:function(res){
              toast("Berhasil Hapus!");
              elem.parents().closest('.list-cart').remove();
            }
          });
        });
      });

      $('.batal').click(function(){
        let id = $(this).data('id');
        let elem = $(this);
        swalConfirm('cancel', function(){
          $.ajax({
            url : `/transaction/cancel/${id}`,
            type : "GET",
            success:function(res){
              toast("Berhasil Dicancel!");
              window.location.reload();
            }
          });
        });
      });

      $('.bayar').click(function(){
        let id = $(this).data('id');
        let total = $(this).data('total');
        let elem = $(this);
        
        swalConfirm('bayar', function(){
            $.ajax({
                url: `/payment`,
                type: "POST",
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    gross_amount: total
                },
                success: function(res){
                    console.log(res);
                    window.snap.pay(res.snap_token, {
                        onSuccess: function(result){
                            // Replace '/success' with your desired redirect URL
                            window.location.href = '/cart';
                        },
                        onPending: function(result){
                            // Handle pending status if necessary
                        },
                        onError: function(result){
                            // Handle error status if necessary
                        },
                        onClose: function(){
                            // Handle close action if necessary
                        }
                    });
                }
            });
        });
      });

    </script>
@endpush