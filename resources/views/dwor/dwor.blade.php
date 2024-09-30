{{-- dwor.blade.php --}}
@extends('layouts.master')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 style="color:black;">Jumlah Pasien Terlayani Secara Total</h3>
                        </div>
                        <div class="col-sm-4">
                            <form action="{{ route('dwor.index') }}" method="GET" class="form-inline">
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
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <ul class="nav">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i
                                            class="fa fa-filter"></i> Kompare Poli <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('dwor.index') }}">Total</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'igd']) }}">IGD</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'anak']) }}">Poli Anak</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'bedah']) }}">Poli Bedah</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'gigi_umum']) }}">Poli Gigi Umum</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'jantung']) }}">Poli Jantung</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'konservasi']) }}">Poli Konservasi Gigi</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'kulit']) }}">Poli Kulit Kelamin</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'kusta']) }}">Poli Kusta</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'mata']) }}">Poli Mata</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'obgyn']) }}">Poli Obgyn</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'orthopedi']) }}">Poli Orthopedi</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'penyakit_dalam']) }}">Poli Penyakit Dalam</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'tht_kl']) }}">Poli THT KL</a></li>
                                        <li><a href="{{ route('dwor.utama', ['poli' => 'umum']) }}">Poli Umum</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Grafik</h3>
                            </div>
                            <div class="panel-body no-padding">
                                <div id="chartnilai"></div>
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
                categories: {!! json_encode($chartData['tanggal'] ?? []) !!},
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
                    name: 'Total',
                    data: {!! json_encode($chartData['total'] ?? []) !!} 
                },
                @if(isset($chartData['target']))
                {
                    name: 'Target',
                    data: {!! json_encode($chartData['target']) !!} 
                },
                @endif
                @if(isset($chartData['base_line']))
                {
                    name: 'Base line',
                    data: {!! json_encode($chartData['base_line']) !!}  
                }
                @endif
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