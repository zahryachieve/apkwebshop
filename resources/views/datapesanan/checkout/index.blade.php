@extends('layouts.master')
@section('content')
<!-- <div class="container">
    <h2>Checkout</h2>

    <h4>Daftar Produk yang Dipilih</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <input type="hidden" name="cart_ids" value="{{ implode(',', $cartItems->pluck('id')->toArray()) }}">
        
        <div class="form-group">
            <label for="shipping_address">Alamat Pengiriman</label>
            <textarea name="shipping_address" id="shipping_address" class="form-control" required>{{ old('shipping_address') }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="payment_method">Metode Pembayaran</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="COD">Cash on Delivery</option>
                <option value="Transfer Bank">Transfer Bank</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
    </form>
</div> -->

<h2>Checkout</h2>
<ul>
    @foreach($items as $item)
        <li>{{ $item->product_name }} - Qty: {{ $item->quantity }} - Rp {{ number_format($item->total_price, 0, ',', '.') }}</li>
    @endforeach
</ul>

<p><strong>Total Bayar: Rp {{ number_format($total, 0, ',', '.') }}</strong></p>

@endsection