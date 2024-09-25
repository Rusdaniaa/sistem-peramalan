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
            <div class="card-header">
                <form class="form-inline">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group d-flex ">
                                <input class="form-control" type="text" name="q" value="{{ $q }}"
                                placeholder="Pencarian..." />
                                <button class="btn btn-primary"></i> Cari</button>
                            </div>
                        </div>
                        <div class="col-md-2 flex-shrink-0 ml-2 justify-content-end ">
                            <a class="btn btn-success" href="{{ route('user.create') }}"><i class="fa fa-plus"></i> Tambah</a>
                        </div>
                    </div>
                </form>
            </div>
              <div class="table-responsive">
                <table
                  id="zero_config"
                  class="table table-striped table-bordered"
                >
                <thead>
                    <th>No</th>
                    <th>Nama user</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </thead>
                @foreach ($rows as $key => $row)
                    <tr>
                        <td>{{ ($rows->currentPage() - 1) * $limit + $key + 1 }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->level }}</td>
                        <td>
                            <a class="btn btn-sm btn-info" href="{{ route('user.edit', $row) }}"><i class="fa fa-edit"></i>
                                Ubah</a>
                            <form action="{{ route('user.destroy', $row) }}" method="POST" style="display: inline-block;"
                                onsubmit="return confirm('Hapus Data?')">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>
                                    Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                  </tbody>
                </table>
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
