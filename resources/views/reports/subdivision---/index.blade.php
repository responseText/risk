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

          <form action="{{route('reports.subdivisiondetail')}}" method="POST">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 ">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right "  name="filterdaterage" id="filterdaterage" value="">
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
              <select id="subdivision" name="subdivision[]" class="select2 form-control" multiple="multiple">
                  <option value="" >***โปรดเลือกหน่วยงาน***</option>
                </select>
            </div>
              <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 ">
                <button type="submit" name="button" class="btn btn-primary btn-block">ค้นหา</button>
              </div>

          </div><!-- /.row -->
          </form>

        </div><!-- /.box-body -->
      </div> <!-- .box box-primary   -->

    </div><!-- .col-xs-12 col-sm-12 col-md-12 col-lg-12   -->
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="box box-primary">
      <div class="box-body">
        รายงานความเสี่ยงที่เกิดขึ้นแยกหน่วยงาน
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <?php
  if(isset($data))
  {
  ?>
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
            if( count($data) <= 0 )
            {
            ?>
            <tr>
              <td colspan="6" class="text-center bg-red"> <?=trans('system.not_found')?> </td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
              <td colspan="6">
                <strong class="text-muted">
                  <?php

                    echo 'รายงานอุบัติการทั้งหมด';

                  ?>


                  <?php echo count($data);?>  รายการ </strong>

              </td>
            </tr>

            <?php
              foreach ( $data as $rs )
              {
            ?>
            <tr>
              <td class="text-center">
                <?php echo $rs->incident_date; ?><br>
                <?php echo $rs->incident_time; ?>
              </td>
              <td class="text-center">
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
            }
            ?>
          </table>
          </div>
        </div>
      </div>
    </div>

  <?php
  }
  else
  {

  }

  ?>

  </div>
</div>

<script>

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
