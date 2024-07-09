<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'tipe_barang' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        Stock::create([
            'nama_barang' => $validatedData['nama_barang'],
            'tipe_barang' => $validatedData['tipe_barang'],
            'harga' => str_replace('.', '', $validatedData['harga']),
            'quantity' => $validatedData['quantity'],
        ]);

        return redirect()->route('stocks.index');
    }

    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'tipe_barang' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $stock->update([
            'nama_barang' => $validatedData['nama_barang'],
            'tipe_barang' => $validatedData['tipe_barang'],
            'harga' => str_replace('.', '', $validatedData['harga']),
            'quantity' => $validatedData['quantity'],
        ]);

        return redirect()->route('stocks.index');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index');
    }
}
