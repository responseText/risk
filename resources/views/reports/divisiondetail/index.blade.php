@extends('layouts.page')

@section('content')
@include('layouts/function')

<?php

if(isset($request))
{
  //dd($request);
}
else{
 echo 'No';
}

$data_date = '';
$data_division='';
if(isset($request->filterdaterage))
{
 $data_date = $request->filterdaterage;
 list($param_date1,$param_date2) =  explode(" - " ,$request->filterdaterage);
 //echo $param_date1;
 $p_date1 = explode("/", $param_date1);
 $pp_date1 = $p_date1[2].'-'.$p_date1[1].'-'.$p_date1[0];

 $p_date2 = explode("/", $param_date2);
 $pp_date2 = $p_date2[2].'-'.$p_date2[1].'-'.$p_date2[0];
}
else
{
  $data_date='';
}


if(isset($request->division))
{
  $data_division=$request->division;
}
else
{
  $data_division='';
}





//echo $originaldate.'  '. $division_id ;
$urlParam=array();

echo $division_id.'<br>';
echo $originaldate.'<br>';
echo $data_date.'<br>';
echo 'URL : '.$url_date.'<br>';

$urlse_date='';
if($url_date!='' || !empty($url_date))
{
list($s_date,$e_date) =  explode("_" ,$url_date);

$p_date1 = explode("-", $s_date);
$ss_date1 = $p_date1[2].'-'.$p_date1[1].'-'.$p_date1[0];

$p_date2 = explode("-", $e_date);
$ee_date2 = $p_date2[2].'-'.$p_date2[1].'-'.$p_date2[0];
$urlse_date=$ss_date1.'_'.$ee_date2;
echo $urlse_date;
echo '<br> Base path : '.base_path();
}


?>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="alert alert-info alert-dismissible" role="alert">
       <h4><i class="icon fa fa-info"></i> ข้อความระบบ!</h4>
      รายงานนี้คิดจากกรณีความเสี่ยงที่ กรรมการความเสี่ยง ได้ทำการส่งความเสี่ยงให้หัวหน้ากลุ่มงานแล้ว  ไม่ว่าหัวหน้ากลุ่มงานจะ <strong class="text-danger">รับหรือไม่รับ</strong>ความเสี่ยง รายงานความเสี่ยงรายงานนี้ก็จะนำมาคิดด้วย
    </div>
  </div>

</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

      <div class="box box-primary">

        <div class="box-body">

          <form action="{{route('reports.divisiondetail')}}" method="POST">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right "  name="filterdaterage" id="filterdaterage" value="{{$originaldate}}">
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
              <select id="division" name="division" class="select2 form-control">
                  <option value="">*** กลุ่มงาน ***</option>
                  <?php
                  foreach( $division as $rs )
                  {
                  ?>
                  <option value="{{$rs->id}}" <?php if($division_id==$rs->id){ echo 'selected="selected"';}?>>{{$rs->name}}</option>

                  <??>
                  <?php
                  }
                  ?>
                </select>
            </div>
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
                <button type="submit" name="button" class="btn btn-primary">ค้นหา</button>
              </div>

          </div><!-- /.row -->
          </form>

        </div><!-- /.box-body -->
      </div> <!-- .box box-primary   -->

    </div><!-- .col-xs-12 col-sm-12 col-md-12 col-lg-12   -->
</div>


<?php

if(isset($data))
{

/*
  $urldivision=1;
  if($division_id='' || empty($division_id))
  {
    $urldivision=0;
  }
  else
  {
    $urldivision =$division_id;
  }
*/
?>
<form id="myFormExport" class="" action="" method="POST" target="_blank">
<input type="hidden" name="_method" value="POST">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" id="originaldate" name="originaldate" value="{{$originaldate}}">
<input type="hidden" id="division_id" name="division_id" value="{{$division_id}}">
<input type="hidden" id="type_file" name="type_file" value="">
</form>

<div class="row">
  <div class="col-xl-12">

    <div class="margin pull-right">
                    <div class="btn-group pull-right">
                      <button type="button" class="btn btn-default"><i class="fa fa-gear"></i></button>
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="javascript:print_preview();"><i class="fa fa-print"></i>พิมพ์</a></li>
                        <li><a href="{{action('ReportsController@exportPDF2')}}" target="_blank"><i class="fa fa-file-pdf-o"></i>ส่งออก PDF</a></li>
                        <li><a href="divisiondetail/exportExcel/<?=$division_id?>/<?=$urlse_date?>" target="_blank"><i class="fa fa-file-excel-o"></i>{{$division_id}}ส่งออก EXCEL</a></li>

                        <li><a href="#"><i class="fa fa-file-word-o"></i>ส่งออก Word</a></li>

                      </ul>
                    </div>
  </div>

</div>
<div class="row" id="printarea">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="box box-primary">
      <div class="box-body table-responsive no-padding">
        <table class="table table-bordered table-hover table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
                <tr class="table-primary text-center">
                  <th class="text-center">วันที่เกิด</th>
                  <th class="text-center">ระดับ</th>
                  <th class="text-center">ชื่อเหตุการณ์</th>
                  <th class="text-center">รายละอียด</th>
                  <th class="text-center">การจัดการเบื้องต้น</th>
                  <th class="text-center">RM Comment</th>
                </tr>
                <?php
                if(count($data) > 0 )
                {
                ?>
                <tr>
                  <td colspan="6">
                    <strong class="text-muted">
                      <?php
                      if($division_id =='')
                      {
                        echo 'รายงานอุบัติการของทุกหน่วยงาน ทั้งหมด';
                      }
                      else
                      {
                        echo 'รายงานอุบัติการแยกตามหน่วยงาน ทั้งหมด';
                      }
                      ?>


                      <?php echo count($data);?>  รายการ </strong>

                  </td>

                </tr>
                <?php
                  foreach( $data as $rs)
                  {
                ?>
                <tr>
                  <td><?=short_th_date($rs->incident_date)?>&nbsp;<?=showTime($rs->incident_time)?>&nbsp; น.</td>
                  <td class="text-center" >
                    <?php
                    $class='';

                    if(!empty($rs->violence_id))
                    {
                      switch($rs->violence->violencelevel_id)
                      {
                        case '1' : $class="label label-danger";break;
                        case '2' : $class="label label-warning";break;
                        case '3' : $class="label label-primary";break;
                        default  : $class="label label-success";break;
                      }
                    ?>
                    <span class="{{$class}}"><?php echo $rs->violence->code?></span>
                    <?php
                    }
                    else {
                      echo '-';
                    }


                    ?>
                    </td>
                  <td>
                    <?php
                    if($rs->incident_title !='' )
                    {
                      echo wordwrap($rs->incident_title, 100, "<br/>\n");
                    }
                    else
                    {
                        echo '';
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    if($rs->incident_event !='' )
                    {
                      echo wordwrap($rs->incident_event, 100, "<br/>\n");
                    }
                    else
                    {
                      echo '';
                    }
                    ?>
                  </td>
                  <td>

                    <?php
                    if($rs->headrm_review_edit !='' )
                    {

                    echo '<strong class="text-primary">การแก้ไข : </strong>';
                    echo wordwrap(htmlspecialchars ($rs->headrm_review_edit), 100, "<br/>\n").'<hr>';
                    }
                    else
                    {
                      echo '';
                    }
                    ?>

                  </td>
                  <td>
                    
                    <?php
                    if($rs->headrm_review_propersal !='' )
                    {

                    echo '<strong class="text-primary">ข้อเสนอแนะ : </strong>';
                    echo wordwrap(htmlspecialchars ($rs->headrm_review_propersal), 100, "<br/>\n").'<hr>';
                    }
                    else
                    {
                      echo '';
                    }
                    ?>
                  </td>
                </tr>
                <?php
                  }
                  ?>
                  <tr>
                    <td colspan="6">
                      รายงานอุบัติการแยกตามหน่วยงาน ทั้งหมด <?php echo count($data);?>  รายการ
                    </td>

                  </tr>
                <?php
                }
                else
                {
                ?>

                <tr>
                  <td colspan="6" class="alert-danger text-center">
                    ไม่พบข้อมูลในระบบ.
                  </td>
                </tr>
                <?php
                }
                ?>
              </table>
      </div>
    </div>


  </div>
</div>
<?php
}
?>










<script type="text/javascript" src="{{asset('js/system/reports/divisiondetail/js-handle.js')}}"></script>
<script type="text/javascript">
function print_preview()
{

  print();

}


$(function () {
  $('.select2').select2();
  $('#filterdaterage').daterangepicker({
     locale:{
         cancelLabel: 'ลบ' ,
         applyLabel: 'ตกตง',
         locale: 'th',
         //format: 'YYYY-MM-DD'
     }
     //,format: 'YYYY-MM-dd'

  });
});
</script>

@endsection
