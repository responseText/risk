@extends('layouts.page')
@section('title','ผู้ได้รับผลกระทบ ' )
@section('content')
@include('layouts/function')
<?php
$arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
// --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
if(count(Auth::user()->user_level) > 0 )
{
  foreach( Auth::user()->user_level as $kk => $vv)
  {
    $arr_user_level[]=$vv->level_id;
  }
}
?>
<div class="box">
  <div class="box-header">
    <h3 class="box-title">ผู้ได้รับผลกระทบ  </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">

    <div class="row">
      <?php
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
      {
      ?>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <a href="{{route('effect.create')}}" class="btn btn-primary">
          <i class="fa fa-plus">&nbsp;</i>{{trans('buttons.add')}}
        </a>
        <a href="javascript:ajaxMainEdit();"  id="btnMainEdit" name="btnMainEdit"  class="btn btn-warning">
          <i class="fa fa-edit">&nbsp;</i> {{trans('buttons.edit')}}
        </a>
        <?php
        }
        ?>
        <?php
        if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
        {
        ?>
        <a href="javascript:ajaxMainSoftDelete();"  id="btnMainTrash" name="btnMainTrash"  class="btn btn-danger">
          <i class="fa fa-trash"></i>&nbsp;{{trans('buttons.softdelete')}}
        </a>

<a href="javascript:ajaxMainRestoreAll();"  id="btnMainRestore" name="btnMainRestore"  class="btn btn-success">
  <i class="fa fa-recycle"></i>&nbsp;{{trans('buttons.restore')}}
</a>
<a href="javascript:ajaxMainDeleteAll();"  id="btnMainDelete" name="btnMainDelete"  class="btn btn-danger">
  <i class="fa fa-trash-o"></i>&nbsp;{{trans('buttons.delete')}}
</a>
<?php
}
?>

      </div>
    </div>

    <br>
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
                  <th class="text-center">

                    <input id="checkboxAll" name="checkboxAll" type="checkbox" class="minimal checkall" value="0"></th>
                  <th class="text-center">ผู้ได้รับผลกระทบ</th>
                  <th class="text-center">สถานะ</th>
                  <th class="text-center">การกระทำ</th>

                </tr>
                </thead>
                <tbody>

                <?php
                 if(count($data)===0 )
                 {
                ?>
                <tr>
                  <td colspan="4" class="text-center alert alert-danger">

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
                <tr>
                  <td class="text-center">
                    <input id="checkboxID<?=$rs->id?>" name="checkboxID[]" type="checkbox" class="minimal" value="<?php echo $rs->id; ?>">
                  </td>
                  <td>

                    <a href="<?=route('effect.show',[$rs->id])?>" >
                    <?php echo $rs->name;?>
                    </a>
                  </td>
                  <td class="text-center">
                    <?php
                    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
                    {
                    ?>
                    <a href="#"  data-toggle="modal" data-target="#myModal" data-itemid="<?=$rs->id?>"
                      data-itemvalue="<?=$rs->status?>" id="btnstatus<?php echo $rs->id?>"
                      class="<?php if( $rs->status =='enable'){ echo "text-success";}else{ echo "text-danger"; }?>" >
                    <?php echo showStatus( $rs->status ); ?>
                    </a>

                    <?php
                    }
                    else
                    {
                    ?>
                    <?php echo showStatus( $rs->status ); ?>
                    <?php
                    }
                    ?>
                  </td>
                  <td class="text-center">

                    <?php

                    if ($rs->trashed())
                    {
                    ?>

                    <a href="javascript:ajaxRestore('<?=$rs->id?>');" title="{{trans('buttons.restore')}}" id="btnReStore<?php echo $rs->id;?>"
                      class="btn btn-small" >
                      <i class="fa fa-recycle"></i>
                    </a>
                    <?php

                    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
                    {
                    ?>
                    <a href="javascript:ajaxDelete('<?=$rs->id?>');" title="{{trans('buttons.delete')}}"  id="btnDelete<?php echo $rs->id;?>"
                      class="btn btn-small" >
                      <i class="fa fa-trash-o"></i>
                    </a>
                    <?php
                    }
                    ?>

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

                  if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
                  {
                  ?>
                  <a href="javascript:ajaxEdit('<?=$rs->id?>');" title="{{trans('buttons.edit')}}"   id="btnEdit<?php echo $rs->id;?>" class="btn" >
                    <i class="fa fa-edit"></i>
                  </a>
                  <?php
                  }
                  if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
                  {
                  ?>
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
 <form id="myStatusForm" name="myStatusForm"  action="{{action('EffectController@changestatus')}}"  method="POST" >
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

<script type="text/javascript" src="{{asset('js/system/effect/js-handle.js')}}"></script>
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
