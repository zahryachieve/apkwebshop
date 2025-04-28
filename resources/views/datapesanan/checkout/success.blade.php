@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Pembelian Berhasil</h2>
    <p>Terima kasih telah melakukan pembelian. Order Anda sedang diproses.</p>
    <a href="{{ route('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
