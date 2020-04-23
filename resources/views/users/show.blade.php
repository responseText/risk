@extends('layouts.page')
@section('title','รายละเอียดผู้ใช้งานระบบ' )
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
    <h3 class="box-title"> <?php echo trans('buttons.info');?>รายละเอียดผู้ใช้งานระบบ </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">

    <div class="row ">
      <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 col-label-show " >
        <strong>ผู้ใช้งานระบบ</strong>
      </div>
      <div class="col-lg-10  col-md-9 col-sm-8 col-xs-12">
        <p class="text-muted">
          <?php echo $data->name;?>
        </p>
      </div>
    </div>

    <div class="row ">
      <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 col-label-show " >
        <strong>เจ้าหน้าที่</strong>
      </div>
      <div class="col-lg-10  col-md-9 col-sm-8 col-xs-12">
        <p class="text-muted">
          <?php echo $data->employee->prefix->name.$data->employee->fname.'   '.$data->employee->lname;?>
        </p>
      </div>
    </div>


    <div class="row ">
      <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 col-label-show " >
        <strong>ระดับผู้ใช้งาน</strong>
      </div>
      <div class="col-lg-10  col-md-9 col-sm-8 col-xs-12">
      <?php
      if(count($dataLevel)>0){
        foreach($dataLevel as $k => $v )
        {
           if(!in_array($v->level_id,[4,5,7,8]))
           {
             if ($v->level_id != 6 )
             {
               echo '<p class="text-success"><strong>-&nbsp;'.$v->get_level_access[0]->name.'</strong></p>';
             }
             else
             {
               echo "User ";
             }

           }
           else
           {
              if($v->level_id =='4' || $v->level_id =='7' )
              {
                echo '<p class="text-success"><strong>-&nbsp;'.$v->get_level_access[0]->name.'</strong></p>';
                echo '<p class="text-muted">&nbsp;&nbsp;กลุ่มงาน   : '.$v->division[0]->name.'</p>';

              }
              else if($v->level_id =='5' || $v->level_id =='8' )
              {
                echo '<p class="text-success"><strong>-&nbsp;'.$v->get_level_access[0]->name.'</strong></p>';
                echo '<p class="text-muted">&nbsp;&nbsp;กลุ่มงาน   : '.$v->division[0]->name.'</p>';
                echo '<p class="text-muted">&nbsp;&nbsp;หน่วยงาน  : '.$v->subdivision[0]->name.'</p>';
              }
              else
              {
                 echo '<p class="text-success"><strong>-&nbsp;ผู้ใช้งานระบบ</strong></p>';
              }
           }


        }
      }
      else
      {
         echo '<p class="text-success"><strong>-&nbsp;ผู้ใช้งานระบบ</strong></p>';
      }
      ?>

      </div>
    </div>






  </div><!-- /.box-body -->
  <div class="box-footer">
    <a href="{{route('users.index')}}" class="btn btn-md btn-default">
        <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
    </a>
    <?php
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
    {
    ?>
    <a href="{{action('UsersController@edit',$data->id)}}" class="btn btn-primary pull-right">
      <i class="fa fa-btn fa-edit"></i> {{trans('buttons.edit')}}
    </a>
    <?php
    }
    ?>
  </div>
</div><!-- /.box -->
@endsection
