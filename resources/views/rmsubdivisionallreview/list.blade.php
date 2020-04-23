@extends('layouts.page')
@section('title','ความเสี่ยงที่กลุ่มงานได้รับ' )
@section('content')



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

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="box">
      <div class="box-header">

        <h3 class="box-title">ความเสี่ยงที่หน่วยงานได้รับ :<?=$titlename ?>
      </div>
      <div class="box-body">

        <form id="myFormSearch" class="" action="{{route('rmsubdivisionreview.list')}}" method="post">
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
                    <?php
                    $arr_division = array();
                    $old_evaluation;
                    $old_daterage;
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
                    <?php
                    //if(Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
                    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level))
                    {
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                      <div class="form-group">
                        <label>กลุ่มงาน</label>

                        <select id="filter-subdivision"  name="filter-subdivision[]" class="form-control select2" multiple="multiple" data-placeholder="เลือก หน่วยงาน"
                                style="width: 100%;">
                          <?php
                          foreach ($subdivision as $k)
                          {
                            //foreach(  $arr_division as $v)
                            //{
                          ?>

                          <option value="{{$k->id}}" <?php if(in_array($k->id,$is_subdivision)) echo 'selected="selected"'; ?>>{{$k->name}}</option>
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
                    //if(Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
                    if( in_array('8',$arr_user_level) )
                    {
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                      <div class="form-group">
                        <label>กลุ่มงาน</label>

                        <select id="filter-subdivision"  name="filter-subdivision[]" class="form-control select2" multiple="multiple" data-placeholder="เลือก หน่วยงาน"
                                style="width: 100%;">
                          <?php
                          foreach ($subdivision as $k)
                          {
                            if(in_array( $k->id ,$arr_subdivision ) )
                            {
                            //foreach(  $arr_division as $v)
                            //{
                          ?>

                          <option value="{{$k->id}}" <?php if(in_array($k->id,$is_subdivision)) echo 'selected="selected"'; ?>>{{$k->name}}</option>
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

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                      <div class="form-group">
                        <label>ช่วงวันที่เกิดเหตุ</label>

                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" name='filter-daterage' class="form-control pull-right" id="filter-daterage"
                          data-placeholder="ช่วงวันที่เกิดเหตุ" value="{{$old_daterage}}" >
                        </div><!-- /.input group -->

                      </div><!-- /.form-group -->


                    </div> <!--  /.col-lg-4 col-md-4 col-sm-6 col-xs-12  -->
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

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
                      </div>  <!-- /.form-group -->

                    </div><!--  /.col-lg-4 col-md-4 col-sm-6 col-xs-12  -->



                  </div><!-- /.row  -->

                </div><!-- /.box-body -->
                <div class="box-footer">
                  <a href="{{route('rmsubdivisionreview.list')}}" class="btn btn-default" >ล้าง</a>

                  <button type="submit" name="button" class="btn btn-success pull-right">ค้นหา</button>
                </div>
           </div>

          </div>
        </div>
        </form>












        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <table id="example2" class="table table-bordered table-hover table-responsive display nowrap"  style="width:100%">
              <thead>
                <tr>
                  <th class="text-center" width="10%">เหตุเกิดเมื่อ</th>
                  <th class="text-left" width="20%">ชื่อเหตุการณ์</th>
                  <th class="text-center" width="30%">รายการ</th>
                  <th class="text-center" width="20%">ผู้พบเห็น</th>
                  <th class="text-center" width="20%">สถานะการประเมิน</th>
                  <th class="text-center" width="5%">อ่าน</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(count($data)<= 0 )
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
                  $mystyleTR ;


                  foreach( $data as $rs)
                  {
                    if($rs->incident_status_id =='1')
                    {
                      $mystyleTR ="bg-danger";
                    }
                    else if($rs->incident_status_id=='2')
                    {
                      $mystyleTR ='bg-info';

                    }
                    else if($rs->incident_status_id=='3')
                    {
                      $mystyleTR ='bg-success';

                    }
                    else
                    {
                      $mystyleTR ='';
                    }
                ?>
                <?php
                if( in_array('8',$arr_user_level) )
                //if(Auth::user()->level_id == '5')
                {
                  //if( $rs->sub_division_id == Auth::user()->subdivision_id)
                  if( in_array('8',$arr_user_level) )
                  if(  in_array($rs->sub_division_id,$is_subdivision))
                  {
                ?>
                <tr class="<?=$mystyleTR?>">
                  <td class="text-center">
                    <?=$rs->incident_date?>&nbsp;<?=$rs->incident_time?>

                  </td>
                  <td>
                    <?= wordwrap($rs->incident_title,150,'</br>')?>
                  </td>
                  <td>
                    <a href="<?=route('rmsubdivisionreview.show',[$rs->id])?>" >
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
                    </a>
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
                  <td class='text-center'>
                    <a href="{{route('rmsubdivisionreview.show',[$rs->id])}}"><i class="fa  fa-commenting-o"></i></a>
                  </td>

                </tr>
                <?php
                  } // $rs->sub_division_id == Auth::user()->subdivision_id
                } //----- if Auth::user()->level_id
                //else if(Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
                else if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
                {
                ?>
                <tr class="<?=$mystyleTR?>">
                  <td class="text-center">
                    <?=$rs->incident_date?>&nbsp;<?=$rs->incident_time?>

                  </td>
                  <td>
                    <?= wordwrap($rs->incident_title,150,'</br>')?>
                  </td>
                  <td>
                    <a href="<?=route('rmsubdivisionreview.show',[$rs->id])?>" >
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
                    </a>
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
					?>
                  </td>
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
                  <td class='text-center'>
                    <a href="{{route('rmsubdivisionreview.show',[$rs->id])}}"><i class="fa  fa-commenting-o"></i></a>
                  </td>

                </tr>
                <?php
                }
                ?>
                <?php
                  }  //foreach( $data as $rs)
                } // count($data)<= 0
                ?>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript" src="{{asset('/system/lang/th-message.js')}}"></script>
<script type="text/javascript" src="{{asset('js/system/rmsubdivisionreview/js-handle1.js')}}"></script>
<script>
$(function () {
  $('.select2').select2();
  $('#filter-daterage').daterangepicker({
     locale:{
         cancelLabel: 'ลบ' ,
         applyLabel: 'ตกตง',
         locale: 'th',
         format: 'YYYY-MM-DD'
     }


  }).val('<?=$old_daterage?>');
  loaddatable();
});
</script>
@endsection
