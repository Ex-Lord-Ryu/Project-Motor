<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Stock;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::all();
        return view('pembelians.index', compact('pembelians'));
    }

    public function create()
    {
        return view('pembelians.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|string|max:255',
            'tgl_beli' => 'required|date',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string|max:255',
            'tipe_barang' => 'required|array',
            'tipe_barang.*' => 'required|string|max:255',
            'harga' => 'required|array',
            'harga.*' => 'required|regex:/^\d{1,3}(\.\d{3})*$/',
            'diskon' => 'required|array',
            'diskon.*' => 'required|regex:/^\d{1,3}(\.\d{3})*$/',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer',
            'total_harga' => 'required|array',
            'total_harga.*' => 'required|regex:/^\d{1,3}(\.\d{3})*$/',
        ]);

        foreach ($validatedData['nama_barang'] as $index => $nama_barang) {
            Pembelian::create([
                'nama_supplier' => $validatedData['nama_supplier'],
                'alamat' => $validatedData['alamat'],
                'email' => $validatedData['email'],
                'no_telp' => $validatedData['no_telp'],
                'tgl_beli' => $validatedData['tgl_beli'],
                'nama_barang' => $nama_barang,
                'tipe_barang' => $validatedData['tipe_barang'][$index],
                'harga' => str_replace('.', '', $validatedData['harga'][$index]),
                'diskon' => str_replace('.', '', $validatedData['diskon'][$index]),
                'quantity' => $validatedData['quantity'][$index],
                'total_harga' => str_replace('.', '', $validatedData['total_harga'][$index]),
            ]);

            // Update stock
            $stock = Stock::where('nama_barang', $nama_barang)
                ->where('tipe_barang', $validatedData['tipe_barang'][$index])
                ->first();

            if ($stock) {
                // Update existing stock
                $stock->quantity += $validatedData['quantity'][$index];
                $stock->save();
            } else {
                // Create new stock
                Stock::create([
                    'nama_barang' => $nama_barang,
                    'tipe_barang' => $validatedData['tipe_barang'][$index],
                    'harga' => str_replace('.', '', $validatedData['harga'][$index]),
                    'quantity' => $validatedData['quantity'][$index],
                ]);
            }
        }

        return redirect()->route('pembelians.index');
    }
}
