@extends('layouts.page')

@section('content')
<!-- Morris.js charts -->
<script src="{{asset('/Highcharts-7.0.1/code/highcharts.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/series-label.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/exporting.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/export-data.js')}}"></script>

<div class="content">
  <!-- Content Header (Page header) -->








  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div id="container"></div>



          <script type="text/javascript">

      Highcharts.chart('container', {

          title: {
              text: 'Solar Employment Growth by Sector, 2010-2016'
          },

          subtitle: {
              text: 'Source: thesolarfoundation.com'
          },

          yAxis: {
              title: {
                  text: 'Number of Employees'
              }
          },
          legend: {
              layout: 'vertical',
              align: 'right',
              verticalAlign: 'middle'
          },

          plotOptions: {
              series: {
                  label: {
                      connectorAllowed: false
                  },
                  pointStart: 2010
              }
          },

          series: [{
              name: 'Installation',
              data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
          }, {
              name: 'Manufacturing',
              data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
          }, {
              name: 'Sales & Distribution',
              data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
          }, {
              name: 'Project Development',
              data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
          }, {
              name: 'Other',
              data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
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

    </div>

<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">ร้อยละความเสี่ยงของแต่ละกลุ่มงาน</h3>
      </div>
      <!-- /.box-header -->
        <div class="box-body">

          <div id="canvas-holder" style="width:100%; height:100%; ">
              <canvas id="chartPie-area"></canvas>
          </div>

        </div>
    </div>


  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">ร้อยละความเสี่ยงของแต่ละหมวดหมู่อุบัติการณ์</h3>
      </div>
      <!-- /.box-header -->
        <div class="box-body">

          <div id="canvas-holder" style="width:100%; ">
              <canvas id="chartIncidentGroup-area"></canvas>
          </div>

        </div>
    </div>


  </div>

</div>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">จำนวนความเสี่ยงของแต่ละกลุ่มงาน</h3>
      </div>
      <!-- /.box-header -->
        <div class="box-body">

          <div id="canvas-holder" style="width:100%; ">

                <canvas id="myChart" ></canvas>

          </div>

        </div>
    </div>

  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
  </div>
</div>



















  </section><!-- /section  -->


</div>



<!-- Morris.js charts -->
<script src="{{asset('/chart.js/dist/Chart.bundle.js')}}"></script>
<script src="{{asset('/chart.js/samples/utils.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/fastclick/lib/fastclick.js')}}"></script>
<script type="text/javascript">


var url = "{{url('fontend/line111')}}";
var Years = new Array();
var Labels = new Array();
var Prices = new Array();

$(document).ready(function(){
          $.get(url, function(response){
/*
            response.forEach(function(data){
                Years.push(data.stockYear);
                Labels.push(data.stockName);
                Prices.push(data.stockPrice);
            });
*/
            console.log(response);
            console.log('1');

          });
});


//window.onload = function(){

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',

    data: {
        labels: <?=json_encode($month)?>,
        datasets: [{
					label: 'จำนวนความเสี่ยงที่เกิดขึ้น',
					backgroundColor: '#ff0000',
					borderColor: '#ff0000',
					data:<?=json_encode($lineDivision1)?>,
					fill: false,
				}]
    },
    options: {
        scales: {
            xAxes: [{
                ticks: {
                    beginAtZero:true
                },
                display: true,
    						scaleLabel: {
    							display: true,
    							labelString: 'เดือน'
    						}
            }]
            ,
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'จำนวน/ครั้ง'
						}
					}]
        }
    }
});

//}

<?php
//dd($pieDivision);
$datapieCountAlllist =array();
$datapieCountAllsum=0;
$datapievalue = array();
$datapielabel = array();



foreach( $pieDivision as $k =>$v)
{
  $datapieCountAlllist[] = $v->count;
}
$datapieCountAllsum = array_sum($datapieCountAlllist);

foreach( $pieDivision as $k =>$v)
{
  $datapievalue[] = ($v->count/$datapieCountAllsum)*100;
}
foreach( $pieDivision as $k =>$v)
{
  $datapielabel[] = "'".$v->name."'";
}


// -----------------------------------------------------
$datapieIncidentGroupCountAlllist =array();
$datapieIncidentGroupCountAllsum=0;
$datapieIncidentGroupvalue = array();
$datapieIncidentGrouplabel = array();
foreach( $pieIncidentGroup as $k =>$v)
{
  $datapieIncidentGroupCountAlllist[] = $v->count;
}
$datapieIncidentGroupCountAllsum = array_sum($datapieIncidentGroupCountAlllist);

foreach( $pieIncidentGroup as $k =>$v)
{
  $datapieIncidentGroupvalue[] = ($v->count/$datapieIncidentGroupCountAllsum)*100;
}
foreach( $pieIncidentGroup as $k =>$v)
{
  $datapieIncidentGrouplabel[] = "'".$v->name."'";
}

?>
function getRandomColor() {
  /*
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
  */
  return '#'+((1<<24)*(Math.random()+1)|0).toString(16).substr(1);
}
		var config = {

			type: 'pie',
			data: {
				datasets: [{
					data:
						<?=json_encode($datapievalue)?>
					,
					backgroundColor: [
						'#ff5458',
						'#8f6efa',
						'#6ba4c8',
						'#0b521a',
						'#ff0000',
            '#0f14e8',
            '#f4b232',
            '#f488cf',
            '#a2b4bd',
            '#82f6a0',
            '#953146',
            '#095e63',
            '#a04c0e',
					],
					label: 'Dataset 1'
				}],
				labels: [<?=implode(",", $datapielabel)?>
				]
			},
			options: {
				responsive: true

			}

		};

    var config_incident = {
      type: 'pie',
      data: {
        datasets: [{
          data:
            <?=json_encode($datapieIncidentGroupvalue)?>
          ,
          backgroundColor: [
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),
            getRandomColor(),

          ],
          label: 'Dataset 1'
        }],
        labels: [<?=implode(",", $datapieIncidentGrouplabel)?>
        ]
      },
      options: {
        responsive: true
      }
    };
var ctxpie = document.getElementById("chartPie-area").getContext('2d');
var myPie = new Chart(ctxpie, config);


var ctxpie_incident = document.getElementById("chartIncidentGroup-area").getContext('2d');
var myPieIncident = new Chart(ctxpie_incident, config_incident);
</script>

@endsection
