@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <h3 style="color:black;">Jumlah Rawat Inap</h3>
            
            <!-- Form Filter -->
            <div class="panel">
                <div class="panel-body">
                    <form action="{{ route('jri') }}" method="GET" class="form-inline">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="year" class="sr-only">Tahun</label>
                            <select name="year" id="year" class="form-control">
                                @foreach ($dataTahun as $tahun)
                                    <option value="{{ $tahun }}" {{ $year == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="month" class="sr-only">Bulan</label>
                            <select name="month" id="month" class="form-control">
                                @foreach ($dataBulan as $bulan)
                                    <option value="{{ $bulan }}" {{ $month == $bulan ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Filter</button>
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
@stop

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
@stop