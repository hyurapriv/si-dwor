@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <h3 style="color:black;">Jumlah MRS</h3>
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

{  
    visible: false,
    name: 'IGD',
    data: {!! json_encode($igd) !!} 
},{
    visible: false,
    name: 'Perinatologi',
    data: {!! json_encode($perinatologi) !!} 
},{
    visible: false,
    name: 'Poli Anak',
    data: {!! json_encode($poli_anak) !!} 
},{
    visible: false,
    name: 'Poli Bedah',
    data: {!! json_encode($poli_bedah) !!} 
},
{
    visible: false,
    name: 'Poli Gigi Umum',
    data: {!! json_encode($poli_gigi_umum) !!} 
},{
    visible: false,
    name: 'Poli Jantung',
    data: {!! json_encode($poli_jantung) !!} 
},{
    visible: false,
    name: 'Poli Konservasi Gigi',
    data: {!! json_encode($poli_konservasi_gigi) !!} 
},{
    visible: false,
    name: 'Poli Kulit Kelamin',
    data: {!! json_encode($poli_kulit_kelamin) !!} 
},{
    visible: false,
    name: 'Poli Kusta',
    data: {!! json_encode($poli_kusta) !!} 
},
{
    visible: false,
    name: 'Poli Mata',
    data: {!! json_encode($poli_mata) !!} 
},{
    
    visible: false,
    name: 'Poli Obgyn',
    data: {!! json_encode($poli_obgyn) !!} 
},{
    
    visible: false,
    name: 'Poli Orthopedi',
    data: {!! json_encode($poli_orthopedi) !!} 
},{
    
    visible: false,
    name: 'Poli Penyakit Dalam',
    data: {!! json_encode($poli_peny_dalam) !!} 
},{
    visible: false,
    name: 'Poli TB',
    data: {!! json_encode($poli_tb) !!} 
},{
    visible: false,
    name: 'Poli THT KL',
    data: {!! json_encode($poli_tht_kl) !!} 
},{
    visible: false,
    name: 'Poli Umum',
    data: {!! json_encode($poli_umum) !!} 
},
{
    visible: false,
    name: 'Rehab Medik',
    data: {!! json_encode($rehab_medik) !!} 
},
{
    name: 'Total',
    data: {!! json_encode($total) !!} 
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


