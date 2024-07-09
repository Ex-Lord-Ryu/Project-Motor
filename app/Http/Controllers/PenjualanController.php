<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::all();
        return view('penjualans.index', compact('penjualans'));
    }

    public function create()
    {
        $stocks = Stock::all();
        return view('penjualans.create', compact('stocks'));
    }

    public function store(Request $request)
    {
        Log::info('Incoming request data:', $request->all());

        $validatedData = $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|string|max:255',
            'tgl_jual' => 'required|date',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string|max:255',
            'tipe_barang' => 'required|array',
            'tipe_barang.*' => 'required|string|max:255',
            'harga' => 'required|array',
            'harga.*' => 'required|regex:/^\d{1,3}(?:\.\d{3})*(?:,\d{2})?$/',
            'diskon' => 'required|array',
            'diskon.*' => 'required|regex:/^\d{1,3}(?:\.\d{3})*(?:,\d{2})?$/',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer',
            'total_harga' => 'required|array',
            'total_harga.*' => 'required|regex:/^\d{1,3}(?:\.\d{3})*(?:,\d{2})?$/',
        ]);

        Log::info('Validated data:', $validatedData);

        foreach ($validatedData['nama_barang'] as $index => $nama_barang) {
            Penjualan::create([
                'nama_pembeli' => $validatedData['nama_pembeli'],
                'alamat' => $validatedData['alamat'],
                'email' => $validatedData['email'],
                'no_telp' => $validatedData['no_telp'],
                'tgl_jual' => $validatedData['tgl_jual'],
                'nama_barang' => $nama_barang,
                'tipe_barang' => $validatedData['tipe_barang'][$index],
                'harga' => str_replace('.', '', $validatedData['harga'][$index]), // Remove thousand separators before storing
                'diskon' => str_replace('.', '', $validatedData['diskon'][$index]), // Remove thousand separators before storing
                'quantity' => $validatedData['quantity'][$index],
                'total_harga' => str_replace('.', '', $validatedData['total_harga'][$index]), // Remove thousand separators before storing
            ]);

            // Update stock
            $stock = Stock::where('nama_barang', $nama_barang)
                ->where('tipe_barang', $validatedData['tipe_barang'][$index])
                ->first();

            if ($stock) {
                // Reduce stock quantity
                if ($stock->quantity >= $validatedData['quantity'][$index]) {
                    $stock->quantity -= $validatedData['quantity'][$index];
                    $stock->save();
                } else {
                    // Handle out-of-stock scenario
                    return redirect()->back()->withErrors(['error' => 'Stock for ' . $nama_barang . ' is insufficient']);
                }
            } else {
                // Handle item not found in stock scenario
                return redirect()->back()->withErrors(['error' => $nama_barang . ' is not available in stock']);
            }
        }

        return redirect()->route('penjualans.index');
    }
}
