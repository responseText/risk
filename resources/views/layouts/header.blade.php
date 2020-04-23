@if (!Auth::guest())
<div class="modal modal-default fade" id="modal-profile-global">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">รูปโปรไฟล์</h4>
              </div>
              <div class="modal-body">

                <?php


                if(empty(Auth::user()->images_profile) || Auth::user()->images_profile=='' )
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
                  $dir = asset('/uploads/images/profile');
                ?>
                <p class="text-center"><img src="<?=$dir.'/'.Auth::user()->images_profile?>" width="90%" class="img-circle" > </p>
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

<!-- End Img Profile global -->
  @endif
<header class="main-header">
    <!-- Logo -->
    <a href="{{route('index')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>R</b>ISK</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b class="text-red">Risk</b>TSK</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          @if (Auth::guest())
    				<li><a href="{{ url('/login') }}">เข้าสู่ระบบ</a></li>
    				<!-- <li><a href="{{ url('/register') }}">Register</a></li> -->
    			@else




          <!-- Notifications: style can be found in dropdown.less -->


          <?php
          $newriskForHeadRM=0;
          $headDivisionAlert =0;
          $headSubDivisionAlert =0;
          $rmsendBackFromHeadDivisionAlert =0;
          $headRMAlert=0;

          $AlereRMstep2=0;
          $AlereRMNoAnswer=0;




          $allmsg=0;

          $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
          // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
          if(count(Auth::user()->user_level) > 0 )
          {
            foreach( Auth::user()->user_level as $kk => $vv)
            {
              $arr_user_level[]=$vv->level_id;
            }
          }
          /*
          if( ( Auth::user()->level_id == 1) || ( Auth::user()->level_id == 2) ||
          (Auth::user()->level_id == 4)
          )
          */
          if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('4',$arr_user_level))
          {
            if( get_count_newriskForHeadDivision( Auth::user() ) > 0 )
            {
              $headDivisionAlert = get_count_newriskForHeadDivision( Auth::user() ) ;
            }
          }

          //-------------------------------------------------------------------------------
/*
          if( ( Auth::user()->level_id == 1) || ( Auth::user()->level_id == 2) ||
          (Auth::user()->level_id == 5)
          )
          */
          if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('5',$arr_user_level))
          {
            if( get_count_newriskForHeadSubDivision( Auth::user() ) > 0 )
            {
              $headSubDivisionAlert = get_count_newriskForHeadSubDivision( Auth::user() ) ;
            }
          }
          //-------------------------------------------------------------------------------
          /*
          if( ( Auth::user()->level_id == 1) || ( Auth::user()->level_id == 2) ||
          (Auth::user()->level_id == 3)
          )
          */
          if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level))
          {
            if( get_count_newriskForHeadRM( Auth::user() ) > 0 ){
              $newriskForHeadRM = get_count_newriskForHeadRM( Auth::user() );
            }
            if( get_AlereRMstep2(Auth::user() ) > 0 )
            {
              $AlereRMstep2 = get_AlereRMstep2(Auth::user()) ;
            }

            if( get_count_riskSendbackFromHeadDivision( Auth::user() ) > 0 ){
              $rmsendBackFromHeadDivisionAlert = get_count_riskSendbackFromHeadDivision( Auth::user() );
            }
            if( get_AlereRMNoAnswer( Auth::user() ) > 0 ){
              $AlereRMNoAnswer = get_AlereRMNoAnswer( Auth::user() );
            }







          }
          /*
          if( ( Auth::user()->level_id == 1) || ( Auth::user()->level_id == 2) ||
          (Auth::user()->level_id == 7)
          )
          */







          $allmsg=  $allmsg+$newriskForHeadRM+$headDivisionAlert+$headSubDivisionAlert+$headRMAlert+$AlereRMstep2+$rmsendBackFromHeadDivisionAlert+$AlereRMNoAnswer;

          ?>
          <li class="dropdown notifications-menu">

            @if( $allmsg > 0 )

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell"></i>
              <span class="label label-warning">
                {{$allmsg}}
              </span>
            </a>
            <ul class="dropdown-menu">

              <li class="header">คุณมีการแจ้งเตือน {{$allmsg}} รายการ</li>

              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @if( get_count_newriskForHeadDivision( Auth::user() ) > 0 )
                  <li>
                    <a href="{{route('headdivisionreview.index')}}">
                      <i class="fa fa-bell text-aqua"></i> {{$headDivisionAlert}} ความเสี่ยงที่เกี่ยวข้องกับหน่วยงานของเรา
                    </a>
                  </li>
                  @endif
                  @if( get_count_newriskForHeadSubDivision( Auth::user() ) > 0 )
                  <li>
                    <a href="{{route('headsubdivisionreview.index')}}" class="text-orange">
                      <i class="fa fa-bell text-orange"></i> {{$headSubDivisionAlert}} ความเสี่ยงที่เกี่ยวข้องกับหน่วยงาน
                    </a>
                  </li>
                  @endif
                  @if( get_count_newriskForHeadRM( Auth::user() ) > 0 )
                  <li>
                    <a href="{{route('headrmremove.index')}}">
                      <i class="fa fa-warning text-red"> </i> มีความเสี่ยงเข้ามาในระบบ {{get_count_newriskForHeadRM( Auth::user() )}} รายการ
                    </a>
                  </li>
                  @endif
                  <?php
                  //if( Auth::user()->level_id =='1' || Auth::user()->level_id =='2' || Auth::user()->level_id =='3')
                  if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level))
                  {
                  ?>
                  @if( get_AlereRMstep2( Auth::user() ) > 0 )
                  <li class="text-danger">
                    <a href="{{route('headrmreview.index')}}" >
                      <i class="fa fa-volume-up text-orange"></i>ความเสี่ยง {{ get_AlereRMstep2( Auth::user() )  }} รายการ  ที่ถูกหัวหน้างานที่รับผิดชอบได้ตอบความเสี่ยงส่งเข้ามาในระบบ
                    </a>
                  </li>
                  @endif
                  @if( get_AlereRMNoAnswer( Auth::user() ) > 0 )
                  <li>
                    <a href="{{route('headdivisionnoanswer.index')}}"  class="text-info">
                      <i class="fa  fa-user-secret text-red"></i>ความเสี่ยง {{ get_AlereRMNoAnswer( Auth::user() )  }} รายการ  ที่หัวหน้างานยังไม่ตอบ
                    </a>
                  </li>
                  @endif
                  <?php
                  }
                  ?>







                </ul>
              </li>
              <li class="footer"></li>
            </ul>
            @endif
          </li>





          <!-- Tasks: style can be found in dropdown.less -->

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <?php
            if (Auth::check()) {
            ?>

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php
              if(empty(Auth::user()->images_profile))
              {
              ?>
                  <?php
                  if(Auth::user()->employee->prefix->id == '1')
                  {
                  ?>
                  <img src="{{asset('/AdminLTE-2.4.5/dist/img/user2-160x160.jpg')}}" class="user-image rounded-circle border border-white" alt="User Image">
                  <?php
                  }
                  else
                  {
                  ?>
                  <img src="{{asset('/AdminLTE-2.4.5/dist/img/user4-128x128.jpg')}}" class="user-image rounded-circle" alt="User Image">
                  <?php
                  }
                  ?>
              <?php
              }
              else
              {

                  $dir = asset('/uploads/images/profile');

              ?>



              <img src="<?=$dir.'/'.Auth::user()->images_profile?>" class="user-image rounded-circle" alt="User Image">

              <?php
              }
              ?>

              <span class="hidden-xs">{{ Auth::user()->employee->fname.'  '.Auth::user()->employee->lname}}</span>
            </a>
            <?php
            }
            else
            {
            ?>
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            <?php
            }
            ?>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php

                if(empty(Auth::user()->images_profile))
                {
                    if(Auth::user()->employee->prefix->id == '1')
                    {
                    ?>
                     <img src="{{asset('/AdminLTE-2.4.5/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">

                    <?php
                    }
                    else
                    {
                    ?>
                     <img src="{{asset('/AdminLTE-2.4.5/dist/img/user4-128x128.jpg')}}" class="img-circle" alt="User Image">

                    <?php
                    }
                }
                else
                {


                  $dir = asset('/uploads/images/profile');
                ?>
                <style media="screen">
                  .navbar-nav>.user-menu>.dropdown-menu>li.user-header>a
                  {
                    z-index: 5;
                    height: 90px;
                    width: 90px;

                    /*border-color: transparent;*/
                    border-radius: 50%;
                    /*border-color: rgba(255,255,255,0.2);*/



                  }
                  .navbar-nav>.user-menu>.dropdown-menu>li.user-header>a>img
                  {
                    /*z-index: 5;*/
                    height: 90px;
                    width: 90px;
                    border: 3px solid;

                    border-color: transparent;
                    border-color: rgba(255,255,255,0.2);

                      text-align: center;

margin: auto  ;

                  }
.navbar-nav>.user-menu>.dropdown-menu>li.user-header>a {
    /*
    height: 90px;
    padding: 90px;
    */
    text-align: center;
    margin: auto  auto;
}

                </style>
                <!-- <a href="javascript:void(0)," data-toggle="modal" data-target="#modal-profile-global" > -->
                <a href="javascript:void(0)," data-toggle="modal" data-target="#modal-profile-global" >
                <img src="<?=$dir.'/'.Auth::user()->images_profile?>" class="img-circle" alt="User Image">
              <!--  </a> -->
              </a>

                <?php
                }
                ?>



                <?php
                if (Auth::check()) {
                ?>
                <p >

                {{ Auth::user()->employee->fname.'  '.Auth::user()->employee->lname}}
                </p>
                <small style="color:#FFFFFF;">
                  <?php

                  $arr_position =array();
                  for($i=0;$i< count(Auth::user()->user_level) ;$i++)
                  {
                    $arr_position[]=Auth::user()->user_level[$i]->get_level_access[0]->name;
                    //$arr_position[]=Auth::user()->user_level[$i]->get_level_access[0]
                  }
                  $result = array_unique($arr_position);
                  //echo implode(" , ",$result);
                  if( count($result) > 0 )
                  {
                    echo implode(" , ", $result) ;
                  }
                  else
                  {
                    echo "ผู้ใช้งานระบบทั่วไป";
                  }

                  ?>

                  <?php

                  //echo Auth::user()->employee->position
                //  echo  Auth::user()->level_access->name;
              //  print_r( Auth::user()->user_level )
                  /*
                    if (Auth::user()->employee->position_id == 0)
                    {
                      echo 'ผู้ดูแลระบบสูงสุด';

                    }
                    else
                    {
                      echo Auth::user()->employee->position->name;
                    }
                    */

                  ?>


                </small>



                </p>
                <?php
                }
                ?>


              </li>
              <!-- Menu Body -->
              <li class="user-body">

                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('users.show1',Auth::user()->id)}}" class="btn btn-default btn-flat">ข้อมูลผู้ใช้งานระบบ</a>
                </div>
                <div class="pull-right">
                  <a href="javascript:void(0);" class="btn btn-default btn-flat" onclick="$('#logout-form').submit();">ออกจากระบบ</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    <input type="hidden" name="_method" value="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    </form>
                </div>
              </li>
            </ul>
          </li>
          @endif
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>
