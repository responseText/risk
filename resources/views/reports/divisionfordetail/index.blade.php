@extends('layouts.page')

@section('content')
@include('layouts/function')

<?php


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

//echo $division_id.'<br>';
//echo $originaldate.'<br>';
//echo $data_date.'<br>';
//echo 'URL : '.$url_date.'<br>';

$urlse_date='';
if($url_date!='' || !empty($url_date))
{
list($s_date,$e_date) =  explode("_" ,$url_date);

$p_date1 = explode("-", $s_date);
$ss_date1 = $p_date1[2].'-'.$p_date1[1].'-'.$p_date1[0];

$p_date2 = explode("-", $e_date);
$ee_date2 = $p_date2[2].'-'.$p_date2[1].'-'.$p_date2[0];
$urlse_date=$ss_date1.'_'.$ee_date2;
//echo $urlse_date;
//echo '<br> Base path : '.base_path();
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

          <form action="{{route('reports.divisionfordetail.index')}}" method="POST">
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
<!--
<div class="row">
  <div class="col-lg-12">
    <div class="margin pull-right">
      <?php
      $id_foreexport=0;
      if($division_id =='')
      {
        $id_foreexport=0;
      }
      else
      {
        $id_foreexport = $division_id;
      }

      ?>

                    <div class="btn-group pull-right">
                      <button type="button" class="btn btn-default"><i class="fa fa-gear"></i></button>
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="javascript:print_preview();"><i class="fa fa-print"></i>พิมพ์</a></li>
                        <li><a href="divisionfordetail/exportExcel/<?=$id_foreexport?>/<?=$urlse_date?>" target="_blank"><i class="fa fa-file-excel-o"></i>ส่งออก EXCEL</a></li>



                      </ul>
                    </div>
    </div>
  </div>
</div>
-->

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="box box-primary">
      <div class="box-body">
        <table id="datatable" class="table table-bordered table-hover table-responsive display nowrap"  style="width:100%" >
          <thead class="bg-primary">
            <tr class="table-primary text-center">
              <th class="text-center">วันที่เกิด</th>
              <th class="text-center">ระดับ</th>
              <th class="text-center">ชื่อเหตุการณ์</th>
              <th class="text-center">รายละอียด</th>
              <th class="text-center">การจัดการเบื้องต้น</th>
              <th class="text-center">RM Comment</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if(count($data) > 0 )
            {
            ?>

            <?php
              foreach( $data as $rs)
              {
            ?>
            <tr>
              <td><?=$rs->incident_date?>&nbsp;<?=showTime($rs->incident_time)?>&nbsp; น.</td>
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
                ?>
                <a href="{{route('reports.divisionfordetail.show',array( $rs->id))}}" target="_blank">
                <?php
                  echo wordwrap($rs->incident_title, 100, "<br/>\n");
                ?>
              </a>
                <?php
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

            <?php
            }
            else
            {
            ?>


            <?php
            }
            ?>

          </tbody>
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


    var rows_selected = [];
    var table =$('#datatable').DataTable({
      "dom": '<"top"flB>rt<"clear"><"bottom"ip><"clear">',

          buttons: [
                          { extend: 'copy', className: 'btn btn-primary' },
                          {

                            extend: 'excel',
                            className: 'btn btn-primary'
                          },
                          {
                              extend: 'pdfHtml5',
                              orientation: 'landscape',
                              pageSize: 'A4' ,
                              className: 'btn btn-primary'
                          },
                          { extend: 'print', className: 'btn btn-primary' }

                      ],

          "scrollX": true,
          "scrollY": true,


  rowCallback: function(row, data, dataIndex){
         // Get row ID
         var rowId = data[0];

         // If row ID is in the list of selected row IDs
         if($.inArray(rowId, rows_selected) !== -1){
            $(row).find('input[type="checkbox"]').prop('checked', true);
            $(row).addClass('selected');
         }
      },
      "order": [[ 0, "desc" ]],


      'responsive': true ,
      'paging': true,
      'searching': true,
      /*
      "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        }
        */
        "language": {
                /*"url": 'lang/th.json'*/
                "url": '../js/lang/th.json'
            }


     });






});
</script>

@endsection
