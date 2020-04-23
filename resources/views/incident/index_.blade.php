@extends('layouts.page')
@section('title','อุบัติการณ์ความเสี่ยง ' )
@section('content')
@include('layouts/function')
<div class="box">
  <div class="box-header">
    <h3 class="box-title">อุบัติการณ์ความเสี่ยง  </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <div class="form-group">
          <label for=""></label>
      </div>
    </div>
</div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <?php


        ?>
        <form id="myForm" name="myForm"  action=""  method="POST" >
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="js_vars" name="js_vars" value="">

        <table id="example2" class="table table-bordered table-hover table-responsive" >
                <thead>
                <tr>
                  <th class="text-center">ว/ด/ป</th>
                  <th class="text-center">ชื่อเหตุการณ์</th>
                  <th class="text-center">อุบัติการณ์ความเสี่ยง</th>
                  <th class="text-center">หมวดหมู่</th>

                  <th class="text-center">ผู้พบเห็น</th>
                  <?php
                  if ( (Auth::user()->level_id == '1') || (Auth::user()->level_id == '2')  )
                  {
                  ?>
                  <th > </th>
                  <?php
                  }
                  ?>



                </tr>
                </thead>
                <tbody>

                <?php
                 if(count($data)===0 )
                 {
                ?>
                <tr>
                  <td colspan="5" class="text-center alert alert-danger">

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

                    if( Auth::user()->id  == $rs->by_user_id ||(Auth::user()->level_id==1)  || (Auth::user()->level_id==2))
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
                        else if( $rs->incident_status_id =='3' )
                        {
                          $class='bg-success';
                        }


                      }
                ?>


                <tr class="<?=$class?>">

                  <td><?php echo $rs->incident_date.'&nbsp;'.showTime($rs->incident_time);?>&nbsp;น.</td>
                  <td>

                    <a href="<?=route('incident.show',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_title, 100, '<br>');?>
                    </a>
                    <?php
                    if( $rs->headrm_delete =='Y')
                    {
                    ?>
                    <p class="text-red"><i class="fa fa-ban"></i>&nbsp;ความเสี่ยงนี้ดำเนินการคัดออกจากระบบ.</p>

                    <?php
                    }
                    ?>
                  </td>
                  <td>

                    <a href="<?=route('incident.show',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_event, 300, '<br>');?>
                    </a>
                  </td>
                  <td>
                    <?php
                    if( $rs->incident_group_id =='' || empty($rs->incident_group_id) ){
                    //if( $rs->incident_list_id =='' || empty($rs->incident_list_id) ){

                      echo '-';
                    }else{
                      echo $rs->incident_group->name;

                    }
                    ?>
                  </td>
                  <td><?php echo $rs->employee->prefix->name.$rs->employee->fname.'   '.$rs->employee->lname;?></td>



                  <?php
                  if ( (Auth::user()->level_id == '1') || (Auth::user()->level_id == '2')  )
                  {
                  ?>
                  <td class="text-center">

                    <?php

                    if ($rs->trashed())
                    {
                    ?>

                    <a href="javascript:ajaxRestore('<?=$rs->id?>');" title="{{trans('buttons.restore')}}" id="btnReStore<?php echo $rs->id;?>"
                      class="btn btn-small" >
                      <i class="fa fa-recycle"></i>
                    </a>

                    <a href="javascript:ajaxDelete('<?=$rs->id?>');" title="{{trans('buttons.delete')}}"  id="btnDelete<?php echo $rs->id;?>"
                      class="btn btn-small" >
                      <i class="fa fa-trash-o"></i>
                    </a>

                    <?php

                    }
                    else
                    {
                    ?>



                  <a href="javascript:ajaxShow('<?=$rs->id?>');" title="{{trans('buttons.view')}}"  id="btnShow<?php echo $rs->id;?>"
                    class="btn btn-small" >
                    <i class="fa fa-clipboard"></i>
                  </a>
                  <?php

                  if( (Auth::user()->level_id == '1' ) ||  ( Auth::user()->level_id == '2' )|| ( Auth::user()->level_id == '3' ) )
                  {
                  ?>
                  <a href="javascript:ajaxEdit('<?=$rs->id?>');" title="{{trans('buttons.edit')}}"   id="btnEdit<?php echo $rs->id;?>" class="btn" >
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="javascript:ajaxSoftDelete('<?=$rs->id?>');"  title="{{trans('buttons.softdelete')}}" id="btnSoftDelete<?php echo $rs->id;?>" class="btn" >
                    <i class="fa fa-trash"></i>
                  </a>
                  <?php
                  }
                  ?>


                    <?php
                    }
                    ?>
                  </td>
                  <?php
                  }
                  ?>

                </tr>
                <?php
                    $i++;
                    }
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
<?php
if(Auth::user()->level_id == '1' || Auth::user()->level_id == '2' )
{
?>
<script type="text/javascript" src="{{asset('js/system/incident/js-handle1.js')}}"></script>
<?php
}
else
{
?>
<script type="text/javascript" src="{{asset('js/system/incident/js-handle.js')}}"></script>
<?php
}
?>

<script>



  $(function () {

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_flat-blue'
    });
    showhideMainButtonAction('hide')
    /*
    $('#btnMainEdit').hide();
    $('#btnMainTrash').hide();
    $('#btnMainRestore').hide();
    $('#btnMainDelete').hide();
    */
    chkAll();
    show_status_modal();
    save_status_modal();

    countChkboxForCheckAll();



    $('input[name="checkboxID[]"]').on('ifChanged', function(event) {
      if( event.target.checked == true)
      {
        if( $('input[name="checkboxID[]"]:checked').length >0)
        {
            //alert($('input[name="checkboxID[]"]:checked').length);
            //checkboxAll
            /*
              $('#btnMainEdit').show();
              $('#btnMainTrash').show();
            */
            showhideMainButtonAction('show')
        }
        else
        {
          showhideMainButtonAction('hide')
          /*
          $('#btnMainEdit').hide();
          $('#btnMainTrash').hide();
          */

        }
      }
      else {
        if( $('input[name="checkboxID[]"]:checked').length < 1)
        {
          showhideMainButtonAction('hide')
          /*
          $('#btnMainEdit').hide();
          $('#btnMainTrash').hide();
          */
        }
      }
    });
loaddatable();

  });
</script>
@endsection
