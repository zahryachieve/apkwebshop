<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\CartItem;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil hanya data keranjang user yang sedang login
        $cartItems = CartItem::where('user_id', Auth::id())->get();
    
        return view('datapesanan.index', compact('cartItems'));
    }

    public function indexadmin()
    {
        // Ambil hanya data keranjang user yang sedang login
        $cartItems = CartItem::all();
    
        return view('datapesanan.admin', compact('cartItems'));
    }
    public function add(Request $request)
    {
        // Validasi data
        $request->validate([
            'product_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|integer|min:0'
        ]);
    
        // Menyimpan data ke tabel keranjang
        $cart = CartItem::create([
            'user_id' => auth()->id(), // Pastikan user sudah login
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price
        ]);
    
        return response()->json(['message' => 'Berhasil ditambahkan ke keranjang'], 200);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
   $request->validate([
      'product_name' => 'required|string',
      'quantity' => 'required|integer|min:1',
      'total_price' => 'required|integer'
   ]);

   CartItem::create([
      'user_id' => Auth::id(),
      'product_name' => $request->product_name,
      'quantity' => $request->quantity,
      'total_price' => $request->total_price,
   ]);

   return response()->json(['success' => true]);
}
public function getCart()
{
    $userId = Auth::id();

    $items = CartItem::where('user_id', $userId)->get(['product_name', 'quantity', 'total_price']);

    return response()->json($items);
}


public function checkout(Request $request)
{
    $itemIds = explode(',', $request->query('items'));
    $items = CartItem::whereIn('id', $itemIds)->get();

    $total = $items->sum('total_price');

    return view('datapesanan.checkout.index', compact('items', 'total'));
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = CartItem::find($id);
    
        if ($item) {
            $item->product_name = $request->product_name;
            $item->quantity = $request->quantity;
            $item->total_price = $request->total_price;
            $item->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $item = CartItem::find($id); // langsung cari berdasarkan id

    if ($item) {
        $item->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
}


}
