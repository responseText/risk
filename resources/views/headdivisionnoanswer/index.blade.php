@extends('layouts.page')
@section('title','ติดตาม/ทบทวน ' )
@section('content')
@include('layouts/function')
<div class="box">
  <div class="box-header">
    <h3 class="box-title">ความเสี่ยงที่หัวหน้างานยังไม่ได้ทำการทบทวน </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">
<form id="myFormSearch" class="" action="{{route('headdivisionnoanswer.search')}}" method="post">
<input type="hidden" name="_method" value="POST">
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">ค้นหา</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">


<?php
$arr_division = array();
$old_evaluation;
$old_daterage;
//dd($request->input['filter-division']);
if(isset($_POST))
{
  if(!empty($_POST['filter-division']))
  {

      foreach ($_POST['filter-division'] as  $value) {
        $arr_division[] = $value;
      }
  }
}

if( isset( $_POST['evaluation']))
{
  $old_evaluation=$_POST['evaluation'];
}
else
{
  $old_evaluation ='';
}
if( !empty( $_POST['filter-daterage']))
{
  $old_daterage=$_POST['filter-daterage'];
}
else
{
  $old_daterage ='';
}

?>
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

              <div class="form-group">
                <label>กลุ่มงาน</label>

                <select id="filter-division"  name="filter-division[]" class="form-control select2" multiple="multiple" data-placeholder="เลือก กลุ่มงาน"
                        style="width: 100%;">
                  <?php
                  foreach ($division as $k)
                  {
                    //foreach(  $arr_division as $v)
                    //{
                  ?>

                  <option value="{{$k->id}}" <?php if(in_array($k->id,$arr_division)) echo 'selected="selected"'; ?>>{{$k->name}}</option>
                  <?php
                    //}
                  }
                  ?>

                </select>
              </div>  <!-- /.form-group -->

            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

              <div class="form-group">
                <label>ช่วงวันที่เกิดเหตุ</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name='filter-daterage' class="form-control pull-right" id="filter-daterage"
                  data-placeholder="ช่วงวันที่เกิดเหตุ" value="{{$old_daterage}}">
                </div><!-- /.input group -->

              </div><!-- /.form-group -->


            </div> <!--  /.col-lg-4 col-md-4 col-sm-6 col-xs-12  -->
            <!-- <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

              <div class="form-group">
                <label>สถานะการประเมิน</label>
                <select id="evaluation"  name="evaluation" class="form-control "  data-placeholder="สถานะการประเมิน"
                        style="width: 100%;">

                  <option value="">*** เลือกสถานะ ***</option>
                  <option value="99"  <?php if($old_evaluation=='99'){ echo 'selected="selected"'; }?>>รอการประเมิน</option>
                  <?php
                  foreach ($evaluation as $k)
                  {
                  ?>

                  <option value="{{$k->id}}" <?php if($old_evaluation==$k->id){ echo 'selected="selected"'; }?>>{{$k->name}}</option>
                  <?php
                  }
                  ?>

                </select>
              </div>
            -->

              <!-- /.form-group -->

            </div><!--  /.col-lg-4 col-md-4 col-sm-6 col-xs-12  -->

          </div><!-- /.row  -->

        </div><!-- /.box-body -->
        <div class="box-footer">
          <a href="{{route('headdivisionnoanswer.index')}}" class="btn btn-default">ล้าง</a>
          <!--<button type="button" name="button" class="btn btn-default" onclick="ajaxClearForm();">ล้าง</button> -->
          <button type="submit" name="button" class="btn btn-success pull-right">ค้นหา</button>
        </div>
   </div>

  </div>
</div>
</form>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <?php


        ?>
        <form id="myForm" name="myForm"  action=""  method="POST" >
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="js_vars" name="js_vars" value="">

        <table id="example2" class="table table-bordered table-hover table-responsive display nowrap"  style="width:100%" >
                <thead>
                <tr>
                  <th class="text-center" width="10%">เกิดขึ้นเมื่อ</th>
                  <th class="text-center" width="20%">ชื่อเหตุการณ์</th>
                  <th class="text-center" width="30%">เหตุการณ์</th>
                  <th class="text-center" width="10%">รายการ</th>
                  <th class="text-center"  width="15%">ผู้พบเห็น</th>
                  <th class="text-center"  width="10%">สถานะการประเมิน</th>
                  <th class="text-center"  width="5%"><i class="fa fa-filter"></i></th>

                </tr>
                </thead>
                <tbody>

                <?php
                 if(count($data) > 0 )

                {
                  $i=1;
                  foreach ( $data as $rs)
                  {
                    $class='';
                    if( $rs->headrm_review_status == 'Y')
                    {
                      if( $rs->incident_status_id =='1')
                      {
                        $class='bg-danger';
                      }
                      else if($rs->incident_status_id =='2')
                      {
                          $class='bg-info';
                      }
                      else if($rs->incident_status_id =='3')
                      {
                        $class='bg-success';
                      }

                    }
                ?>


                <tr class="<?=$class?>">

                  <td>

                    <?php echo $rs->incident_date.'&nbsp;&nbsp;'.$rs->incident_time.' น.';?>
                  </td>
                  <td>
                    <a href="<?=route('headdivisionnoanswer.create',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_title, 50, '</br>');?>
                    </a>

                  </td>
                  <td>
                    <a href="<?=route('headdivisionnoanswer.create',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_event, 100, '</br>');?>
                    </a>

                  </td>
                  <td class="text-center">
                    <?php //echo $rs->incident_group->name;
                    //echo count($rs->incident_group);
                    if( $rs->incident_group_id =='' )
                    {
                    ?>
                    <p class="alert-danger"> รายการนี้ถูกลบออกจากออกระบบ.</p>
                    <?php
                    }
                    else
                    {
                    ?>
                    <a href="<?=route('headdivisionnoanswer.create',[$rs->id])?>" >
                      <?php echo $rs->incident_group->name;?>
                    </a>
                    <?php

                    }
                    ?>

                  </td>
                  <td><?php
				  if(empty($rs->employee->fname))
                  {
                    echo '<span class="bg-red">ผู้เห็นเหตุการณ์นี้ถูกลบออกจากระบบ</span>';
                  }
                  else
                  {
                    echo $rs->employee->prefix->name.$rs->employee->fname.'   '.$rs->employee->lname;
                  }
				  //echo $rs->employee->prefix->name.$rs->employee->fname.'   '.$rs->employee->lname;
				  ?></td>
                  <td class="text-center">
                  <?php
                  if(empty($rs->incident_status_id))
                  {
                    echo '<p class="text-muted"><i class="fa fa-hourglass-half"></i>&nbsp;รอการประเมิน</p>';
                  }
                  else
                  {
                    if($rs->incident_status_id=='1')
                    {
                    echo '<p class="text-danger"><i class="fa fa-close"></i>&nbsp';
                    }
                    else if($rs->incident_status_id=='2')
                    {
                    echo '<p class="text-info"><i class="fa fa-refresh"></i>&nbsp';
                    }
                    else if($rs->incident_status_id=='3')
                    {
                    echo '<p class="text-success"><i class="fa fa-check"></i>&nbsp';
                    }

                    echo $rs->evaluation->name.'</p>';
                  }

                  ?>
                  </td>
                  <td class="text-center">
                      <a href="{{route('headdivisionnoanswer.show',$rs->id)}}"><i class="fa fa-filter"></i></a>
                  </td>


                </tr>
                <?php
                    $i++;

                  }
                }
                else
                {
                ?>
                <tr>
                  <td class="text-center  bg-red" colspan="7">
                    ไม่พบข้อมูล.
                  </td>
                </tr>




                <?php
                }
                ?>
                </tbody>

              </table>
            </form>
      </div>

    </div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
<script type="text/javascript" src="{{asset('js/system/headdivisionnoanswer/js-handle.js')}}"></script>
<script>

function ajaxClearForm()
{
  $('#myFormSearch #filter-division').val('');
  $('#myFormSearch #filter-daterage').val('');
  $('#myFormSearch #evaluation').val('');
  $('#myFormSearch').submit();
}

$(function () {
  //Initialize Select2 Elements
  $('.select2').select2();
  //Date range picker

  $('#filter-daterage').daterangepicker({
     locale:{
         cancelLabel: 'ลบ' ,
         applyLabel: 'ตกตง',
         locale: 'th',
         format: 'YYYY/MM/DD'
     }
     //,format: 'YYYY-MM-dd'

  }).val('<?=$old_daterage?>');
  loaddatable();


});
</script>
@endsection
