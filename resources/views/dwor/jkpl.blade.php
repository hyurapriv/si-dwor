@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <h3 style="color:black;">Jumlah Kunjungan Pasien Lama</h3>
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Filter</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('jkpl') }}" method="GET" class="form-inline">
                        <div class="form-group mr-2">
                            <label for="year" class="mr-2">Tahun:</label>
                            <select name="year" id="year" class="form-control">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-2">
                            <label for="month" class="mr-2">Bulan:</label>
                            <select name="month" id="month" class="form-control">
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Grafik</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <div id="chartnilai" class="ct-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Debug: Tampilkan informasi data -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Debug Info</h3>
                </div>
                <div class="panel-body">
                    <p>Selected Year: {{ $selectedYear }}</p>
                    <p>Selected Month: {{ $selectedMonth }}</p>
                    <p>Total Data Points: {{ count($tanggal) }}</p>
                    <p>First Date: {{ $tanggal[0] ?? 'N/A' }}</p>
                    <p>First Total: {{ $total[0] ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    Highcharts.chart('chartnilai', {
        title: {
            text: 'Jumlah Kunjungan Pasien Lama per Hari'
        },
        credits: {
            enabled: false
        },
        subtitle: {
            text: ''
        },
        yAxis: {
            title: {
                text: 'Jumlah',
                style: {
                    fontSize: '12px'
                }
            },
            labels: {
                style: {
                    fontSize: '11px'
                }
            }
        },
        xAxis: {
            type: 'datetime',
            title: {
                text: 'Tanggal',
                style: {
                    fontSize: '12px'
                }
            },
            labels: {
                format: '{value:%Y-%m-%d}',
                rotation: -45,
                style: {
                    fontSize: '11px'
                }
            }
        },
        legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            itemStyle: {
                fontSize: '15px',
            }
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                dataLabels: {
                    enabled: false
                }
            },
        },
        series: [
            {
                visible: false,
                name: 'IGD',
                data: {!! json_encode(array_map(null, $tanggal, $igd)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Perinatologi',
                data: {!! json_encode(array_map(null, $tanggal, $perinatologi)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Anak',
                data: {!! json_encode(array_map(null, $tanggal, $poli_anak)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Bedah',
                data: {!! json_encode(array_map(null, $tanggal, $poli_bedah)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Gigi Umum',
                data: {!! json_encode(array_map(null, $tanggal, $poli_gigi_umum)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Jantung',
                data: {!! json_encode(array_map(null, $tanggal, $poli_jantung)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Konservasi Gigi',
                data: {!! json_encode(array_map(null, $tanggal, $poli_konservasi_gigi)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Kulit Kelamin',
                data: {!! json_encode(array_map(null, $tanggal, $poli_kulit_kelamin)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Kusta',
                data: {!! json_encode(array_map(null, $tanggal, $poli_kusta)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Mata',
                data: {!! json_encode(array_map(null, $tanggal, $poli_mata)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Obgyn',
                data: {!! json_encode(array_map(null, $tanggal, $poli_obgyn)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Orthopedi',
                data: {!! json_encode(array_map(null, $tanggal, $poli_orthopedi)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Penyakit Dalam',
                data: {!! json_encode(array_map(null, $tanggal, $poli_peny_dalam)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli TB',
                data: {!! json_encode(array_map(null, $tanggal, $poli_tb)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli THT KL',
                data: {!! json_encode(array_map(null, $tanggal, $poli_tht_kl)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Poli Umum',
                data: {!! json_encode(array_map(null, $tanggal, $poli_umum)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                visible: false,
                name: 'Rehab Medik',
                data: {!! json_encode(array_map(null, $tanggal, $rehab_medik)) !!}.map(item => [Date.parse(item[0]), item[1]])
            },
            {
                name: 'Total',
                data: {!! json_encode(array_map(null, $tanggal, $total)) !!}.map(item => [Date.parse(item[0]), item[1]])
            }
        ],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
    </script>
@stop