@extends('layouts.master')
@section('content')
<div class="page-container">

    <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- DATA TABLE -->
                                    <h3 class="title-5 m-b-35">Data Pesanan Saya</h3>
                                    <div class="table-data__tool">
                                        <div class="table-data__tool-left">
                                            <div class="rs-select2--light rs-select2--md">
                                                <select class="js-select2" name="property">
                                                    <option selected="selected">All Properties</option>
                                                    <option value="">Option 1</option>
                                                    <option value="">Option 2</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                            </div>
                                            <div class="rs-select2--light rs-select2--sm">
                                                <select class="js-select2" name="time">
                                                    <option selected="selected">Today</option>
                                                    <option value="">3 Days</option>
                                                    <option value="">1 Week</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                            </div>
                                            <button class="au-btn-filter">
                                                <i class="zmdi zmdi-filter-list"></i>filters</button>
                                        </div>
                                        <div class="table-data__tool-right">
                                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                                <i class="zmdi zmdi-plus"></i>add item</button>
                                            <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                                <select class="js-select2" name="type">
                                                    <option selected="selected">Export</option>
                                                    <option value="">Option 1</option>
                                                    <option value="">Option 2</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table-responsive-data2">
    <table class="table table-data2">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
            <th>Opsi</th>
        </tr>
        </thead>
        <tbody>
        @forelse($cartItems as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->product_name }}</td>
            <td id="quantity-{{ $item->id }}">{{ $item->quantity }}</td>
            <td id="total-price-{{ $item->id }}">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
            <td>{{ $item->created_at }}</td>
            <td>
                <div class="table-data-feature">
                    <!-- Tombol minus dan plus -->
                    <button class="item btn-minus" data-id="{{ $item->id }}" data-price="{{ $item->price }}" data-action="minus" title="Kurangi">
    <i class="zmdi zmdi-minus"></i>
</button>
<button class="item btn-plus" data-id="{{ $item->id }}" data-price="{{ $item->price }}" data-action="plus" title="Tambah">
    <i class="zmdi zmdi-plus"></i>
</button>

                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">Keranjang kamu kosong</td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const minusButtons = document.querySelectorAll('.btn-minus');
    const plusButtons = document.querySelectorAll('.btn-plus');

    console.log(minusButtons);  // Periksa apakah tombol minus ada
    console.log(plusButtons);   // Periksa apakah tombol plus ada
    
    // Fungsi untuk mengupdate quantity dan harga
    function updateCart(itemId, quantity, totalPrice) {
        fetch(`/cart/update/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                quantity: quantity,
                total_price: totalPrice
            })
        }).then(res => {
            if (!res.ok) {
                throw new Error('Gagal menyimpan perubahan');
            }
            return res.json();
        }).then(data => {
            document.getElementById(`quantity-${itemId}`).textContent = quantity;
            document.getElementById(`total-price-${itemId}`).textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
        }).catch(error => {
            Swal.fire('Gagal!', error.message, 'error');
        });
    }

    // Event listener untuk tombol minus
    minusButtons.forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.dataset.id;
            let quantity = parseInt(document.getElementById(`quantity-${itemId}`).textContent);
            const price = parseInt(this.dataset.price);

            if (quantity > 1) { // Pastikan quantity tidak menjadi kurang dari 1
                quantity--;
                const totalPrice = quantity * price;
                updateCart(itemId, quantity, totalPrice);
            }
        });
    });

    // Event listener untuk tombol plus
    plusButtons.forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.dataset.id;
            let quantity = parseInt(document.getElementById(`quantity-${itemId}`).textContent);
            const price = parseInt(this.dataset.price);

            quantity++;
            const totalPrice = quantity * price;
            updateCart(itemId, quantity, totalPrice);
        });
    });
});

</script>

                                    <!-- END DATA TABLE -->
                                </div>
                            </div>  
                        </div>                 
                    </div>
    </div>
</div>    
@endsection