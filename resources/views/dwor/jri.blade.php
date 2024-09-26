@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <h3 style="color:black;">Jumlah Rawat Inap</h3>
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
            <div class="row">

                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Data Tabel</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr><th>Tanggal</th><th>Jumlah</th>
                                </thead>
                                <tbody>
                                    @foreach ($dwor as $item)
                                    <tr>
                                        <td>{{ $item->tgl }}</td>
                                        <td>{{ $item->jml }}</td>
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
    name: 'Jumlah',
    data: {!! json_encode($jml ) !!} 
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


