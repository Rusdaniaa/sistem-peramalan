@extends('layout.print')
@section('title', $title)
@section('content')
    <table class="table table-bordered table-hover table-striped m-0">
        <thead>
            <th>No</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>MAPE</th>
        </thead>
        @foreach ($rows as $key => $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ date('M-Y', strtotime($row->tanggal)) }}</td>
                <td>{{ $row->nama_produk }}</td>
                <td>{{ number_format($row->jumlah, 2) }}</td>
                <td>{{ number_format($row->mape, 2) }}</td>
            </tr>
        @endforeach
    </table>
@endsection
s
