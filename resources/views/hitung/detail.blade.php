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
                        <?php
                        $categories = [];
                        $series = [];
                        ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <a data-bs-toggle="collapse" href="#c">Perhitungan</a>
                            </div>
                            <div class="table-responsive collapse show" id="c">
                                <table class="table table-bordered table-hover table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Periode (t)</th>
                                            <th>X<sub>t</sub></th>
                                            <th>F<sub>t</sub></th>
                                            <th>e<sub>t</sub></th>
                                            <th>e<sub>t</sub><sup>2</sup></th>
                                            <th>|e<sub>t</sub>|</th>
                                            <th>|e<sub>t</sub> / y<sub>t</sub>|</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($ma->yt as $key => $val) :

                                        $categories[$key] =  date('M-Y', strtotime($key)) ;
                                        $series['aktual']['data'][$key] = $val * 1;
                                        $series['prediksi']['data'][$key] = isset($ma->ft[$key]) ? round($ma->ft[$key], 2) : null; ?>
                                    <tr>
                                        <td><?= $categories[$key] ?></td>
                                        <td><?= round($val) ?></td>
                                        <td><?= isset($ma->ft[$key]) ? round($ma->ft[$key], 3) : null ?></td>
                                        <td><?= isset($ma->et[$key]) ? round($ma->et[$key], 3) : '' ?></td>
                                        <td><?= isset($ma->et[$key]) ? round($ma->et_square[$key], 3) : '' ?></td>
                                        <td><?= isset($ma->et[$key]) ? round($ma->et_abs[$key], 3) : '' ?></td>
                                        <td><?= isset($ma->et[$key]) ? round($ma->et_yt[$key] * 100, 3) . '%' : '' ?></td>
                                    </tr>
                                    <?php endforeach ?>
                                    <tr>
                                        <td colspan="4" class="text-right">MSE (Mean Squared Error)</td>
                                        <td><?= number_format($ma->error['MSE'], 3) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">RMSE (Root Mean Squared Error)</td>
                                        <td><?= number_format($ma->error['RMSE'], 3) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">MAE (Mean Absolute Error)</td>
                                        <td>&nbsp;</td>
                                        <td><?= number_format($ma->error['MAE'], 3) ?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">MAPE (Mean Absolute Percentage Error)</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= number_format($ma->error['MAPE'] * 100, 3) ?> % </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="card-body">
                                Hasil Prediksi:
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Periode (n)</th>
                                            <th>F<sub>t</sub></th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $max = max(array_keys($ma->yt));
                                    foreach ($ma->next_ft as $key => $val) :
                                        $key = date('Y-M', strtotime("+$key month", strtotime($max)));
                                        $categories[$key] =  $key;
                                        $series['aktual']['data'][$key] = null;
                                        $series['prediksi']['data'][$key] = round($val, 3); ?>
                                    <tr>
                                        <td><?= $key ?></td>
                                        <td><?= number_format($val, 3) ?></td>
                                    </tr>
                                    <?php endforeach ?>
                                </table>
                            </div>
                            <div class="card-body">
                                <script src="https://code.highcharts.com/highcharts.js"></script>
                                <script src="https://code.highcharts.com/modules/series-label.js"></script>
                                <script src="https://code.highcharts.com/modules/exporting.js"></script>
                                <script src="https://code.highcharts.com/modules/export-data.js"></script>
                                <script src="https://code.highcharts.com/modules/accessibility.js"></script>
                                <div id="container"></div>
                                <script>
                                    <?php
                                    $categories = array_values($categories);
                                    $series['aktual']['name'] = 'Aktual';
                                    $series['prediksi']['name'] = 'Prediksi';
                                    $series['aktual']['data'] = array_values($series['aktual']['data']);
                                    $series['prediksi']['data'] = array_values($series['prediksi']['data']);
                                    $series = array_values($series);
                                    ?>
                                    Highcharts.chart('container', {
                                        chart: {
                                            type: 'line'
                                        },
                                        title: {
                                            text: 'Grafik Data dan Hasil Prediksi'
                                        },
                                        // subtitle: {
                                        //     text: 'Source: WorldClimate.com'
                                        // },
                                        xAxis: {
                                            categories: <?= json_encode($categories) ?>
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        plotOptions: {
                                            line: {
                                                dataLabels: {
                                                    enabled: true
                                                },
                                                enableMouseTracking: false
                                            }
                                        },
                                        series: <?= json_encode($series) ?>
                                    });
                                </script>
                            </div>
                        </div>
                        <a class="btn btn-secondary" href="{{ route('hitung.cetak', $data_cetak) }}" target="_blank"><span
                                class="fa fa-print"></span> Cetak</a>
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

