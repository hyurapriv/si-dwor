@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <h3 style="color:black;">Jumlah Pasien Terlayani</h3>
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
        text: 'Jumlah'
    }
},

xAxis: {
    categories: {!! json_encode($tanggal) !!} ,
    title: {
        text: 'Tanggal'
    }
},

legend: {
    layout: 'horizontal',
    align: 'center',
    verticalAlign: 'bottom'
},
plotOptions: {
    series: {
        label: {
            connectorAllowed: false
        },
            dataLabels: {
                enabled: true
            }
    },
    
},

series: [ 
{  
    visible: false,
    name: 'igd',
    data: {!! json_encode($igd) !!} 
},{
    visible: false,
    name: 'perinatologi',
    data: {!! json_encode($perinatologi) !!} 
},{
    visible: false,
    name: 'poli_anak',
    data: {!! json_encode($poli_anak) !!} 
},
{
    
    visible: false,
    name: 'poli_anak_target',
    data: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1] 
},
{
    
    visible: false,
    name: 'poli_anak_base_line',
    data: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1] 
},{
    visible: false,
    name: 'poli_bedah',
    data: {!! json_encode($poli_bedah) !!} 
},
{
    
    visible: false,
    name: 'poli_bedah_target',
    data: [4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4] 
},
{
    
    visible: false,
    name: 'poli_bedah_base_line',
    data: [4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4] 
},
{
    visible: false,
    name: 'poli_gigi_umum',
    data: {!! json_encode($poli_gigi_umum) !!} 
},
{
    
    visible: false,
    name: 'poli_gigi_umum_target',
    data: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1] 
},
{
    
    visible: false,
    name: 'poli_gigi_umum_base_line',
    data: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1] 
},{
    visible: false,
    name: 'poli_jantung',
    data: {!! json_encode($poli_jantung) !!} 
},
{
    
    visible: false,
    name: 'poli_jantung_target',
    data: [8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8] 
},
{
    
    visible: false,
    name: 'poli_jantung_base_line',
    data: [7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7] 
},{
    visible: false,
    name: 'poli_konservasi_gigi',
    data: {!! json_encode($poli_konservasi_gigi) !!} 
},
{
    
    visible: false,
    name: 'poli_konservasi_gigi_target',
    data: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1] 
},
{
    
    visible: false,
    name: 'poli_konservasi_gigi_base_line',
    data: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1] 
},{
    visible: false,
    name: 'poli_kulit_kelamin',
    data: {!! json_encode($poli_kulit_kelamin) !!} 
},
{
    
    visible: false,
    name: 'poli_kulit_kelamin_target',
    data: [14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14] 
},
{
    
    visible: false,
    name: 'poli_kulit_kelamin_base_line',
    data: [12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12] 
},{
    visible: false,
    name: 'poli_kusta',
    data: {!! json_encode($poli_kusta) !!} 
},
{
    
    visible: false,
    name: 'poli_kusta_target',
    data: [5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5] 
},
{
    
    visible: false,
    name: 'poli_kusta_line',
    data: [4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4] 
},
{
    visible: false,
    name: 'poli_mata',
    data: {!! json_encode($poli_mata) !!} 
},
{
    
    visible: false,
    name: 'poli_mata_target',
    data: [74,74,74,74,74,74,74,74,74,74,74,74,74,74,74,74,74,74,74,74] 
},
{
    
    visible: false,
    name: 'poli_mata_base_line',
    data: [62,62,62,62,62,62,62,62,62,62,62,62,62,62,62,62,62,62,62,62] 
},{
    
    visible: false,
    name: 'poli_obgyn',
    data: {!! json_encode($poli_obgyn) !!} 
},
{
    
    visible: false,
    name: 'poli_obgyn_target',
    data: [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2] 
},
{
    
    visible: false,
    name: 'poli_obgyn_base_line',
    data: [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2] 
},{
    
    visible: false,
    name: 'poli_orthopedi',
    data: {!! json_encode($poli_orthopedi) !!} 
},
{
    
    visible: false,
    name: 'poli_orthopedi_target',
    data: [5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5] 
},
{
    
    visible: false,
    name: 'poli_orthopedi_line',
    data: [4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4] 
},{
    
    visible: false,
    name: 'poli_peny_dalam',
    data: {!! json_encode($poli_peny_dalam) !!} 
},
{
    
    visible: false,
    name: 'poli_peny_dalam_target',
    data: [15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15] 
},
{
    
    visible: false,
    name: 'poli_peny_dalam_line',
    data: [13,13,13,13,13,13,13,13,13,13,13,13,13,13,13,13,13,13,13,13] 
},{
    visible: false,
    name: 'poli_tb',
    data: {!! json_encode($poli_tb) !!} 
},{
    visible: false,
    name: 'poli_tht_kl',
    data: {!! json_encode($poli_tht_kl) !!} 
},
{
    
    visible: false,
    name: 'poli_tht_kl_target',
    data: [4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4] 
},
{
    
    visible: false,
    name: 'poli_tht_kl_line',
    data: [4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4]  
},{
    visible: false,
    name: 'poli_umum',
    data: {!! json_encode($poli_umum) !!} 
},
{
    
    visible: false,
    name: 'poli_umum_target',
    data: [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2] 
},
{
    
    visible: false,
    name: 'poli_umum_line',
    data: [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2]  
},
{
    visible: false,
    name: 'rehab_medik',
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


