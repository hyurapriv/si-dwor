@extends('layouts.master')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <h3 style="color:black;">Jumlah MRS</h3>
                <form method="GET" action="{{ route('bor') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="year" class="form-control">
                                @foreach($years as $yr)
                                    <option value="{{ $yr }}" {{ $yr == $selectedYear ? 'selected' : '' }}>{{ $yr }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="month" class="form-control">
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ $num == $selectedMonth ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">Grafik</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div id="chartnilai"></div>
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
                                            <tr>
                                                <th>tanggal</th>
                                                <th>igd</th>
                                                <th>perinatologi</th>
                                                <th>anak</th>
                                                <th>bedah</th>
                                                <th>gigi umum</th>
                                                <th>jantung</th>
                                                <th>konservasi gigi</th>
                                                <th>kulit kelamin</th>
                                                <th>kusta</th>
                                                <th>mata</th>
                                                <th>obgyn</th>
                                                <th>orthopedi</th>
                                                <th>peny dalam</th>
                                                <th>tb</th>
                                                <th>tht kl</th>
                                                <th>umum</th>
                                                <th>rehab medik</th>
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
                @foreach($chartData as $key => $data)
                    @if($key != 'tanggal')
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