<?php

namespace App\Http\Controllers;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function cetak()
    {
        $data['title'] = 'Laporan Data Penjualan';
        $data['rows'] = Penjualan::leftJoin('produk', 'produk.kode_produk', '=', 'penjualan.kode_produk')
            ->orderBy('penjualan.kode_produk')
            ->orderBy('tanggal', 'DESC')
            ->get();
        return view('penjualan.cetak', $data);
    }

    public function index(Request $request)
    {
        $data['q'] = $request->input('q');
        $data['title'] = 'Data Penjualan';
        $data['limit'] = 25;
        $data['rows'] = Penjualan::where('nama_produk', 'like', '%' . $data['q'] . '%')
            ->orWhere('penjualan.kode_produk', 'like', '%' . $data['q'] . '%')
            ->leftJoin('produk', 'produk.kode_produk', '=', 'penjualan.kode_produk')
            ->orderBy('tanggal', 'DESC')
            ->paginate($data['limit'])->withQueryString();
        return view('penjualan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Tambah Penjualan';
        return view('penjualan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'kode_produk' => 'required',
            'jumlah' => 'required',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'kode_produk.required' => 'Produk harus diisi',
            'jumlah.required' => 'Jumlah harus diisi',
        ]);
        $penjualan = new Penjualan($request->all());
        $penjualan->save();
        return redirect('penjualan')->with('message', 'Data berhasil ditambah!');

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
    public function edit(Penjualan $penjualan)
    {
        $data['row'] = $penjualan;
        $data['title'] = 'Ubah Penjualan';
        return view('penjualan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'tanggal' => 'required',
            'kode_produk' => 'required',
            'jumlah' => 'required',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'kode_produk.required' => 'Produk harus diisi',
            'jumlah.required' => 'Jumlah harus diisi',
        ]);
        $penjualan->tanggal = $request->tanggal;
        $penjualan->kode_produk = $request->kode_produk;
        $penjualan->jumlah = $request->jumlah;
        $penjualan->save();
        return redirect('penjualan')->with('message', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();
        return redirect('penjualan')->with('message', 'Data berhasil dihapus!');
    }
}
