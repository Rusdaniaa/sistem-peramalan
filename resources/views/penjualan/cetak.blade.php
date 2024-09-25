@extends('layout.print')
@section('title', $title)
@section('content')
    <table class="table table-bordered table-hover table-striped m-0">
        <thead>
            <th>No</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Jumlah</th>
        </thead>
        <?php $no = 1; ?>
        @foreach ($rows as $key => $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->nama_produk }}</td>
                <td>{{ number_format($row->jumlah) }}</td>
            </tr>
        @endforeach
    </table>
@endsection
