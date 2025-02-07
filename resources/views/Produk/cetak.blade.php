@extends('layout.print')
@section('title', $title)
@section('content')
    <table class="table table-bordered table-hover table-striped m-0">
        <thead>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
        </thead>
        <?php $no = 1; ?>
        @foreach ($rows as $key => $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->kode_produk }}</td>
                <td>{{ $row->nama_produk }}</td>
            </tr>
        @endforeach
    </table>
@endsection
