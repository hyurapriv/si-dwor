@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
                                    <div class="container">
                                        <div class="row">
                                        <div class="col-sm-10">
                                            <h3 style="color:black;">Jumlah Pasien Terlayani Secara Total</h3>
                                        </div>
                                        {{-- <nav>
                                            <ul class="nav">
                                                <li><a href="/" class="{{ ($judul  === "index") ? 'active' : ''}}"><i class="lnr lnr-home"></i> <span>Jumlah Pasien Terlayani</span></a></li>
                                                <li><a href="/bor" class="{{ ($judul  === "bor") ? 'active' : ''}}"><i class="lnr lnr-home"></i> <span>Jumlah MRS</span></a></li>
                                                <li><a href="/jri" class="{{ ($judul  === "jri") ? 'active' : ''}}"><i class="lnr lnr-code"></i> <span>Jumlah Rawat Inap</span></a></li>
                                                <li><a href="/jkpl" class="{{ ($judul  === "jkpl") ? 'active' : ''}}"><i class="lnr lnr-chart-bars"></i> <span>Jumlah Kunjungan Pasien Lama</span></a></li>
                                                <li><a href="/jkpb" class="{{ ($judul  === "jkpb") ? 'active' : ''}}"><i class="lnr lnr-cog"></i> <span>Jumlah Kunjungan Pasien Baru</span></a></li>
                                            </ul>
                                        </nav> --}}

                                        <div class="col-sm-2">
                                            <ul class="nav">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-filter"></i>  kompare Poli <span class="caret">
                                                </span> </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="/dwor/igd">IGD</a></li>
                                                    <li><a href="/dwor/anak">Poli Anak</a></li>
                                                    <li><a href="/dwor/bedah">Poli Bedah</a></li>
                                                    <li><a href="/dwor/gigi_umum">Poli Gigi Umum</a></li>
                                                    <li><a href="/dwor/jantung">Poli Jantung</a></li>
                                                    <li><a href="/dwor/konservasi">Poli Konservasi Gigi</a></li>
                                                    <li><a href="/dwor/kulit">Poli Kulit Kelamin</a></li>
                                                    <li><a href="/dwor/kusta">Poli Kusta</a></li>
                                                    <li><a href="/dwor/mata">Poli Mata</a></li>
                                                    <li><a href="/dwor/obgyn">Poli Obgyn</a></li>
                                                    <li><a href="/dwor/orthopedi">Poli Orthopedi</a></li>
                                                    <li><a href="/dwor/penyakit_dalam">Poli Penyakit Dalam</a></li>
                                                    <li><a href="/dwor/tht_kl">Poli THT KL</a></li>
                                                    <li><a href="/dwor/umum">Poli Umum</a></li>
                                                    <li class="{{ ( $judul ==="index"  ) ? 'active' : ''}}"><a href="/">Total</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                            </div>
                                        </div>
                                        </div>
                                 

                        {{-- <h3 class="title">Jumlah Pasien Terlayani 
                       
                            <select class="input-sm right" Total> 
                                <option value="cheese"><a href="#">Basic Use</a></option>
                                <option value="tomatoes">Tomatoes</option>
                                <option value="mozarella">Mozzarella</option>
                                <option value="mushrooms">Mushrooms</option>
                                <option value="pepperoni">Pepperoni</option>
                                <option value="onions">Onions</option>
                            </select>
                        </h3> --}}
                        </br></br>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- RECENT PURCHASES -->
                                <div class="panel">
                                    <div class="panel-heading">
                               
                                        <h3 class="panel-title">Grafik</h3>

                                        

                                    </div>
                                    <div class="panel-body no-padding">
                                        <div id="chartnilai"></div>
                                    </div>
                                
                                </div>
                                <!-- END RECENT PURCHASES -->
                            </div>
                           
                        </div>
                        
                        
            {{-- <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Grafik
                        
                    </h3>
                 
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
          --}}

            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recent Purchases</h3>
                            <div class="right">
                                <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                                <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                            </div>
                        </div>
                        <div class="panel-body no-padding">
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
                        </div>
                      
                    </div>
                </div> --}}

            {{-- <div class="row">
                <div >
                    <!-- RECENT PURCHASES -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recent Purchases</h3>
                            <div class="right">
                                <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
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
                                                <div id="chartnilai"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    
                    
                </div>
            </div> --}}

       
            {{-- <div class="row">

                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Data Tabel</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr><th>tanggal</th><th>igd</th><th>perinatologi</th><th>anak</th><th>bedah</th><th>gigi umum</th>
                                        <th>jantung</th> <th>konservasi gigi</th> <th>kulit kelamin</th> <th>kusta</th>
                                        <th>mata</th> <th>obgyn</th> <th>orthopedi</th> <th>peny dalam</th> <th>tb</th>
                                         <th>tht kl</th> <th>umum</th> <th>rehab medik</th> <th>Total</th> </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dwor as $item)
                                    <tr>
                                        <td>{{ $item->tgl }}</td>
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
             
            </div> --}}
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
},credits: {
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
    categories: {!! json_encode($tanggal) !!} ,
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
    data: {!! json_encode($total) !!} 
},
{
    
    visible: false,
    name: 'Target',
    data: {!! json_encode($target) !!} 
},
{
    
    visible: false,
    name: 'Base line',
    data: {!! json_encode($base_line) !!} 
}],

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


