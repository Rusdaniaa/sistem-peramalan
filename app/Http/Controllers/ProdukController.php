<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Penjualan;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function cetak()
     {
         $data['title'] = 'Laporan Data Produk';
         $data['rows'] = Produk::orderBy('kode_produk')->get();
         return view('produk.cetak', $data);
     }

    public function index(Request $request)
    {
        $data['q'] = $request->input('q');
        $data['title'] = 'Data Produk';
        $data['limit'] = 10;
        $data['rows'] = Produk::where('kode_produk', 'like', '%' . $data['q'] . '%')
            ->orwhere('nama_produk', 'like', '%' . $data['q'] . '%')
            ->orderBy('kode_produk')
            ->paginate($data['limit'])->withQueryString();
        return view('produk.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Tambah Produk';
        return view('produk.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produk',
            'nama_produk' => 'required',
        ], [
            'kode_produk.required' => 'Kode produk harus diisi',
            'kode_produk.unique' => 'Kode produk harus unik',
            'nama_produk.required' => 'Nama harus diisi',
        ]);
        $produk = new Produk($request->all());
        $produk->save();

        return redirect('produk')->with('message', 'Data berhasil ditambah!');
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
    public function edit(Produk $produk)
    {
        $data['row'] = $produk;
        $data['title'] = 'Ubah Produk';
        return view('produk.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required',
        ], [
            'nama_produk.required' => 'Nama harus diisi',
        ]);
        $produk->nama_produk = $request->nama_produk;
        $produk->save();
        return redirect('produk')->with('message', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
    // Mengambil penjualan dengan kode produk yang sama
    $penjualans = Penjualan::where('kode_produk', $produk->kode_produk)->get();

    // Menghapus setiap entri penjualan yang berkaitan dengan produk yang akan dihapus
    foreach ($penjualans as $penjualan) {
        $penjualan->delete();
    }

    // Menghapus produk itu sendiri
    $produk->delete();

    return redirect('produk')->with('message', 'Data berhasil dihapus!');
    }
}
