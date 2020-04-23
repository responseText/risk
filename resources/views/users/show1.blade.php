@extends('layouts.page')
@section('title','รายละเอียดผู้ใช้งานระบบ' )
@section('content')
@include('layouts/function')

<script src="{{asset('dropzonejs/dist/dropzone.js')}}"></script>
<link rel="stylesheet" href="{{asset('dropzonejs/dist/dropzone.css')}}">
<!-- <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script> -->
<!--< link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">-->



<div class="modal modal-default fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">รูปโปรไฟล์</h4>
              </div>
              <div class="modal-body">
                <?php
                if(empty($data->images_profile))
                {
                  if(Auth::user()->employee->prefix->id == '1')
                  {
                  ?>
                  <img class="profile-user-img img-responsive img-circle" src="{{asset('/AdminLTE-2.4.5/dist/img/user2-160x160.jpg')}}" alt="User profile picture">


                  <?php
                  }
                  else
                  {
                  ?>
                  <img class="profile-user-img img-responsive img-circle" src="{{asset('/AdminLTE-2.4.5/dist/img/user4-128x128.jpg')}}" alt="User profile picture">

                  <?php

                  }
                }
                else
                {
                  $dir = '../../uploads/images/profile';
                ?>
                <p class="text-center"><img src="<?=$dir.'/'.Auth::user()->images_profile?>" width="80%" > </p>
                <?php
                }
                ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">




    <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

              <a href="javascript:void(0)," data-toggle="modal" data-target="#modal-default">
              <?php
              if(empty($data->images_profile))
              {
                if(Auth::user()->employee->prefix->id == '1')
                {
                ?>
                <img class="profile-user-img img-responsive img-circle" src="{{asset('/AdminLTE-2.4.5/dist/img/user2-160x160.jpg')}}" alt="User profile picture">


                <?php
                }
                else
                {
                ?>
                <img class="profile-user-img img-responsive img-circle" src="{{asset('/AdminLTE-2.4.5/dist/img/user4-128x128.jpg')}}" alt="User profile picture">

                <?php

                }
              }
              else
              {
                $dir = '../../uploads/images/profile';
                ?>
                <img class="profile-user-img img-responsive img-circle" src="<?=$dir?>/<?=Auth::user()->images_profile?>" alt="User profile picture">
              <?php
              }
              ?>
              </a>
              <?php
              //if( Auth::user()->level_id==1 ||   Auth::user()->level_id==2 )
              //{
              ?>
              <p class="text-muted text-center" style="padding:10px 0px 10px 0px;">
                  <a href="{{route('users.uploadimageprompt',$data->id)}}" class="btn btn-success">
                    <strong>อัพโหลดรูป</strong>
                    <!-- <img src="{{asset('images/img_logo.png')}}" alt="">  -->
                  </a>
              </p>
              <?php
              //}
              ?>

              <h3 class="profile-username text-center"><?php echo $data->employee->prefix->name.$data->employee->fname.'   '.$data->employee->lname;?></h3>

              <p class="text-muted text-center">
                <?php
                $arr_position =array();
                for($i=0;$i< count(Auth::user()->user_level) ;$i++)
                {
                  $arr_position[]=Auth::user()->user_level[$i]->get_level_access[0]->name;
                }
                $result = array_unique($arr_position);
              //  echo implode(" , ",$result);


                if( count($result) > 0 )
                {
                  echo implode(" , ", $result) ;
                }
                else
                {
                  echo "ผู้ใช้งานระบบทั่วไป";
                }

                ?>
              </p>
              
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">

                      <!-- About Me Box -->
                                <div class="box ">
                                  <div class="box-header with-border">
                                    <h3 class="box-title">เกี่ยวกับ</h3>
                                  </div>
                                  <!-- /.box-header -->
                                  <div class="box-body">
                                    <strong><i class="fa fa-book margin-r-5"></i> กลุ่มงาน</strong>

                                    <p class="text-muted">
                                      <?php echo $data->employee->division->name;?>
                                    </p>

                                    <hr>

                                    <strong><i class="fa fa-map-marker margin-r-5"></i> หน่วยงาน</strong>

                                    <p class="text-muted"><?php echo $data->employee->subdivision->name;?></p>

                                    <hr>
                                    <strong><i class="fa fa-map-marker margin-r-5"></i> ตำแหน่งงาน</strong>

                                    <p class="text-muted"><?php echo $data->employee->position->name;?></p>

                                    <hr>



                </div>
              </div>




              <a href="{{action('UsersController@changepassword',$data->id)}}" class="btn btn-primary btn-block"><b>แก้ไข</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

  </div>
</div>













<script type="text/javascript">
var myDropzone = new Dropzone("div#myId", { url: "users.uploadimage"});


@endsection
