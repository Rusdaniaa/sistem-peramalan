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

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('hitung.detail') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="mb-3">
                                    <label>Produk <span class="text-danger">*</span></label>
                                    <select class="form-control" name="kode_produk">
                                        <?= get_produk_option(old('kode_produk')) ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Awal <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="awal" value="{{ old('awal', $awal) }}" />
                                </div>
                                <div class="mb-3">
                                    <label>Akhir <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="akhir" value="{{ old('akhir', $akhir) }}" />
                                </div>
                                <div class="mb-3">
                                    <label>Periode Moving <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="moving_periode"
                                        value="{{ old('moving_periode', 3) }}" />
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah Periode yang Diramal <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="next_periode" value="{{ old('next_periode', 6) }}" />
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary"><span class="fa fa-signal"></span> Hitung</button>
                                </div>
                            </form>
                        </div>
                    </div>
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

