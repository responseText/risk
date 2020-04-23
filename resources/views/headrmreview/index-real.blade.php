@extends('layouts.page')
@section('title','ติดตาม/ทบทวน ' )
@section('content')
@include('layouts/function')
<div class="box">
  <div class="box-header">
    <h3 class="box-title">ติดตาม/ทบทวน ความเสี่ยง </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">
<form id="myFormSearch" class="" action="{{route('headrmreview.index')}}" method="post">
<input type="hidden" name="_method" value="get">
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">ค้นหา</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

              <div class="form-group">
                <label>กลุ่มงาน</label>
                <select id="filter-division"  name="filter-division[]" class="form-control select2" multiple="multiple" data-placeholder="เลือก กลุ่มงาน"
                        style="width: 100%;">
                  <?php
                  foreach ($division as $k)
                  {
                  ?>

                  <option value="{{$k->id}}">{{$k->name}}</option>
                  <?php
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
                  data-placeholder="ช่วงวันที่เกิดเหตุ">
                </div><!-- /.input group -->

              </div><!-- /.form-group -->


            </div> <!--  /.col-lg-4 col-md-4 col-sm-6 col-xs-12  -->
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

              <div class="form-group">
                <label>สถานะการประเมิน</label>
                <select id="evaluation"  name="evaluation" class="form-control select2"  data-placeholder="สถานะการประเมิน"
                        style="width: 100%;">

                <option value="">รอการประเมิน</option>
                  <?php
                  foreach ($evaluation as $k)
                  {
                  ?>

                  <option value="{{$k->id}}">{{$k->name}}</option>
                  <?php
                  }
                  ?>

                </select>
              </div>  <!-- /.form-group -->

            </div><!--  /.col-lg-4 col-md-4 col-sm-6 col-xs-12  -->

          </div><!-- /.row  -->

        </div><!-- /.box-body -->
        <div class="box-footer">
          <button type="button" name="button" class="btn btn-default" onclick="ajaxClearForm();">ล้าง</button>
          <button type="submit" name="button" class="btn btn-success pull-right">ค้นหา</button>
        </div>
   </div>

  </div>
</div>
</form>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <?php

        foreach(  $data as $rs )
        {

        //  echo $rs->id;
        }
        ?>
        <form id="myForm" name="myForm"  action=""  method="POST" >
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="js_vars" name="js_vars" value="">

        <table id="example2" class="table table-bordered table-hover table-responsive" >
                <thead>
                <tr>
                  <th class="text-center" width="15%">เกิดขึ้นเมื่อ</th>
                  <th class="text-center">ชื่อเหตุการณ์</th>
                  <th class="text-center">เหตุการณ์</th>
                  <th class="text-center">รายการ</th>
                  <th class="text-center"  width="20%">ผู้พบเห็น</th>
                  <th class="text-center"  width="12%">สถานะการประเมิน</th>
                  <th class="text-center"  width="5%"><i class="fa fa-filter"></i></th>

                </tr>
                </thead>
                <tbody>

                <?php
                 if(count($data)===0 )
                 {
                ?>
                <tr>
                  <td colspan="7" class="text-center alert alert-danger">

                               {{ trans('system.not_found')}}

                  </td>

                </tr>
                <?php
                }
                else
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
                    <!--
                    <?php echo long_th_date($rs->incident_date);?>&nbsp;
                    <?php echo showTime($rs->incident_time);?>&nbsp;
                    -->
                    <?php echo $rs->incident_date.'&nbsp;&nbsp;'.$rs->incident_time.' น.'?>
                  </td>
                  <td>
                    <a href="<?=route('headrmreview.show1',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_title, 150, '<br>');?>
                    </a>

                  </td>
                  <td>
                    <a href="<?=route('headrmreview.show1',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_event, 250, '<br>');?>
                    </a>

                  </td>
                  <td>
                    <a href="<?=route('headrmreview.show1',[$rs->id])?>" >
                    <?php echo $rs->incident_group->name;?>
                    </a>
                  </td>
                  <td><?php echo $rs->employee->prefix->name.$rs->employee->fname.'   '.$rs->employee->lname;?></td>
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
                      <a href="{{route('headrmreview.show1',$rs->id)}}"><i class="fa fa-filter"></i></a>
                  </td>


                </tr>
                <?php
                    $i++;

                  }
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
<?php
 if( count($data) > 0 ){
 ?>
 <form id="myStatusForm" name="myStatusForm"  action="{{action('IncidentController@changestatus')}}"  method="POST" >
 <input type="hidden" name="_method" value="POST">
 <input type="hidden" name="_token" value="{{ csrf_token() }}">
 <input type="hidden" id="js_id" name="js_id" value="">
 <input type="hidden" id="js_vars" name="js_vars" value="">


 <!-- Modal -->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="myModalLabel">เลือกสถานะ</h4>
       </div>
       <div class="modal-body">
         <div class="form-group">
             <div class="radio  has-success">
               <label>
                 <input type="radio" name="status" id="status_enable" value="enable"  class="minimal" <?php if ( $data[0]->status =='enable'){echo 'checked'; } ?>  >
                 <i class="fa fa-check" style="color:green;"></i>&nbsp;{{ trans('buttons.enable')}}
               </label>
             </div>
             <div class="radio has-error">
               <label>
                 <input type="radio" name="status" id="status_disable"  value="disable"  class="minimal" <?php if ( $data[0]->status =='disable'){echo 'checked'; } ?> >
                 <i class="fa fa-times" style="color:red;"></i>&nbsp;{{ trans('buttons.disable')}}
               </label>
             </div>
           </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">
           <?php echo trans('buttons.cancel');?>
         </button>

         <button type="button"  class="btn btn-primary" id="btnstatus">
           <?php echo trans('buttons.update'); ?>
         </button>
       </div>
     </div>
   </div>
 </div>
 </form>
 <?php
 }
 ?>


<script type="text/javascript" src="{{asset('/system/lang/th-message.js')}}"></script>

<script type="text/javascript" src="{{asset('js/system/headrmreview/js-handle.js')}}"></script>
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
         format: 'YYYY-MM-DD'
     }
     //,format: 'YYYY-MM-dd'

  }).val('');
  loaddatable();


});
</script>
@endsection
