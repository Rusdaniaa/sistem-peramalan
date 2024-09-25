
@extends('layout.app')
@section('title', $title)
@section('content')
<!-- Page wrapper  -->
     <!-- ============================================================== -->
     <div class="page-wrapper">
       <!-- ============================================================== -->
       <!-- Bread crumb and right sidebar toggle -->
       <!-- ============================================================== -->
       <div class="page-breadcrumb">
         <div class="row">
           <div class="col-12 d-flex no-block align-items-center">
             <h4 class="page-title">Dashboard</h4>
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
         <!-- Sales Cards  -->
         <!-- ============================================================== -->
         <div class="row">
           <!-- Column -->
           <div class="col-3">
               <div class="bg-cyan p-10 text-white text-center">
                 <i class="mdi mdi-account fs-3 mb-1 font-16"></i>
                 <h5 class="mb-0 mt-1">2540</h5>
                 <small class="font-light">Total Users</small>
               </div>
           </div>
           <div class="col-3">
               <div class="bg-warning p-10 text-white text-center">
                 <i class="mdi mdi-table fs-3 mb-1 font-16"></i>
                 <h5 class="mb-0 mt-1">100</h5>
                 <small class="font-light">Barang</small>
               </div>
             </div>

           <div class="col-3">
               <div class="bg-danger p-10 text-white text-center">
                 <i class="mdi mdi-tag fs-3 mb-1 font-16"></i>
                 <h5 class="mb-0 mt-1">656</h5>
                 <small class="font-light">Penjualan</small>
               </div>
             </div>
             <div class="col-3">
               <div class="bg-info p-10 text-white text-center">
                 <i class="mdi mdi-collage fs-3 mb-1 font-16"></i>
                 <h5 class="mb-0 mt-1">100</h5>
                 <small class="font-light">Kategori</small>
               </div>
             </div>

         </div>
         <!-- ============================================================== -->
         <!-- Sales chart -->
         <!-- ============================================================== -->

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
