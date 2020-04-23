@extends('layouts.page')

@section('content')

<!-- Morris.js charts -->
<script src="{{asset('/Highcharts-7.0.1/code/highcharts.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/highcharts-3d.js')}}"></script>

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
.products-list .product-info {
    margin-left: 1em;
}
.popover{
   min-width:80%;
   min-height: :80%;
}


</style>
<?php
/*
//------------------------------------------------------------------------------
function checkUserLevel6( $param ) // ผู้ใช้งานทั่วไป
{
  //if( count(Auth::user()->user_level)>0 )
  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {
      switch( $v->level_id )
      {
        case("6"): return "yes"; break;
      }
    }
  }
  else
  {
    return "yes";
  }
}



//------------------------------------------------------------------------------
function checkUserLevel1( $param ) // ผู้ใช
{
  //if( count(Auth::user()->user_level)>0 )
  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {
      switch( $v->level_id )
      {
        case("1"): return "yes"; break;
        case("2"): return "yes"; break;
      }
    }
  }

}
//------------------------------------------------------------------------------
function checkUserLevel3( $param ) // คณะกรรมการความเสี่ยง
{
  //if( count(Auth::user()->user_level)>0 )
  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {
      switch( $v->level_id )
      {
        case("3"): return "yes"; break;
      }
    }
  }

}
//------------------------------------------------------------------------------
function checkUserLevel4( $param ) // หัวหน้ากลุ่มงาน
{
  //if( count(Auth::user()->user_level)>0 )
  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {
      switch( $v->level_id )
      {
        case("4"): return "yes"; break;
      }
    }
  }

}
//------------------------------------------------------------------------------
function checkUserLevel4_GetDivision( $param ) // หัวหน้ากลุ่มงาน
{
  //if( count(Auth::user()->user_level)>0 )

  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {

      if( $v->level_id =="4")
      {
        //return $v->division_id;
       session('menuid' , [$v->division_id]);
      //Session::
      }

    }
  }

}

//------------------------------------------------------------------------------
function checkUserLevel5( $param ) // หัวหน้าหน่วยงาน
{
  //if( count(Auth::user()->user_level)>0 )
  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {
      switch( $v->level_id )
      {
        case("5"): return "yes"; break;
      }
    }
  }

}
//------------------------------------------------------------------------------
function checkUserLevel5_GetDivision( $param ) // หัวหน้าหน่วยงาน
{
  //if( count(Auth::user()->user_level)>0 )
  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {
      switch( $v->level_id )
      {
        case("5"): return  $v->division_id; break;
      }
    }
  }

}
//------------------------------------------------------------------------------
function checkUserLevel5_GetSubDivision( $param ) // หัวหน้าหน่วยงาน
{
  //if( count(Auth::user()->user_level)>0 )
  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {
      switch( $v->level_id )
      {
        case("5"): return  $v->division_id; break;
      }
    }
  }

}




// -----------------------------------------------------------------------------
function checkUserLevel6_GetDivision( $param ) // หัวหน้ากลุ่มงาน
{
  //if( count(Auth::user()->user_level)>0 )
$a =array();


  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {

      if( $v->level_id =="4")
      {

      $a[$k]=$v->division_id;
      }
    }

    return $a;

  }

}



// -----------------------------------------------------------------------------
function checkUserLevel7_GetDivision( $param ) // หัวหน้ากลุ่มงาน
{
  //if( count(Auth::user()->user_level)>0 )
$a =array();


  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {

      if( $v->level_id =="4")
      {

      $a[$k]=$v->division_id;
      }
    }

    Session::put('user.session_division', $a);
    //return $a;

  }

}

*/


?>
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
           <form class="" action="{{route('indexsearch')}}" method="POST" style="margin-top:1em;margin-bottom:1em;">
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
  <div class="col-12">
<?php
$semiArray2=array();
$total2=0;

for($i=0;$i<count($violencelevelCircle);$i++)
{
  $total2=$total2+$violencelevelCircle[$i]->value;
}
//echo $total2;
$txtslice ='';

foreach( $violencelevelCircle as $k2 => $v2 )
{




  //$semiArray2[]='['."'".$v2->name."',".round(($v2->value*100)/$total2).']';
  //$semiArray2[]='{name:'."'".$v2->name."',".'y:'.round(($v2->value*100)/$total2).'}';
  //$semiArray2[]='{name:'."'".$v2->name."',".'y:'.$v2->value.'}';
  if($k2==0)
  {

    $semiArray2[]='{name:'."'".$v2->name."',".'y:'.$v2->value.', sliced: true, selected: true}';
  }
  else
  {
    $semiArray2[]='{name:'."'".$v2->name."',".'y:'.$v2->value.'}';
  }

}
//echo var_dump($semiArray2);
//echo implode(',',$semiArray2);
?>



    <?php
      $totalsemiPie=0;
      for($i=0;$i<count($semiCircle);$i++)
      {
        $totalsemiPie=$totalsemiPie+$semiCircle[$i]->y;
      }
      $semiArray=array();
      foreach($semiCircle as $k1  => $v1)
      {
        //$semiArray[]='{name:'."'".$v1->name."',".'y:'.round(($v1->y*100)/$totalsemiPie).'}';
        //$semiArray[]='{name:'."'".$v1->name."',".'y:'.$v1->y.'}';
        if($k1==0)
        {
          $semiArray[]='{name:'."'".$v1->name."',".'y:'.$v1->y.',sliced: true, selected: true }';
        }
        else
        {
          $semiArray[]='{name:'."'".$v1->name."',".'y:'.$v1->y.'}';
        }
      }
    ?>


    <?php
      $totaltypePatient=0;
      for($i=0;$i<count($typePatient);$i++)
      {
        $totaltypePatient=$totaltypePatient+$typePatient[$i]->y;
      }
      $typePatientArray=array();
      foreach($typePatient as $ktp  => $vtp)
      {
        if($ktp==0)
        {
          //$typePatientArray[]='{name:'."'".$vtp->name."',".'y:'.round(($vtp->y*100)/$totaltypePatient).',sliced:true ,selected: true}';
          $typePatientArray[]='{name:'."'".$vtp->name."',".'y:'.$vtp->y.',sliced:true ,selected: true}';
        }
        else
        {
          //$typePatientArray[]="['".$vtp->name."',".round(($vtp->y*100)/$totaltypePatient)."]";
          $typePatientArray[]="['".$vtp->name."',".$vtp->y."]";
        }
      }
    ?>
    <?php
      $totalRiskProgram=0;
      for($i=0;$i<count($riskProgram);$i++)
      {
        $totalRiskProgram=$totalRiskProgram+$riskProgram[$i]->y;
      }
      $RiskProgramArray=array();
      foreach($riskProgram as $krp  => $vrp)
      {
        //$RiskProgramArray[]="['".$vrp->name."',".round(($vrp->y*100)/$totalRiskProgram)."]";
        if($krp===0)
        {
            $RiskProgramArray[]="{name:'".$vrp->name."',y:".$vrp->y.",sliced: true,selected: true}";
        }
        else
        {
          $RiskProgramArray[]="{name:'".$vrp->name."',y:".$vrp->y."}";
        }

      }
    ?>

  </div>

</div>


<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="box box-info">
      <div class="box-body">
        <div id="containerSemiCircle" ></div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="box box-info">
      <div class="box-body">
        <div id="containerPie2" ></div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="box box-info">
      <div class="box-body">
        <div id="containerTypePatient" ></div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="box box-info">
      <div class="box-body">
        <div id="containerRiskProgram" ></div>
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

  <?php
  /// กำหนด path รูป เวลา route เปลี่ยน จาก index -->> indexsearch
  $get_routeName = Route::currentRouteName();
  $noImg='./AdminLTE-2.4.5/dist/img/user-nopic.png';
  if($get_routeName=='indexsearch')
  {
    $noImg = '../AdminLTE-2.4.5/dist/img/user-nopic.png';
  }
  else
  {
    $noImg='./AdminLTE-2.4.5/dist/img/user-nopic.png';
  }


  ?>
  <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">

      <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h6 class="box-title">10 ลำดับ เจ้าหน้าที่่รายงานความเสี่ยงสูงสุด</h6>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <?php

//dd($countNoUsers);
              ?>
              <ul class="products-list product-list-in-box">
              <?php
              $dir = asset('/uploads/images/profile');
              foreach( $countNoUsers as $k =>$v )
              {


              ?>
              <li class="item">
                <?php
                $imageuser='';
                //$$imageuser.$k='';
                if(is_null($v->employee->is_user))
                {
                  $imageuser=$noImg;
                }
                else
                {
                  if(is_null($v->employee->is_user->images_profile))
                  {
                    $imageuser=$noImg;
                  }
                  else{
                    $imageuser = $dir.'/'.$v->employee->is_user->images_profile;
                  }

                  //echo $v->employee->is_user;
                }

                ?>
                <div class="product-img" style="padding:0px 10px 0px 5px;">

                        <img src="<?=$imageuser?>" alt="User Image" class="img-circle" >

                </div>
                <div class="product-info">
                <?php
                echo  $v->employee->prefix->name.$v->employee->fname.'  '.$v->employee->lname;

                  ?>
                  <span class="label label-success pull-right">
                  {{$v->Count_user}}
                  </span>
                  <span class="product-description">
                        ตำแหน่ง&nbsp;:&nbsp;<?=$v->employee->position->name;?>
                  </span>
                </div>

              </li>

                <!-- /.item -->
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



<script type="text/javascript">

Highcharts.chart('containerRiskProgram', {
  chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    //colors: ['#FF0000', '#50B432'],
    title: {
        text: 'อัตราส่วนความเสี่ยงตามโปรแกรมความเสี่ยง <?=$request_year+543?>'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'อัตราส่วนตามโปรแกรมความเสี่ยง',
        colorByPoint: true,
        data: [<?=implode(',',$RiskProgramArray)?>]
    }]
  });
//------------------------------------------------------------------------------
Highcharts.chart('containerTypePatient', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'อัตราส่วนผู้ได้รับผลกระทบ <?=$request_year+543?>'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'อัตราส่วนร้อยละ ',
        data: [<?=implode(',',$typePatientArray)?>]
    }]
});


//------------------------------------------------------------------------------
Highcharts.chart('containerSemiCircle', {
  chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    //colors: ['#FF0000', '#50B432'],
    title: {
        text: 'อัตราส่วนประเภทความเสียง <?=$request_year+543?>'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'อัตราส่วนประเภทความเสียง',
        colorByPoint: true,
        data: [<?=implode(',',$semiArray)?>]
    }]
});
//-----------------------------------------------------------------------------


Highcharts.chart('containerPie2', {
  chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    /*colors: ['#FF0000', '#50B432'],*/
    title: {
        text: 'อัตราส่วนระดับความรุนแรง <?=$request_year+543?>'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'อัตราส่วนระดับความรุนแรง',
        colorByPoint: true,
        data: [<?=implode(',',$semiArray2)?>]
    }]
});


//-----------------------------------------------------------------------------
<?php

$txt_contain1 ='';
for( $i=1;$i<=$alldivision ; $i++)
{


    if($i !=9) // กลุ่มงาน id=9 นั้นถูก disable ไว้ ทำให้ไม่มีค่า ทำให้เกิด error offset
    {
      if($i==$alldivision){
        $txt_contain1 .='{name:"'.$line[$i]['name'].'",data: ['.implode(",",$line[$i]["data"]).']}';
      }
      else
      {
        $txt_contain1 .='{name:"'.$line[$i]['name'].'",data: ['.implode(",",$line[$i]["data"]).']},';
      }
    }
}
?>

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
          <?=$txt_contain1?>
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


</script>


<?php
          $txt_container2='';
          for($i=0;$i< count($arrcolumnChart1);$i++)
          {
            //echo $i.'<br>';
            if($i< count($arrcolumnChart1) )
            {
              $txt_container2.='{"name": "'.$arrcolumnChart1[$i].'","y": '.$arrcolumnChart1Value[$i].', "drilldown": "'.$arrcolumnChart1[$i].'"},';
            }
            else
            {
              $txt_container2.='{"name": "'.$arrcolumnChart1[$i].'","y": '.$arrcolumnChart1Value[$i].', "drilldown": "'.$arrcolumnChart1[$i].'"}';
            }
          }
          //echo $xtxt;

          ?>
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
                <?=$txt_container2?>
              ]
          }
      ]
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





<script type="text/javascript">
//------------------------------------------------------------------------------

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
