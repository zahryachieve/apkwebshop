<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Menampilkan halaman checkout dengan produk yang dipilih
    public function index()
    {
        $cartItems = CartItem::whereIn('id', request('cart_ids'))
                            ->where('user_id', auth()->id())
                            ->get();

        $totalPrice = $cartItems->sum('total_price');

        return view('datapesanan.checkout.index', compact('cartItems', 'totalPrice'));
    }

    // Proses checkout dan simpan order
    public function processCheckout(Request $request)
    {
        // Validasi data checkout (misalnya alamat, metode pembayaran, dll)
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Mendapatkan produk yang dipilih berdasarkan cart_ids
        $cartItems = CartItem::whereIn('id', $request->cart_ids)
                             ->where('user_id', auth()->id())
                             ->get();

        // Proses pembelian dan simpan data order ke tabel orders
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $cartItems->sum('total_price'),
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'status' => 'Pending', // status order
        ]);

        // Menyimpan detail order (produk yang dipesan)
        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_name' => $item->product_name,
                'quantity' => $item->quantity,
                'total_price' => $item->total_price,
            ]);
            // Hapus item dari keranjang setelah checkout
            $item->delete();
        }

        return redirect()->route('datapesanan.checkout.success')->with('success', 'Pembelian berhasil!');
    }

    // Halaman sukses setelah checkout
    public function success()
    {
        return view('datapesanan.checkout.success');
    }
}
