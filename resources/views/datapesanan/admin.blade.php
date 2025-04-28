@extends('layouts.master')
@section('content')
<div class="page-container">

    <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- DATA TABLE -->
                                    <h3 class="title-5 m-b-35">Data Pesanan Customer</h3>
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
                                                <td>{{ $item->quantity }}</td>
                                                <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    <div class="table-data-feature">
                                                    <button class="item btn-edit" data-id="{{ $item->id }}" data-product="{{ $item->product_name }}" data-quantity="{{ $item->quantity }}" data-total="{{ $item->total_price }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                        const editButtons = document.querySelectorAll('.btn-edit');

                                                        editButtons.forEach(button => {
                                                            button.addEventListener('click', function () {
                                                                const itemId = this.dataset.id;
                                                                const productName = this.dataset.product;
                                                                const quantity = this.dataset.quantity;
                                                                const totalPrice = this.dataset.total;

                                                                Swal.fire({
                                                                    title: 'Edit Produk',
                                                                    html: `
                                                                        <input type="text" id="product-name" class="swal2-input" value="${productName}" placeholder="Nama Produk">
                                                                        <input type="number" id="quantity" class="swal2-input" value="${quantity}" placeholder="Jumlah" min="1">
                                                                        <input type="number" id="total-price" class="swal2-input" value="${totalPrice}" placeholder="Total Harga" min="1" disabled>
                                                                    `,
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'Simpan Perubahan',
                                                                    preConfirm: () => {
                                                                        const updatedProductName = document.getElementById('product-name').value;
                                                                        const updatedQuantity = document.getElementById('quantity').value;
                                                                        const updatedTotalPrice = document.getElementById('total-price').value;

                                                                        if (!updatedProductName || !updatedQuantity || !updatedTotalPrice) {
                                                                            Swal.showValidationMessage('Semua kolom harus diisi!');
                                                                            return false;
                                                                        }

                                                                        return fetch(`/cart/update/${itemId}`, {
                                                                            method: 'PUT',
                                                                            headers: {
                                                                                'Content-Type': 'application/json',
                                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                            },
                                                                            body: JSON.stringify({
                                                                                product_name: updatedProductName,
                                                                                quantity: updatedQuantity,
                                                                                total_price: updatedTotalPrice
                                                                            })
                                                                        }).then(res => {
                                                                            if (!res.ok) {
                                                                                throw new Error('Gagal menyimpan perubahan');
                                                                            }
                                                                            return res.json();
                                                                        }).then(data => {
                                                                            Swal.fire('Berhasil!', 'Produk berhasil diperbarui.', 'success');
                                                                            location.reload(); // reload agar data diperbarui
                                                                        }).catch(error => {
                                                                            Swal.fire('Gagal!', error.message, 'error');
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    });

                                                    </script>
                                                        <button class="item btn-delete" data-id="{{ $item->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                                                                                                                <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            const deleteButtons = document.querySelectorAll('.btn-delete');

                                                            deleteButtons.forEach(button => {
                                                                button.addEventListener('click', function () {
                                                                    const itemId = this.dataset.id;

                                                                    Swal.fire({
                                                                        title: 'Yakin ingin menghapus?',
                                                                        text: 'Data yang dihapus tidak bisa dikembalikan!',
                                                                        icon: 'warning',
                                                                        showCancelButton: true,
                                                                        confirmButtonColor: '#d33',
                                                                        cancelButtonColor: '#3085d6',
                                                                        confirmButtonText: 'Ya, hapus!'
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            fetch(`/cart/delete/${itemId}`, {
                                                                                method: 'DELETE',
                                                                                headers: {
                                                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                                    'Content-Type': 'application/json',
                                                                                }
                                                                            })
                                                                            .then(res => {
                                                                                if (!res.ok) {
                                                                                    throw new Error('Gagal menghapus');
                                                                                }
                                                                                return res.json();
                                                                            })
                                                                            .then(data => {
                                                                                Swal.fire('Terhapus!', 'Produk berhasil dihapus dari keranjang.', 'success')
                                                                                    .then(() => {
                                                                                        location.reload(); // reload biar tabelnya update
                                                                                    });
                                                                            })
                                                                            .catch(error => {
                                                                                Swal.fire('Gagal!', error.message, 'error');
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        });
                                                        </script>
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
                                    <!-- END DATA TABLE -->
                                </div>
                            </div>  
                        </div>                 
                    </div>
    </div>
</div>    
@endsection