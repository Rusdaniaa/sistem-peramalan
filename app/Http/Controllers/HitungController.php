<?php

namespace App\Http\Controllers;
use App\Models\Hasil;
use App\MovingAverage;
use App\Models\Produk;
use Illuminate\Http\Request;

class HitungController extends Controller
{
    function index()
    {
        $data['title'] = 'Perhitungan';
        $data['awal'] = get_var("SELECT MIN(tanggal) FROM penjualan");
        $data['akhir'] = get_var("SELECT MAX(tanggal) FROM penjualan");
        return view('hitung.index', $data);
    }

    function hasilCetak(Request $request)
    {
        $data['q'] = $request->input('q');
        $data['kode_produk'] = $request->input('kode_produk');
        $data['title'] = 'Hasil Peramalan';
        $query = Hasil::leftJoin('produk', 'produk.kode_produk', '=', 'hasil.kode_produk')
            ->orderBy('tanggal', 'DESC');
        if ($data['kode_produk'])
            $query->where('produk.kode_produk', $data['kode_produk']);
        $data['rows'] = $query->get();
        $data['no'] = 1;
        return view('hasil.cetak', $data);
    }

    function hasil(Request $request)
    {
        $data['q'] = $request->input('q');
        $data['kode_produk'] = $request->input('kode_produk');
        $data['title'] = 'Hasil Peramalan';
        $data['limit'] = 25;
        $query = Hasil::where(function ($query) use ($data) {
            $query->where('nama_produk', 'like', '%' . $data['q'] . '%')
                ->orWhere('hasil.kode_produk', 'like', '%' . $data['q'] . '%');
        })->leftJoin('produk', 'produk.kode_produk', '=', 'hasil.kode_produk')
            ->orderBy('tanggal', 'DESC');
        if ($data['kode_produk'])
            $query->where('produk.kode_produk', $data['kode_produk']);
        $data['rows'] = $query->paginate($data['limit'])->withQueryString();
        $data['no'] = $data['rows']->firstItem();
        return view('hasil.index', $data);
    }

    function detail(Request $request)
    {
        /** $data adalah array data yang akan dikirim di view */
        $data['awal'] = $request->awal;
        $data['akhir'] = $request->akhir;
        $data['next_periode'] = $request->next_periode;
        $data['moving_periode'] = $request->moving_periode;
        $data['kode_produk'] = $request->kode_produk;

        $data['data_cetak'] = $data;

        $data['title'] = "Hasil Perhitungan "; //judul halaman

        $produks = Produk::all(); //mengambil semua produk
        /** Menyimpan produk dalam array */
        $data['produks'] = array();
        foreach ($produks as $row) {
            $data['produks'][$row->kode_produk] = $row->nama_produk;
        }


        /** mengambil data nilai periode */

        $rows = get_results("SELECT MAX(tanggal) as tanggal, SUM(jumlah) AS total FROM penjualan WHERE tanggal>='$data[awal]' AND tanggal<='$data[akhir]' AND kode_produk='$data[kode_produk]' GROUP BY YEAR(tanggal), MONTH(tanggal)");

        /** Menyimpan data nilai periode dalam array */
        $data['data'] = array();
        foreach ($rows as $row) {
            $data['data'][$row->tanggal] = $row->total;
        }

        $data['ma'] = new MovingAverage($data['data'], $data['moving_periode'], $data['next_periode']);
        $max = max(array_keys($data['ma']->yt));

        foreach ($data['ma']->next_ft as $key => $val) {
            $tanggal = date('Y-m-d', strtotime("+$key month", strtotime($max)));
            $tahun = date('Y', strtotime("+$key month", strtotime($max)));
            $bulan = date('m', strtotime("+$key month", strtotime($max)));

            Hasil::where('kode_produk', $request->kode_produk)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->delete();
            $hasil = new Hasil([
                'tanggal' => $tanggal,
                'kode_produk' => $request->kode_produk,
                'jumlah' => $val,
                'mape' => $data['ma']->error['MAPE'],
            ]);
            $hasil->save();
        }
        return view('hitung.detail', $data); //memanggil view hitung.hasil
    }

    function cetak(Request $request)
    {
        /** $data adalah array data yang akan dikirim di view */
        $data['periode'] = $request->query('periode');
        $data['title'] = "Hasil Perhitungan " . $data['periode']; //judul halaman
        $data['awal'] = $request->query('awal');
        $data['akhir'] = $request->query('akhir');
        $data['next_periode'] = $request->query('next_periode');
        $data['moving_periode'] = $request->query('moving_periode');
        $data['kode_produk'] = $request->query('kode_produk');


        $produks = Produk::all(); //mengambil semua produk
        /** Menyimpan produk dalam array */
        $data['produks'] = array();
        foreach ($produks as $row) {
            $data['produks'][$row->kode_produk] = $row->nama_produk;
        }


        /** mengambil data nilai periode */
        $rows = get_results("SELECT MAX(tanggal) as tanggal, SUM(jumlah) AS total FROM penjualan WHERE tanggal>='$data[awal]' AND tanggal<='$data[akhir]' AND kode_produk='$data[kode_produk]' GROUP BY YEAR(tanggal), MONTH(tanggal)");

        /** Menyimpan data nilai periode dalam array */
        $data['data'] = array();
        foreach ($rows as $row) {
            $data['data'][$row->tanggal] = $row->total;
        }

        $data['ma'] = new MovingAverage($data['data'], $data['moving_periode'], $data['next_periode']);

        return view('hitung.cetak', $data); //memanggil view hitung.hasil
    }
}
