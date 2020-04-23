@extends('layouts.page')
@section('title','รายละเอียดเจ้าหน้าที่' )
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
?>
<div class="box">
  <div class="box-header">
    <h3 class="box-title"> <?php echo trans('buttons.info');?>รายละเอียดเจ้าหน้าที่ </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">

    <div class="row ">
      <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 col-label-show " >
        <strong>เจ้าหน้าที่</strong>
      </div>
      <div class="col-lg-10  col-md-9 col-sm-8 col-xs-12">
        <p class="text-muted">
          <?php echo $data->prefix->name.$data->fname.'   '.$data->lname;?>
        </p>
      </div>
    </div>

    <div class="row ">
      <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 col-label-show " >
        <strong>ตำแหน่ง</strong>
      </div>
      <div class="col-lg-10  col-md-9 col-sm-8 col-xs-12">
        <p class="text-muted">
          <?php echo $data->position->name;?>
        </p>
      </div>
    </div>
    <div class="row ">
      <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 col-label-show " >
        <strong>กลุ่มงาน</strong>
      </div>
      <div class="col-lg-10  col-md-9 col-sm-8 col-xs-12">
        <p class="text-muted">
          <?php echo $data->division->name;?>
        </p>
      </div>
    </div>
    <div class="row ">
      <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 col-label-show " >
        <strong>หน่วยงาน</strong>
      </div>
      <div class="col-lg-10  col-md-9 col-sm-8 col-xs-12">
        <p class="text-muted">
          <?php echo $data->subdivision->name;?>
        </p>
      </div>
    </div>


  </div><!-- /.box-body -->
  <div class="box-footer">
    <a href="{{route('employee.index')}}" class="btn btn-md btn-default">
        <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
    </a>
    <?php
      if( in_array('1',$arr_user_level)  ||  in_array('2',$arr_user_level) )
    {
    ?>
    <a href="{{action('EmployeeController@edit',$data->id)}}" class="btn btn-primary pull-right">
      <i class="fa fa-btn fa-edit"></i> {{trans('buttons.edit')}}
    </a>
    <?php
    }
    ?>
  </div>
</div><!-- /.box -->
@endsection
