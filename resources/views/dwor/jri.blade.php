{{-- JRI --}}
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
                        <h3 style="color:black;">Jumlah Rawat Inap</h3>
                    </div>
                    <div class="col-sm-4">
                        <form action="{{ route('jri') }}" method="GET" class="form-inline">
                            <select name="year" class="form-control mr-2">
                                @foreach ($tahun as $thn)
                                    <option value="{{ $thn }}" {{ $selectedYear == $thn ? 'selected' : '' }}>
                                        {{ $thn }}</option>
                                @endforeach
                            </select>
                            <select name="month" class="form-control mr-2">
                                @foreach ($bulan as $bln => $namaBln)
                                    <option value="{{ $bln }}"
                                        {{ $selectedMonth == $bln ? 'selected' : '' }}>{{ $namaBln }}</option>
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr><th>Tanggal</th><th>Jumlah</th></tr>
                                </thead>
                                <tbody>
                                    @foreach ($tanggal as $tgl)
                                    <tr>
                                        <td>{{ $tgl }}</td>
                                        <td>{{ $jml[$tgl] ?? 0 }}</td>
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
        categories: {!! json_encode($tanggal->toArray()) !!},
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
        {
            name: 'Jumlah',
            data: {!! json_encode($jml->values()->toArray()) !!}
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
@endsection