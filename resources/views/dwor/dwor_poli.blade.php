@extends('layouts.master')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 style="color:black;">Jumlah Pasien Terlayani <?php echo $xjudul; ?></h3>
                        </div>
                        <div class="col-sm-4">
                            <form action="{{ route('dwor.utama', ['data_poli' => $selectedPoli]) }}" method="GET"
                                class="form-inline">
                                <select name="year" class="form-control mr-2">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                            {{ $year }}</option>
                                    @endforeach
                                </select>
                                <select name="month" class="form-control mr-2">
                                    @foreach ($months as $monthNum => $monthName)
                                        <option value="{{ $monthNum }}"
                                            {{ $selectedMonth == $monthNum ? 'selected' : '' }}>{{ $monthName }}</option>
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
                                        <li class="{{ $xjudul == 'IGD' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'igd']) }}">IGD</a></li>
                                        <li class="{{ $xjudul == 'Poli Anak' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'anak']) }}">Poli Anak</a>
                                        </li>
                                        <li class="{{ $xjudul == 'Poli Bedah' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'bedah']) }}">Poli Bedah</a>
                                        </li>
                                        <li class="{{ $xjudul == 'Poli Gigi Umum' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'gigi_umum']) }}">Poli Gigi Umum</a>
                                        </li>
                                        <li class="{{ $xjudul == 'Poli Jantung' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'jantung']) }}">Poli Jantung</a>
                                        </li>
                                        <li class="{{ $xjudul == 'Poli Konservasi Gigi' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'konservasi']) }}">Poli Konservasi Gigi</a>
                                        </li>
                                        <li class="{{ $xjudul == 'Poli Kulit' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'kulit']) }}">Poli Kulit</a>
                                        </li>
                                        <li class="{{ $xjudul == 'Poli Kusta' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'kusta']) }}">Poli Kusta</a>
                                        </li>
                                        <li class="{{ $xjudul == 'Poli Penyakit Dalam' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'penyakit_dalam']) }}">Poli Penyakit Dalam</a>
                                        </li>
                                        <li class="{{ $xjudul == 'Poli THT KL' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'tht_kl']) }}">Poli THT KL</a>
                                        </li>
                                        <li class="{{ $xjudul == 'Poli Umum' ? 'active' : '' }}"><a
                                                href="{{ route('dwor.utama', ['data_poli' => 'umum']) }}">Poli Umum</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                </br></br>
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
                {   
                    visible: false,
                    name: 'Total',
                    data: {!! json_encode($chartData['total']) !!} 
                },
                {
                    name: {!! json_encode($xjudul) !!},
                    data: {!! json_encode($chartData['data_poli']) !!} 
                },
                {
                    visible: false,
                    name: 'Total target <?php echo $xjudul ?> ',
                    data: {!! json_encode($chartData['target']) !!} 
                },
                {
                    visible: false,
                    name: 'Total line <?php echo $xjudul ?> ',
                    data: {!! json_encode($chartData['base_line']) !!}  
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
