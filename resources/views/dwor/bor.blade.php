@extends('layouts.master')

@section('content')
<style>
    .table-responsive {
        overflow-x: auto;
    }

    .table th,
    .table td {
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .form-inline {
            flex-wrap: wrap;
        }

        .form-inline .form-control {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <h3 style="color:black;">Jumlah MRS</h3>
                    </div>
                    <div class="col-sm-4">
                        <form action="{{ route('bor') }}" method="GET" class="form-inline">
                            <select name="year" class="form-control mr-2">
                                @foreach ($tahun as $thn)
                                    <option value="{{ $thn }}" {{ $selectedYear == $thn ? 'selected' : '' }}>
                                        {{ $thn }}</option>
                                @endforeach
                            </select>
                            <select name="month" class="form-control mr-2">
                                @foreach ($bulan as $bln => $namaBln)
                                    <option value="{{ $bln }}" {{ $selectedMonth == $bln ? 'selected' : '' }}>
                                        {{ $namaBln }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Data Tabel</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" style="background-color: white;">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>IGD</th>
                                            <th>Perinatologi</th>
                                            <th>Anak</th>
                                            <th>Bedah</th>
                                            <th>Gigi Umum</th>
                                            <th>Jantung</th>
                                            <th>Konservasi Gigi</th>
                                            <th>Kulit Kelamin</th>
                                            <th>Kusta</th>
                                            <th>Mata</th>
                                            <th>Obgyn</th>
                                            <th>Orthopedi</th>
                                            <th>Peny. Dalam</th>
                                            <th>TB</th>
                                            <th>THT KL</th>
                                            <th>Umum</th>
                                            <th>Rehab Medik</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dwor as $item)
                                            <tr>
                                                <td>{{ $item->tgl_registrasi }}</td>
                                                <td>{{ $item->igd }}</td>
                                                <td>{{ $item->perinatologi }}</td>
                                                <td>{{ $item->poli_anak }}</td>
                                                <td>{{ $item->poli_bedah }}</td>
                                                <td>{{ $item->poli_gigi_umum }}</td>
                                                <td>{{ $item->poli_jantung }}</td>
                                                <td>{{ $item->poli_konservasi_gigi }}</td>
                                                <td>{{ $item->poli_kulit_kelamin }}</td>
                                                <td>{{ $item->poli_kusta }}</td>
                                                <td>{{ $item->poli_mata }}</td>
                                                <td>{{ $item->poli_obgyn }}</td>
                                                <td>{{ $item->poli_orthopedi }}</td>
                                                <td>{{ $item->poli_peny_dalam }}</td>
                                                <td>{{ $item->poli_tb }}</td>
                                                <td>{{ $item->poli_tht_kl }}</td>
                                                <td>{{ $item->poli_umum }}</td>
                                                <td>{{ $item->rehab_medik }}</td>
                                                <td>{{ $item->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        Highcharts.chart('chartnilai', {
            title: {
                text: ''
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
                categories: {!! json_encode($chartData['tanggal']) !!},
                title: {
                    text: 'Tanggal',
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
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                itemStyle: {
                    "fontSize": "15px",
                }
            },
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
            },
            series: [
                @foreach ($chartData as $key => $data)
                    @if ($key != 'tanggal')
                        {
                            name: '{{ ucfirst(str_replace('_', ' ', $key)) }}',
                            data: {!! json_encode($data) !!},
                            visible: {{ $key == 'total' ? 'true' : 'false' }}
                        },
                    @endif
                @endforeach
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
@endsection
