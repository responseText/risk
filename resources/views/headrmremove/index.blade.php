@extends('layouts.page')
@section('title','ความเสี่ยงที่ได้รับ ' )
@section('content')
@include('layouts/function')
<div class="box">
  <div class="box-header">
    <h3 class="box-title">ความเสี่ยงที่ได้รับ </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">


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
                  <th class="text-center" width="13%">เกิดขึ้นเมื่อ</th>
                  <th class="text-center">ชื่อเหตุการณ์</th>
                  <th class="text-center">เหตุการณ์</th>
                  <th class="text-center" width="15%">ประเภทความเสี่ยง</th>
                  <th class="text-center" width="8%">ความรุนแรง</th>
                  <th class="text-center"  width="15%">ผู้พบเห็น</th>
                  <th class="text-center"  width="8%">ส่งให้กลุ่มงาน</th>

                </tr>
                </thead>
                <tbody>

                <?php
                 if(count($data)===0 )
                 {
                ?>
                <tr>
                  <td colspan="6" class="text-center alert alert-danger">

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


                ?>


                <tr >

                  <td>
                    <?php echo $rs->incident_date;?>&nbsp;

                    <?php echo showTime($rs->incident_time);?>&nbsp;น.


                  </td>
                  <td>
                    <a href="<?=route('headrmremove.show',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_title, 200, '<br>');?>
                    </a>

                  </td>
                  <td>
                    <a href="<?=route('headrmremove.show',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_event, 350, '<br>');?>
                    </a>

                  </td>
                  <td class="text-center">
                    <a href="<?=route('headrmremove.show',[$rs->id])?>" >
                    <?php echo $rs->typerisk->name;?>
                    </a>

                  </td>
                  <td class="text-center">
                    <strong style="color:<?php echo  $rs->violence->violence_level->color;?> ;">
                      <?php echo $rs->violence->code;?>
                    </strong> &nbsp;&nbsp;
                    <i class="fa fa-line-chart" style="color:<?php echo  $rs->violence->violence_level->color;?> ;"></i>
                  </td>
                  <td>
				  <?php 
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
                      <a href="{{route('headrmremove.show',$rs->id)}}"><i class="fa fa-mail-forward"></i></a>
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

<script type="text/javascript" src="{{asset('js/system/headrmremove/js-handle.js')}}"></script>
<script>



  $(function () {



loaddatable();

  });
</script>
@endsection
