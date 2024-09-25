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

          <!-- ============================================================== -->
  <!-- End Page wrapper  -->
            <form action="{{ route('user.update', $row) }}" method="POST">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                {{ show_error($errors) }}
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="mb-3">
                                    <label>Nama user <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="nama"
                                        value="{{ old('nama', $row->nama) }}" />
                                </div>
                                <div class="mb-3">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="username"
                                        value="{{ old('username', $row->username) }}" />
                                </div>
                                <div class="mb-3">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="password"
                                        value="{{ old('password', $row->password) }}" />
                                </div>
                                <div class="mb-3">
                                    <label>Level <span class="text-danger">*</span></label>
                                    <select class="form-control" name="level">
                                        <?= get_level_option(old('level', $row->level)) ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        <a class="btn btn-danger" href="{{ URL('user') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </form>
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

@endsection