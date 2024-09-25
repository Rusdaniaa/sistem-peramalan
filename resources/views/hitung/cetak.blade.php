@extends('layout.print')
@section('title', $title)
@section('content')
    <?php
    $categories = [];
    $series = [];
    ?>
    <h3>Proses Perhitungan</h3>
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
            $categories[$key] =  $periode == 'Bulanan' ? date('M-Y', strtotime($key)) : date('Y', strtotime($key));
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
    <h3>Hasil Prediksi</h3>
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
                    if($periode=='Bulanan')
                        $key = date('Y-m', strtotime("+$key month", strtotime($max)));
                    else
                        $key = date('Y', strtotime("+$key year", strtotime($max)));
                    $categories[$key] =  $key;
                    $series['aktual']['data'][$key] = null;
                    $series['prediksi']['data'][$key] = round($val, 3); ?>
        <tr>
            <td><?= $key ?></td>
            <td><?= number_format($val, 3) ?></td>
        </tr>
        <?php endforeach ?>
    </table>
    <br />
    <br />
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
@endsection
