@extends('layouts.page')

@section('content')
@include('layouts/function')
<?php
$data_date = '';
$arr_subdivision = array();
//$division = '';
if(isset($_POST))
{

  //-------------------------------------------------
  if(!empty($_POST['subdivision']))
  {

      foreach ($_POST['subdivision'] as  $value) {
        $arr_subdivision[] = $value;
        //echo $value.'<br>';
      }
  }
  //--------------------------------------------------
  if(!empty($_POST['filterdaterage']))
  {
    $data_date =$_POST['filterdaterage'];
  }
  else
  {
    $data_date = '';
  }

  $urlse_date='';
  if($url_date!='' || !empty($url_date))
  {
  list($s_date,$e_date) =  explode("_" ,$url_date);

  $p_date1 = explode("-", $s_date);
  $ss_date1 = $p_date1[2].'-'.$p_date1[1].'-'.$p_date1[0];

  $p_date2 = explode("-", $e_date);
  $ee_date2 = $p_date2[2].'-'.$p_date2[1].'-'.$p_date2[0];
  $urlse_date=$ss_date1.'_'.$ee_date2;
  }
  echo $urlse_date;

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

          <form action="{{route('reports.subdivisiononreport')}}" method="POST">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right "  name="filterdaterage" id="filterdaterage" value="">
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 ">
                <button type="submit" name="button" class="btn btn-primary btn-block">ค้นหา</button>
              </div>

            </div>



          </form>

        </div><!-- /.box-body -->
      </div> <!-- .box box-primary   -->

    </div><!-- .col-xs-12 col-sm-12 col-md-12 col-lg-12   -->
</div>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="box box-primary">
      <div class="box-body">
        รายงานกลุ่มงานที่ได้รับการรายงานอุบัติการณ์สูงสุด
      </div>
    </div>
  </div>
</div>
  <?php
  if(isset($data))
  {
  ?>
<div class="row">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="margin pull-right">
      <div class="btn-group pull-right">
        <button type="button" class="btn btn-default"><i class="fa fa-gear"></i></button>
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
          <li><a href="javascript:print_preview();"><i class="fa fa-print"></i>พิมพ์</a></li>
            <li><a href="subdivisiononreport/exportExcel/<?=$urlse_date?>"><i class="fa fa-file-excel-o"></i>ส่งออก EXCEL</a></li>

        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-primary">
        <div class="box-body">

          <table class="table  table-hover">
            <thead>
            <tr class="table-primary  bg-red text-center">
              <th class="text-center">หน่วยงาน</th>
              <th class="text-center">กลุ่มงาน</th>
              <th class="text-center">จำนวน(ครั้ง)</th>

            </tr>
          </thead>
            <?php
            if( count($data) <= 0 )
            {
            ?>
            <tr>
              <td colspan="2" class="text-center bg-red"> <?=trans('system.not_found')?> </td>
            </tr>
            <?php
            }
            else
            {
            ?>

            <?php
              foreach ( $data as $rs )
              {
            ?>
            <tbody>
            <tr>
              <td >
                 <?php echo $rs->name; ?><br>

              </td>
              <td >
                 <?php echo $rs->Division_name; ?><br>

              </td>
              <td class="text-center" > <?php echo $rs->Count; ?></td>

            </tr>
            </tbody>
            <?php
              }
            }
            ?>
          </table>
        <div>
      </div>
    </div>
</div>
<?php
}
?>

<script>
function print_preview()
{

  print();

}
$(function () {
  var arr=<?=json_encode($arr_subdivision)?>;
  var division_id = $('#division').val();
  if(division_id != '' || division_id !== 'undefined')
  {
    $("#subdivision").empty().append('<option value="">***หน่วยงาน***</option>');//ล้างข้อมูล

    $.get('{{ url('reports/subdivisiondetail') }}/getsubdivision/'+division_id , function(data) {
      $('#subdivision')
          .empty()
          .append('<option value="">***หน่วยงาน***</option>');
          $.each( data , function (i, item) {

                  $('#subdivision').append( $("<option >", {
                      value: item.id,
                      text : item.name
                  }));
          });
          if( arr.length > 0 )
          {
            $.each(arr, function( index, value ) {
              $('#subdivision option[value="'+value+'"]').attr('selected','selected');
            });
          }
    });

  }

  $("#division").change(function(){

    $("#subdivision").empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');//ล้างข้อมูล

    var division_id ;
    division_id = $('#division').val();
    $.get('{{ url('reports/subdivisiondetail') }}/getsubdivision/'+division_id , function(data) {
      //alert(data);

      $('#subdivision')
          .empty()
          .append('<option value="">***โปรดเลือกหน่วยงาน***</option>');
          $.each( data , function (i, item) {

                  $('#subdivision').append( $('<option>', {
                      value: item.id,
                      text : item.name
                  }));

          });
    });
  });
  $('#filterdaterage').daterangepicker({
     locale:{
         cancelLabel: 'ลบ' ,
         applyLabel: 'ตกตง',
         locale: 'th',

     }
  }).val("<?=$data_date?>");
  $('.select2').select2();
});
</script>
@endsection
