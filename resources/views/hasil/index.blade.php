@extends('layout.app')
@section('title', $title)
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">Tables</h4>
          <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Library
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
      <!-- ============================================================== -->
      <!-- Start Page Content -->
      <!-- ============================================================== -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            {{ show_msg() }}
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="container mt-3">
                        <form class="form-inline">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group mr-1">
                                        <select class="form-control" name="kode_produk">
                                            <option value="">Semua Produk</option>
                                            <?= get_produk_option($kode_produk) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group d-flex ">
                                        <input class="form-control" type="text" name="q" value="{{ $q }}" placeholder="Pencarian..." />
                                        <button class="btn btn-success flex-shrink-0 ml-2"><i class="fa fa-search"></i>Cari</button>
                                    </div>
                                </div>
                                <div class="col-md-2 flex-shrink-0 ml-2 justify-content-end ">
                                    <a class="btn btn-secondary" href="{{ route('hitung.hasil.cetak', ['kode_produk' => $kode_produk]) }}" target="_blank">
                                        <span class="fa fa-print"></span> Cetak
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
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
                </div>
                @if ($rows->hasPages())
                    <div class="card-footer">
                        {{ $rows->links() }}
                    </div>
                @endif
            </div>
            </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- End PAge Content -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Right sidebar -->
      <!-- ============================================================== -->
      <!-- .right-sidebar -->
      <!-- ============================================================== -->
      <!-- End Right sidebar -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center">
      All Rights Reserved by Matrix-admin. Designed and Developed by
      <a href="https://www.wrappixel.com">WrapPixel</a>.
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
  </div>

  <!-- ============================================================== -->
  <!-- End Page wrapper  -->
@endsection

