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

//------------------------------------------------------------------------------
/*
function checkUserLevel4( $param ) // หัวหน้ากลุ่มงาน
{
  //if( count(Auth::user()->user_level)>0 )
  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {
      switch( $v->level_id )
      {
        case("4"): return "yes"; break;
      }
    }
  }

}
*/
if(isset($_POST))
{
  //if(checkUserLevel4(Auth::user()) == 'yes')
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
      if( empty($request_division) || $request_division != '')
      {
        $is_division= $request_division;
      }
      else
      {
          $is_division=array();
      }

    }

}
?>
<script type="text/javascript">
$(document).ready(function(){
  $('#subdivision1').change(function(){
      //  alert( $('#subdivision1').val() ) ;
  });
});

</script>

<hr>






<div class="box">
  <div class="box-header">
    <h3 class="box-title">ความเสี่ยงที่หน่วยงานได้รับ  : <?=$titlename?>   </h3>



  </div>
  <!-- /.box-header -->

  <div class="box-body">

    <form id="myFormSearch" class="" action="{{route('headdivisionreview.search')}}" method="POST">
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
                //if(Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
                if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
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
                <?php
                //if(Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
                if( in_array('7',$arr_user_level) )
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
                        if(in_array( $k->id ,$arr_division ) )
                        {
                        //foreach(  $arr_division as $v)
                        //{
                      ?>

                      <option value="{{$k->id}}"  <?php if(!empty($is_division)){ if(in_array( $k->id ,$is_division )) { echo "selected='selected'";} }?>  > {{$k->name}} </option>
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

              <a href="{{route('rmdivisionreview.index')}}" class="btn btn-default">ล้าง</a>
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

        <table id="example2" class="table table-bordered table-hover table-responsive  display nowrap"  style="width:100%" >
                <thead>
                <tr>
                  <th class="text-center" width="10%">เกิดขึ้นเมื่อ </th>
                  <th class="text-center" width="20%">ชื่อเหตุการณ์</th>
                  <th class="text-center" width="20%">เหตุการณ์</th>
                  <th class="text-center" width="20%">รายการ</th>


                  <th class="text-center"width="15%">ผู้พบเห็น</th>
                  <th class="text-center"width="5%">อ่าน</th>

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
                    //if( ( ( $rs->division_id == Auth::user()->division_id ) &&  Auth::user()->level_id == '4') || Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || ($rs->division_id == 0)  )
                    //{

                    //if( $rs->)
                    //{
                ?>


                <tr>

                  <td><?php echo $rs->incident_date;?>&nbsp;<?php echo $rs->incident_time;?></td>
                  <td>

                    <a href="<?=route('rmdivisionreview.show',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_title, 150, '<br>\n');?>
                    </a>
                  </td>
                  <td>
                    <a href="<?=route('rmdivisionreview.show',[$rs->id])?>" >
                    <?php echo wordwrap($rs->incident_event, 150, '<br>');?>
                    </a>
                  </td>
                  <td>

                    <a href="<?=route('rmdivisionreview.show',[$rs->id])?>" >

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
				  ?></td>
                  <td class="text-center">
                      <a href="{{route('rmdivisionreview.show',$rs->id)}}"><i class="fa fa-mail-forward"></i></a>
                  </td>


                </tr>
                <?php
                    $i++;

                    //} // endif

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

<?php

$nameRoute = Route::currentRouteName();
if($nameRoute =="rmdivisionreview.index")
{
?>
<script type="text/javascript" src="{{asset('js/system/rmdivisionreview/js-handle.js')}}"></script>
<?php
}else{
?>
<script type="text/javascript" src="{{asset('js/system/rmdivisionreview/js-handle1.js')}}"></script>
<?php
}
?>

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
