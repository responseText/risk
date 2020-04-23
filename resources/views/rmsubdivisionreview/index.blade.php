@extends('layouts.page')
@section('title','ความเสี่ยงที่หน่วยงานได้รับ ' )
@section('content')
@include('layouts/function')

<?php
$arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
if(count(Auth::user()->user_level) > 0 )
{
  foreach( Auth::user()->user_level as $kk => $vv)
  {
    $arr_user_level[]=$vv->level_id;
  }
}

// ----- Loop เก็บ หน่วยงาาน --------------------------------------------------
//$arr_subdivision = array();
if( count(Auth::user()->user_level)>0 )
{
  foreach(  Auth::user()->user_level as $k => $v)
  {

    if( $v->level_id =="8" )
    {
    $arr_subdivision[$k]=$v->subdivision_id;
    }
  }
}

//arr_subdivision
$is_subdivision = array();
if(isset($_POST))
{
  if( in_array('8',$arr_user_level) )
  {
    if( !empty($request_subdivision) || $request_subdivision != '')
    {
      $is_subdivision = $request_subdivision;
    }
    else{
      $is_subdivision =   $arr_subdivision;
    }
  }
  elseif( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
  {
    if( !empty($request_subdivision) || $request_subdivision != '')
    {
      $is_subdivision= $request_subdivision;
    }
    else
    {
        $is_subdivision = $arr_subdivision;
    }
  }

}


?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">ความเสี่ยงที่หน่วยงานได้รับ : <?=$titlename?> </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">


    <form id="myFormSearch" class="" action="{{route('rmsubdivisionreview.search')}}" method="post">
    <input type="hidden" name="_method" value="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <?php

    $old_daterage;
    //dd($request->input['filter-division']);

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
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">ค้นหา</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <div class="row">
                <?php

                $old_evaluation;
                $old_daterage;


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
                <?php
                if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level))
                //if(Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
                {
                ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                  <div class="form-group">
                    <label>กลุ่มงาน</label>

                    <select id="filter-division"  name="filter-subdivision[]" class="form-control select2" multiple="multiple" data-placeholder="เลือก กลุ่มงาน"
                            style="width: 100%;">
                      <?php
                      foreach ($subdivision as $k)
                      {
                        //foreach(  $arr_division as $v)
                        //{
                      ?>

                      <option value="{{$k->id}}" <?php if( count($is_subdivision) > 0 ){ if(in_array($k->id,$is_subdivision)){ echo 'selected="selected"'; } }?>   >{{$k->name}}</option>
                      <?php
                        //}
                      }
                      ?>

                    </select>
                  </div>  <!-- /.form-group -->

                </div>
                <?php
                }
                ?>

                <?php

                //if(checkUserLevel4(Auth::user()) == 'yes')
                if( in_array('8',$arr_user_level) )
                {

                ?>
                <?php  ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                  <div class="form-group">

                    <label>กลุ่มงาน </label>

                    <select id="subdivision1" name="filter-subdivision[]" class="select2 form-control col-2 col-lg-4 col-md-4" multiple="multiple">
                        <option value="" >***โปรดเลือกหน่วยงาน***</option>
                        <?php
                        foreach($subdivision as $r1 =>$o1)
                        {
                          if(in_array( $o1->id ,$arr_subdivision ) )
                          {
                        ?>

                        <option value="<?=$o1->id?>" <?php if( count($is_subdivision) > 0 ){ if(in_array($o1->id,$is_subdivision)){ echo 'selected="selected"'; } }?>  >  <?=$o1->name?></option>
                        <?php

                          }
                        }
                        ?>

                      </select>
                  </div>  <!-- /.form-group -->

                </div>
                <?php

              }
                ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                  <div class="form-group">
                    <label>ช่วงวันที่เกิดเหตุ</label>

                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name='filter-daterage' class="form-control pull-right" id="filter-daterage"
                     value="<?=$old_daterage?>">
                    </div><!-- /.input group -->

                  </div><!-- /.form-group -->


                </div> <!--  /.col-lg-4 col-md-4 col-sm-6 col-xs-12  -->


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

        <table id="example2" class="table table-bordered table-hover table-responsive display nowrap"  style="width:100%" >
                <thead>
                <tr>
                  <th class="text-center" width="10%">เกิดขึ้นเมื่อ </th>
                  <th class="text-center" width="20%">ชื่อเหตุการณ์</th>
                  <th class="text-center" width="40%">เหตุการณ์</th>
                  <th class="text-center" width="20%">รายการ</th>


                  <th class="text-center" width="10%">ผู้พบเห็น</th>
                  <th class="text-center" width="5%">อ่าน</th>

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
                  //if( ( ( $rs->division_id == Auth::user()->division_id ) &&  Auth::user()->level_id == '4') || Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || ($rs->division_id == 0)  )

                  $i=1;
                  foreach ( $data as $rs)
                  {

                //  if( ( ( $rs->division_id == Auth::user()->division_id ) &&  Auth::user()->level_id == '4') || Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || ($rs->division_id == 0)  )
                    //if( $rs->division_id == Auth::user()->division_id  &&  Auth::user()->level_id == '5' && $rs->sub_division_id==Auth::user()->subdivision_id  || Auth::user()->level_id == '1'  || Auth::user()->level_id == '2' )
                   if( in_array($rs->sub_division_id, $arr_subdivision)  && in_array('8',$arr_user_level)  )
                   {


                    //if( $rs->)
                    //{
                ?>


                <tr>

                  <td><?php echo $rs->incident_date;?>&nbsp;<?php echo $rs->incident_time;?> </td>
                  <td>

                    <a href="<?=route('rmsubdivisionreview.create',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_title, 300, '<br>');?>
                    </a>
                  </td>
                  <td>

                    <a href="<?=route('rmsubdivisionreview.create',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_event, 200, '<br>');?>
                    </a>
                  </td>
                  <td>

                    <a href="<?=route('rmsubdivisionreview.create',[$rs->id])?>" >

                  <?php
                    if( $rs->incident_list_id=='' )
                    {
                      echo '-';
                    }
                    else
                    {
                      if( $rs->incident_list_id== '' )
                      {
                        echo '-';
                      }
                      else
                      {
                        if(empty($rs->incident_list->id))
                        {
                          echo '<strong class="bg-red">*** รายการนี้ถูกลบออกจากระบบ ***</strong>' ;
                        }
                        else
                        {
                          echo $rs->incident_list->name;
                        }
                      }
                    }
                  ?>

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

                  ?>
				          </td>
                  <td class="text-center">
                      <a href="{{route('rmsubdivisionreview.create',$rs->id)}}"><i class="fa fa-mail-forward"></i></a>
                  </td>


                </tr>
                <?php
                    $i++;

                    } // $rs->sub_division_id==Auth::user()->subdivision_id  && Auth::user()->level_id == '5'
                    else if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
                    {
                    ?>
                    <tr>

                      <td><?php echo $rs->incident_date;?>&nbsp;&nbsp;<?php echo $rs->incident_time;?> </td>
                      <td>

                        <a href="<?=route('rmsubdivisionreview.create',[$rs->id])?>" >
                        <?php echo wordwrap($rs->incident_title, 200, '<br>');?>
                        </a>
                      </td>
                      <td>

                        <a href="<?=route('rmsubdivisionreview.create',[$rs->id])?>" >
                        <?php echo wordwrap($rs->incident_event, 250, '<br>');?>
                        </a>
                      </td>
                      <td>

                        <a href="<?=route('rmsubdivisionreview.create',[$rs->id])?>" >

                      <?php
                        if( $rs->incident_list_id=='' )
                        {
                          echo '-';
                        }
                        else
                        {
                          if( $rs->incident_list_id== '' )
                          {
                            echo '-';
                          }
                          else
                          {
                            if(empty($rs->incident_list->id))
                            {
                              echo '<strong class="bg-red">*** รายการนี้ถูกลบออกจากระบบ ***</strong>' ;
                            }
                            else
                            {
                              echo $rs->incident_list->name;
                            }
                          }
                        }
                      ?>

                      </td>

                      <td><?php echo $rs->employee->prefix->name.$rs->employee->fname.'   '.$rs->employee->lname;?></td>
                      <td class="text-center">
                          <a href="{{route('rmsubdivisionreview.create',$rs->id)}}"><i class="fa fa-mail-forward"></i></a>
                      </td>


                    </tr>

                    <?php

                    }

                  } // foreach

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

<script type="text/javascript" src="{{asset('/system/lang/th-message.js')}}"></script>

<script type="text/javascript" src="{{asset('js/system/rmsubdivisionreview/js-handle.js')}}"></script>
<script>

function ajaxClearForm()
{

  $('#myFormSearch #filter-daterage').val('');

  $('#myFormSearch').submit();
}

  $(function () {


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

    }).val('<?=$old_daterage?>');
loaddatable();

  });

</script>



@endsection
