@extends('layouts.page')
@section('title','ความเสี่ยงที่กลุ่มงานได้รับ' )
@section('content')
@include('layouts/function')
<?php
//------------------------------------------------------------------------------

$arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
if(count(Auth::user()->user_level) > 0 )
{
  foreach( Auth::user()->user_level as $kk => $vv)
  {
    $arr_user_level[]=$vv->level_id;
  }
}





if(isset($_POST))
{
  if( in_array('7',$arr_user_level))
  {
    if( !empty($request_division) || $request_division != '')
    {
      $is_division= $request_division;
    }
    else{
      $is_division=   $arr_division;
    }
  }
  else
  {
    if( !empty($request_division) || $request_division == '')
    {
      $is_division= $request_division;
    }
    else
    {
        $is_division=array();
    }

  }

}
//dd($is_division);



?>
<div class="box">
  <div class="box-header">
    <h3 class="box-title">ความเสี่ยงที่กลุ่มงานได้รับ : <?=$titlename?>

    </h3>
  </div>
  <!-- /.box-header -->
  <?php



  ?>
  <div class="box-body">

    <form id="myFormSearch" class="" action="{{route('rmdivisionreview.list')}}" method="post">
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
                //$arr_division = array();
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


                if( in_array('7',$arr_user_level)  )
                {
                ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                  <div class="form-group">
                    <label>กลุ่มงาน</label>

                    <select id="subdivision1" name="filter-division[]" class="select2 form-control col-2 col-lg-4 col-md-4" multiple="multiple">
                        <option value="" >***โปรดเลือกหน่วยงาน***</option>
                        <?php
                        foreach($division as $r1 =>$o1)
                        {
                          if(in_array( $o1->id ,$arr_division ) )
                          {
                        ?>

                        <option value="<?=$o1->id?>"  <?php  if(!empty($is_division)){  if(in_array( $o1->id ,$is_division )) { echo "selected='selected'";}} ?> > <?=$o1->name?></option>
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

                <?php
                if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )

                //if(Auth::user()->level_id == '1' || Auth::user()->level_id == '2')

                {
                ?>
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

                      <option value="{{$k->id}}"  <?php if(!empty($is_division)){ if(in_array( $k->id ,$is_division )) { echo "selected='selected'";} }?>  > {{$k->name}} </option>
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

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

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

        <table id="example2" class="table table-bordered table-hover table-responsive display nowrap" style="width:100%">
                <thead>
                <tr>
                    <th class="text-center" width="10%">เหตุเกิดเมื่อ</th>
                    <th class="text-center" width="20%">ชื่อเหตุการณ์</th>
                    <th class="text-center" width="20%">เหตุการณ์</th>
                    <th class="text-center" width="20%">รายการ</th>
                    <th class="text-center" width="20%">ผู้พบเห็น</th>
                    <th class="text-center" width="10%">สถานะการประเมิน</th>
                    <th class="text-center" width="5%">อ่าน</th>
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
                    //if( (( $rs->division_id == Auth::user()->division_id ) && ( Auth::user()->level_id == '4' )) || Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || ($rs->division_id == 0) )

                    $mystyleTR ;
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
                    //----------------------------------------------------------------------
                    if( in_array('1',$arr_user_level)  ||  in_array('2',$arr_user_level) )
                    //if(Auth::user()->level_id == '1'  || Auth::user()->level_id == '2')
                    {
                    ?>
                    <tr  class="<?=$mystyleTR?>">

                  <td class="text-center">
                    <?php
                    echo $rs->incident_date.'&nbsp;'.$rs->incident_time;
                    ?>
                  </td>
                  <td>

                    <a href="<?=route('rmdivisionreview.show2',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_title, 150, '<br>');?>
                    </a>
                  </td>
                  <td>

                    <a href="<?=route('rmdivisionreview.show2',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_event, 250, '<br>');?>
                    </a>
                  </td>
                  <td>

                    <a href="<?=route('rmdivisionreview.show2',[$rs->id])?>" >

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
                  <td class="text-center">
                      <a href="{{route('rmdivisionreview.show2',[$rs->id])}}"><i class="fa fa-mail-forward"></i></a>
                  </td>




                </tr>
                    <?php
                    $i++;
                    }
                    //else if(Auth::user()->level_id == '4')
                    elseif( in_array('7',$arr_user_level) )
                    {
                      // code...
                      if( in_array($rs->division_id ,$arr_division))
                      {
                      //if( $rs->division_id == Auth::user()->division_id)
                      //{

                ?>
                <tr  class="<?=$mystyleTR?>">

                                  <td  class="text-center">
                                    <?php
                                    //echo $arr_division
                                    echo " ** ".$rs->incident_date.'<br>'.$rs->incident_time;
                                    ?>
                                  </td>
                                  <td>

                                    <a href="<?=route('rmdivisionreview.show2',[$rs->id])?>" >
                                    <?php echo wordwrap($rs->incident_title, 150, '<br>');?>
                                    </a>
                                  </td>
                                  <td>

                                    <a href="<?=route('rmdivisionreview.show2',[$rs->id])?>" >
                                    <?php echo wordwrap($rs->incident_event, 250, '<br>');?>
                                    </a>
                                  </td>
                                  <td>

                                    <a href="<?=route('rmdivisionreview.show2',[$rs->id])?>" >

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

                                  <td><?php
								  //echo $rs->employee->prefix->name.$rs->employee->fname.'   '.$rs->employee->lname;
									if(empty($rs->employee->fname))
									  {
										echo '<span class="bg-red">ผู้เห็นเหตุการณ์นี้ถูกลบออกจากระบบ</span>';
									  }
									  else
									  {
										echo $rs->employee->prefix->name.$rs->employee->fname.'   '.$rs->employee->lname;
									  }
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
                                      <a href="{{route('rmdivisionreview.show2',[$rs->id])}}"><i class="fa fa-mail-forward"></i></a>
                                  </td>




                                </tr>
                <?php
                      $i++;
                      }
                    }
                    else
                    {

                    }



                ?>
                <?php
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


<script type="text/javascript" src="{{asset('/system/lang/th-message.js')}}"></script>


<script type="text/javascript" src="{{asset('js/system/rmdivisionreview/js-handle0.js')}}"></script>
<script>
function ajaxClearForm()
{
  $('#myFormSearch #filter-daterage').val('');
  $('#myFormSearch').submit();
}

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
