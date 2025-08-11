<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'qty'           => 'required|integer',
            'harga'         => 'required|numeric',
            'jenis_barang'  => 'required|string|max:100',
            'stok'          => 'required|integer',  
        ]);

        DB::connection('mysql')->table('orders')->insert([
            'nama_barang'   => $request->nama_barang,
            'qty'           => $request->qty,
            'harga'         => $request->harga,
            'jenis_barang'  => $request->jenis_barang,
            'stok'          => $request->stok,
            'created_at'    => now(),
            // 'updated_at'    => now(),
        ]);

        return redirect()->route('orders.create')->with('success', 'Order berhasil disimpan.');
    }

    public function dashboard()
    {
        $orders = DB::connection('mysql')->table('orders')->get(); // atau 'orders' jika nama tabelnya orders
        return view('orders.dashboard', compact('orders'));
    }

   
    public function edit($id)
    {
        $order = DB::connection('mysql')->table('orders')->find($id);
        return view('orders.edit', compact('order'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'qty'           => 'required|integer',
            'harga'         => 'required|numeric',
            'jenis_barang'  => 'required|string|max:100',
            'stok'          => 'required|integer',  
        ]);

        DB::connection('mysql')->table('orders')->where('id', $id)->update([
            'nama_barang'   => $request->nama_barang,
            'qty'           => $request->qty,
            'harga'         => $request->harga,
            'jenis_barang'  => $request->jenis_barang,
            'stok'          => $request->stok,
            'updated_at'    => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Order berhasil diperbarui.');
    }
    public function destroy($id)
    {
        DB::connection('mysql')->table('orders')->where('id', $id)->delete();
        return redirect()->route('dashboard')->with('success', 'Order berhasil dihapus.');
    }
}
