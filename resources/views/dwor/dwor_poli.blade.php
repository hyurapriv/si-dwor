@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
                                    <div class="container">
                                        <div class="row">
                                        <div class="col-sm-10">
                                            <h3 style="color:black;">Jumlah Pasien Terlayani <?php echo $xjudul ?> </h3>
                                        </div>
                                        <div class="col-sm-2">
                                            <ul class="nav">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-filter"></i>  kompare Poli <span class="caret">
                                                </span> </a>
                                                <ul class="dropdown-menu">
                                                    <li class="{{ ( $xjudul ==="IGD"  ) ? 'active' : ''}}"><a href="/dwor/igd">IGD</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Anak"  ) ? 'active' : ''}}"><a href="/dwor/anak">Poli Anak</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Bedah"  ) ? 'active' : ''}}"><a href="/dwor/bedah">Poli Bedah</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Gigi Umum"  ) ? 'active' : ''}}"><a href="/dwor/gigi_umum">Poli Gigi Umum</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Jantung"  ) ? 'active' : ''}}"><a href="/dwor/jantung">Poli Jantung</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Konservasi Gigi"  ) ? 'active' : ''}}"><a href="/dwor/konservasi">Poli Konservasi Gigi</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Kulit Kelamin"  ) ? 'active' : ''}}"><a href="/dwor/kulit">Poli Kulit Kelamin</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Kusta"  ) ? 'active' : ''}}"><a href="/dwor/kusta">Poli Kusta</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Mata"  ) ? 'active' : ''}}"><a href="/dwor/mata">Poli Mata</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Obgyn"  ) ? 'active' : ''}}"><a href="/dwor/obgyn">Poli Obgyn</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Orthopedi"  ) ? 'active' : ''}}"><a href="/dwor/orthopedi">Poli Orthopedi</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Penyakit Dalam"  ) ? 'active' : ''}}"><a href="/dwor/penyakit_dalam">Poli Penyakit Dalam</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli THT KL"  ) ? 'active' : ''}}"><a href="/dwor/tht_kl">Poli THT KL</a></li>
                                                    <li class="{{ ( $xjudul ==="Poli Umum"  ) ? 'active' : ''}}" ><a href="/dwor/umum">Poli Umum</a></li>
                                                    <li  ><a href="/">Total</a></li>
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


{   visible: false,
    name: 'Total',
    data: {!! json_encode($total) !!} 
},{
    name:  {!! json_encode($xjudul) !!},
    data: {!! json_encode($data_poli) !!} 
},
{
    
    visible: false,
    name: 'Total target <?php echo $xjudul ?> ',
    data: {!! json_encode($target) !!} 
},
{
    
    visible: false,
    name: 'Total line <?php echo $xjudul ?> ',
    data:{!! json_encode($base_line) !!}  
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


