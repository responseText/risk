@extends('layouts.page')

@section('content')
<!-- Morris.js charts -->
<script src="{{asset('/Highcharts-7.0.1/code/highcharts.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/drilldown.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/series-label.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/series-label.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/exporting.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/export-data.js')}}"></script>

<div class="content">

<?php
//$datetitle_chartline =$request_year
?>
  <!-- Content Header (Page header) -->








  <!-- Main content -->
  <section class="content">








<style type="text/css">
#container1 {
	min-width: 310px;
	max-width: 800px;
	height: 800px;
	margin: 0 auto;
}
</style>

<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-bomb"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">ความเสี่ยงทั้งหมด</span>
        <span class="info-box-number"><?php echo $countAllRisk; ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa  fa-send-o"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">รอคณะกรรมความเสี่ยงส่งต่อ</span>
        <span class="info-box-number"><?php echo $countAllRiskHeadRMForsend; ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa  fa-hourglass-2"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">รอหัวหน้ากลุ่มงานประเมิน</span>
        <span class="info-box-number"><?php echo $countAllRiskHeadDivision; ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-commenting"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">รอคณะกรรมการRMประเมิน</span>
        <span class="info-box-number"><?php echo $countAllRiskHeadRMEvaluation; ?></span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div>






</div>



<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <div class="box box-info">
       <div class="box-body">
           <form class="" action="{{route('indexsearch')}}" method="POST">
             <input type="hidden" name="_method" value="post">
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right">
                 <label class="col-lg-2 col-md-2 col-sm-6 col-xs-12 control-label ">ปีงบประมาณ</label>
                 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                   <?php
                   if(!isset( $request_year))
                   {
                     $request_year = date("Y");
                   }
                   ?>
                   <select id="budget_year" name="budget_year" class="form-control  select2" >

                     <option value="">ปีงบประมาณ</option>
                       <?php
                         $year = date('Y');
                         $min = $year - 25;
                         $max = $year;
                         for( $i=$max; $i>=$min; $i-- ) {
                         ?>
                         <option value="{{$i}}" <?php if($request_year == $i){ echo 'selected="selected"';}?>> {{($i+543)}}</option>

                         <?php
                         }
                       ?>
                     </select>
                 </div>
                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
                   <button type="submit" name="button" class="btn btn-primary">OK</button>
                 </div>
               </div>
             </div>
         </form>
       </div>
     </div>
   </div>
</div>

<div class="row">
  <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
    <div class="box box-primary">
      <div class="box-body">
        <div id="container1" ></div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">

      <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">10 ลำดับผู้ใช้งานที่รายงานความเสี่ยงสูงสุด</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
              <?php
              $dir = asset('/uploads/images/profile');
              foreach( $countNoUsers as $k =>$v )
              {
              ?>
                <li class="item">
                  <div class="product-img">

                    <?php
                    if($v->writeByID->images_profile=='')
                    {
                      if($v->writeByID->employee->prefix->id == '1')
                      {
                      ?>
                       <img src="{{asset('/AdminLTE-2.4.5/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" widht="50" height="50" >

                      <?php
                      }
                      else
                      {
                      ?>
                       <img src="{{asset('/AdminLTE-2.4.5/dist/img/user4-128x128.jpg')}}" class="img-circle" alt="User Image" widht="50" height="50">

                      <?php
                      }
                    }
                    else
                    {
                    ?>
                    <img src="<?=$dir.'/'.$v->writeByID->images_profile?>" class="img-circle" alt="User Image">
                    <?php
                    }
                    ?>

                  </div>
                  <div class="product-info">


                    {{

                      $v->writeByID->employee->prefix->name.
                      $v->writeByID->employee->fname.'  '.$v->writeByID->employee->lname
                    }}
                      <span class="label label-success pull-right">
                      {{$v->Count_user}}
                      </span>

                    <span class="product-description">
                          ตำแหน่ง&nbsp;:&nbsp;{{$v->writeByID->employee->position->name}}
                    </span>
                  </div>
                </li><!-- /.item -->
                <?php
                }
                ?>
              </ul>
            </div>
            <!-- /.box-body -->

          </div>
          <!-- /.box -->

  </div>

</div>
<br>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-body">
          <?php

          $arrcolumnChart1 =array();
          $arrcolumnChart1Value =array();
          foreach( $columnChart as $k ){
            $arrcolumnChart1[] = $k->name;
          }
          foreach( $columnChart as $k ){
            $arrcolumnChart1Value[] = $k->Count;
          }


          ?>

        <div id="container2"></div>


      </div>
    </div>
  </div>
</div>













<div class="box box-info">
  <div class="box-body">





    <br>
    <script type="text/javascript">
     var data_click = <?=json_encode( $line ); ?>;
    </script>




<style type="text/css">
#container1 {
	min-width: 310px;
	max-width: 800px;
	height: 800px;
	margin: 0 auto;
}
</style>



























  </div>
</div>









<script type="text/javascript">
    Highcharts.chart('container1', {

        title: {
            text: 'จำนวนความเสี่ยงที่เกิดขึ้นแยกตามกลุ่มงาน'
        },

        subtitle: {
            text: 'ปีงบประมาณ <?=$request_year+543?>'
        },
    	xAxis: {
                    categories: <?=json_encode( $month)?>
                },

        yAxis: {
            title: {
                text: 'จำนวน (ครั้ง)'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },




        series: [
    	{
                    name:   "<?=$line[1]['name'];?>",
                    data: [<?=implode(',',$line[1]['data'])?>]
                  },
                  {
                    name:   "<?=$line[2]['name'];?>",
                    data: [<?=implode(',',$line[2]['data'])?>]
                  },
                  {
                    name:   "<?=$line[3]['name'];?>",
                    data: [<?=implode(',',$line[3]['data'])?>]
                  },
                  {
                    name:   "<?=$line[4]['name'];?>",
                    data: [<?=implode(',',$line[4]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[5]['name'];?>",
                    data: [<?=implode(',',$line[5]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[6]['name'];?>",
                    data: [<?=implode(',',$line[6]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[7]['name'];?>",
                    data: [<?=implode(',',$line[7]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[8]['name'];?>",
                    data: [<?=implode(',',$line[8]['data'])?>]
                  }
                  ,

                  {
                    name:   "<?=$line[10]['name'];?>",
                    data: [<?=implode(',',$line[10]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[11]['name'];?>",
                    data: [<?=implode(',',$line[11]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[12]['name'];?>",
                    data: [<?=implode(',',$line[12]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[13]['name'];?>",
                    data: [<?=implode(',',$line[13]['data'])?>]
                  }
    	],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 1024
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
    	/*
          Highcharts.chart('container3',

            {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'จำนวนความเสี่ยงที่เกิดขึ้นในปีงบประมาณ <?=$request_year+543?>'
                },
                subtitle: {
                  //  text: 'Source: WorldClimate.com'
                },
                xAxis: {
                    categories: <?=json_encode( $month)?>
                },
                yAxis: {
                    title: {
                        text: 'จำนวน (ครั้ง)'
                    }

                },

                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                series:
                [
                  {
                    name:   "<?=$line[1]['name'];?>",
                    data: [<?=implode(',',$line[1]['data'])?>]
                  },
                  {
                    name:   "<?=$line[2]['name'];?>",
                    data: [<?=implode(',',$line[2]['data'])?>]
                  },
                  {
                    name:   "<?=$line[3]['name'];?>",
                    data: [<?=implode(',',$line[3]['data'])?>]
                  },
                  {
                    name:   "<?=$line[4]['name'];?>",
                    data: [<?=implode(',',$line[4]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[5]['name'];?>",
                    data: [<?=implode(',',$line[5]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[6]['name'];?>",
                    data: [<?=implode(',',$line[6]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[7]['name'];?>",
                    data: [<?=implode(',',$line[7]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[8]['name'];?>",
                    data: [<?=implode(',',$line[8]['data'])?>]
                  }
                  ,
                
                  {
                    name:   "<?=$line[10]['name'];?>",
                    data: [<?=implode(',',$line[10]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[11]['name'];?>",
                    data: [<?=implode(',',$line[11]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[12]['name'];?>",
                    data: [<?=implode(',',$line[12]['data'])?>]
                  }
                  ,
                  {
                    name:   "<?=$line[13]['name'];?>",
                    data: [<?=implode(',',$line[13]['data'])?>]
                  }
                ]






          });
    	  */


</script>
<script type="text/javascript">
          Highcharts.chart('container2', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'จำนวนความเสี่ยงแยกตามหมวดหมู่อุบัติการณ์  ปีงบ <?=$request_year+543?>'
      },
      xAxis: {
          type: 'category'
      },
      yAxis: {
          title: {
              text: 'จำนวน (ครั้ง)'
          }

      },
      legend: {
          enabled: false
      },
      plotOptions: {
          series: {
              borderWidth: 0,
              dataLabels: {
                  enabled: true,
                  //format: '{point.y:.1f}%'
              }
          }
      },

      tooltip: {
          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} ครั้ง</b><br/>'
      },

      "series": [
          {
              "name": "หมวดหมู่อุบัติการณ์",
              "colorByPoint": true,
              "data": [
                  {
                      "name": "<?=$arrcolumnChart1[0]?>",
                      "y": <?=$arrcolumnChart1Value[0]?>,
                      "drilldown": "<?=$arrcolumnChart1[0]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[1]?>",
                      "y": <?=$arrcolumnChart1Value[1]?>,
                      "drilldown": "<?=$arrcolumnChart1[1]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[2]?>",
                      "y": <?=$arrcolumnChart1Value[2]?>,
                      "drilldown": "<?=$arrcolumnChart1[2]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[3]?>",
                      "y": <?=$arrcolumnChart1Value[3]?>,
                      "drilldown": "<?=$arrcolumnChart1[3]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[4]?>",
                      "y": <?=$arrcolumnChart1Value[4]?>,
                      "drilldown": "<?=$arrcolumnChart1[4]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[5]?>",
                      "y": <?=$arrcolumnChart1Value[5]?>,
                      "drilldown": "<?=$arrcolumnChart1[5]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[6]?>",
                      "y": <?=$arrcolumnChart1Value[6]?>,
                      "drilldown": "<?=$arrcolumnChart1[6]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[7]?>",
                      "y": <?=$arrcolumnChart1Value[7]?>,
                      "drilldown": "<?=$arrcolumnChart1[7]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[8]?>",
                      "y": <?=$arrcolumnChart1Value[8]?>,
                      "drilldown": "<?=$arrcolumnChart1[8]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[9]?>",
                      "y": <?=$arrcolumnChart1Value[9]?>,
                      "drilldown": "<?=$arrcolumnChart1[9]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[10]?>",
                      "y": <?=$arrcolumnChart1Value[10]?>,
                      "drilldown": "<?=$arrcolumnChart1[10]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[11]?>",
                      "y": <?=$arrcolumnChart1Value[11]?>,
                      "drilldown": "<?=$arrcolumnChart1[11]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[12]?>",
                      "y": <?=$arrcolumnChart1Value[12]?>,
                      "drilldown": "<?=$arrcolumnChart1[12]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[13]?>",
                      "y": <?=$arrcolumnChart1Value[13]?>,
                      "drilldown": "<?=$arrcolumnChart1[13]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[14]?>",
                      "y": <?=$arrcolumnChart1Value[14]?>,
                      "drilldown": "<?=$arrcolumnChart1[14]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[15]?>",
                      "y": <?=$arrcolumnChart1Value[15]?>,
                      "drilldown": "<?=$arrcolumnChart1[15]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[16]?>",
                      "y": <?=$arrcolumnChart1Value[16]?>,
                      "drilldown": "<?=$arrcolumnChart1[16]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[17]?>",
                      "y": <?=$arrcolumnChart1Value[17]?>,
                      "drilldown": "<?=$arrcolumnChart1[17]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[18]?>",
                      "y": <?=$arrcolumnChart1Value[18]?>,
                      "drilldown": "<?=$arrcolumnChart1[18]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[19]?>",
                      "y": <?=$arrcolumnChart1Value[19]?>,
                      "drilldown": "<?=$arrcolumnChart1[19]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[20]?>",
                      "y": <?=$arrcolumnChart1Value[20]?>,
                      "drilldown": "<?=$arrcolumnChart1[20]?>"
                  },
                  {
                      "name": "<?=$arrcolumnChart1[21]?>",
                      "y": <?=$arrcolumnChart1Value[21]?>,
                      "drilldown": "<?=$arrcolumnChart1[21]?>"
                  },
              ]
          }
      ],
      "drilldown": {
          "series": [
              {
                  "name": "Chrome",
                  "id": "Chrome",
                  "data": [
                      [
                          "v65.0",
                          0.1
                      ],
                      [
                          "v64.0",
                          1.3
                      ],
                      [
                          "v63.0",
                          53.02
                      ],
                      [
                          "v62.0",
                          1.4
                      ],
                      [
                          "v61.0",
                          0.88
                      ],
                      [
                          "v60.0",
                          0.56
                      ],
                      [
                          "v59.0",
                          0.45
                      ],
                      [
                          "v58.0",
                          0.49
                      ],
                      [
                          "v57.0",
                          0.32
                      ],
                      [
                          "v56.0",
                          0.29
                      ],
                      [
                          "v55.0",
                          0.79
                      ],
                      [
                          "v54.0",
                          0.18
                      ],
                      [
                          "v51.0",
                          0.13
                      ],
                      [
                          "v49.0",
                          2.16
                      ],
                      [
                          "v48.0",
                          0.13
                      ],
                      [
                          "v47.0",
                          0.11
                      ],
                      [
                          "v43.0",
                          0.17
                      ],
                      [
                          "v29.0",
                          0.26
                      ]
                  ]
              },
              {
                  "name": "Firefox",
                  "id": "Firefox",
                  "data": [
                      [
                          "v58.0",
                          1.02
                      ],
                      [
                          "v57.0",
                          7.36
                      ],
                      [
                          "v56.0",
                          0.35
                      ],
                      [
                          "v55.0",
                          0.11
                      ],
                      [
                          "v54.0",
                          0.1
                      ],
                      [
                          "v52.0",
                          0.95
                      ],
                      [
                          "v51.0",
                          0.15
                      ],
                      [
                          "v50.0",
                          0.1
                      ],
                      [
                          "v48.0",
                          0.31
                      ],
                      [
                          "v47.0",
                          0.12
                      ]
                  ]
              },
              {
                  "name": "<?=$arrcolumnChart1[2]?>",
                  "id": "<?=$arrcolumnChart1[2]?>",
                  "data": [
                      [
                          "v11.0",
                          6.2
                      ],
                      [
                          "v10.0",
                          0.29
                      ],
                      [
                          "v9.0",
                          0.27
                      ],
                      [
                          "v8.0",
                          0.47
                      ]
                  ]
              },
              {
                  "name": "Safari",
                  "id": "Safari",
                  "data": [
                      [
                          "v11.0",
                          3.39
                      ],
                      [
                          "v10.1",
                          0.96
                      ],
                      [
                          "v10.0",
                          0.36
                      ],
                      [
                          "v9.1",
                          0.54
                      ],
                      [
                          "v9.0",
                          0.13
                      ],
                      [
                          "v5.1",
                          0.2
                      ]
                  ]
              },
              {
                  "name": "Edge",
                  "id": "Edge",
                  "data": [
                      [
                          "v16",
                          2.6
                      ],
                      [
                          "v15",
                          0.92
                      ],
                      [
                          "v14",
                          0.4
                      ],
                      [
                          "v13",
                          0.1
                      ]
                  ]
              },
              {
                  "name": "Opera",
                  "id": "Opera",
                  "data": [
                      [
                          "v50.0",
                          0.96
                      ],
                      [
                          "v49.0",
                          0.82
                      ],
                      [
                          "v12.1",
                          0.14
                      ]
                  ]
              }
          ]
      }
  });
          </script>





<?php

$arrPie =array();
$arrPieValue =array();
foreach( $pieChart1 as $k ){
  $arrPie[] = $k->name;
}
foreach( $pieChart1 as $k ){
  $arrPieValue[] = $k->Count;
}


?>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<!--
      <div class="box box-info">
        <div class="box-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div id="pieChart"></div>
            </div>
          </div>
        </div>
      </div>
-->
  </div>

  <?php

  $arrcolumnChart =array();
  $arrcolumnChartValue =array();
  foreach( $columnChart as $k ){
    $arrcolumnChart[] = $k->name;
  }
  foreach( $columnChart as $k ){
    $arrcolumnChartValue[] = $k->Count;
  }


  ?>

  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<!--
      <div class="box box-info">
        <div class="box-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div id="columnChart"></div>
            </div>
          </div>
        </div>
      </div>
-->
  </div>


</div>



<script type="text/javascript">
//------------------------------------------------------------------------------


// Radialize the colors
Highcharts.setOptions({
    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    })
});

// Build the chart
/*
Highcharts.chart('pieChart', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'ร้อยละความเสี่ยงแยกตามโปรแกรมความเสี่ยง ปีงบ <?=$request_year+543?>'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: 'Share',
        data: [
            { name: '<?=$arrPie[0]?>', y: <?=($arrPieValue[0]*$allRisk)/100?> },
            { name: '<?=$arrPie[1]?>', y: <?=($arrPieValue[1]*$allRisk)/100?> },
            { name: '<?=$arrPie[2]?>', y: <?=($arrPieValue[2]*$allRisk)/100?> },
            { name: '<?=$arrPie[3]?>', y: <?=($arrPieValue[3]*$allRisk)/100?> },
            { name: '<?=$arrPie[4]?>', y: <?=($arrPieValue[4]*$allRisk)/100?> },
            { name: '<?=$arrPie[5]?>', y: <?=($arrPieValue[5]*$allRisk)/100?> }
        ]
    }]
});

*/
</script>

<script type="text/javascript">
/*
series: [{
    name:   "<?=$line[1]['name'];?>",
    data: [<?=implode(',',$line[1]['data'])?>]
}]
*/
/*
Highcharts.chart('columnChart',

{
  chart: {
      type: 'line'
  },
  title: {
      text: 'จำนวนความเสี่ยงแยกตามหมวดหมู่อุบัติการณ์  ปีงบ <?=$request_year+543?>'
  }
  ,
  xAxis: {
      categories: <?=json_encode( $month)?>
  },
  yAxis: {
      title: {
          text: 'จำนวน (ครั้ง)'
      }

  },
  plotOptions: {
      line: {
          dataLabels: {
              //enabled: true
          },
          //enableMouseTracking: false
      }
  },
  legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle'
  },
  series:
  [
    {
      name:   "<?=$arrcolumnChart[0]?>",
      data: [<?=$arrcolumnChartValue[0]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[1]?>",
      data: [<?=$arrcolumnChartValue[1]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[2]?>",
      data: [<?=$arrcolumnChartValue[2]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[3]?>",
      data: [<?=$arrcolumnChartValue[3]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[4]?>",
      data: [<?=$arrcolumnChartValue[4]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[5]?>",
      data: [<?=$arrcolumnChartValue[5]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[6]?>",
      data: [<?=$arrcolumnChartValue[6]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[7]?>",
      data: [<?=$arrcolumnChartValue[7]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[8]?>",
      data: [<?=$arrcolumnChartValue[8]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[9]?>",
      data: [<?=$arrcolumnChartValue[9]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[10]?>",
      data: [<?=$arrcolumnChartValue[10]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[11]?>",
      data: [<?=$arrcolumnChartValue[11]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[12]?>",
      data: [<?=$arrcolumnChartValue[12]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[13]?>",
      data: [<?=$arrcolumnChartValue[13]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[14]?>",
      data: [<?=$arrcolumnChartValue[14]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[15]?>",
      data: [<?=$arrcolumnChartValue[15]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[16]?>",
      data: [<?=$arrcolumnChartValue[16]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[17]?>",
      data: [<?=$arrcolumnChartValue[17]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[18]?>",
      data: [<?=$arrcolumnChartValue[18]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[19]?>",
      data: [<?=$arrcolumnChartValue[19]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[20]?>",
      data: [<?=$arrcolumnChartValue[20]?>]
    }
    ,
    {
      name:   "<?=$arrcolumnChart[21]?>",
      data: [<?=$arrcolumnChartValue[21]?>]
    }


  ]






});
*/


</script>












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
var ajax_date;


/*
function countTotalIncidentDivision( )
{
  var input_budgetyear = $('#budget_year').val() ;
  $.get('{{ url('fontend') }}/test/'+input_budgetyear,function(data) {
    console.log(data)
  });
}
*/

function countTotalIncidentDivision(  )
{

    var input_budgetyear = $('#budget_year').val() ;
    var title;
    var data_list =[];
  $.getJSON('{{ url('fontend') }}/test/'+input_budgetyear,function(data) {

    console.log( data);
      $.each( data.series ,function( index,value){
          //console.log( data.series[index] +' : '+value +'***');

          var i = 0;
          $.each( value ,function( a,b){
            //console.log(a +' : '+b );
            //data_list[i][]  = b;
            data_list[a]  = b;
            //textt[i]['a'] = value.name;
            i++;

          });
          //console.log(data_list);

      })




  });
}

$(document).ready(function(){



$('#budget_year').change(function()
{
    countTotalIncidentDivision();

});

  $('.select2').select2();




});




</script>

@endsection
