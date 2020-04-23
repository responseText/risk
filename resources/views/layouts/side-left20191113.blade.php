<!-- Left side column. contains the logo and sidebar -->

 @if (!Auth::guest() )
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">



      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- <li class="header"><h5><strong>ผู้ดูแลระบบ</strong></h5></li> -->
        <li class="header text-white"><h5><strong>เมนูใช้งานระบบ</strong></h5></li>
      








        <?php
        if ( (Auth::user()->level_id == '1') || (Auth::user()->level_id == '2') || (Auth::user()->level_id == '3') )
        {
        ?>
        <li class="treeview menu-open">
          <a href="#" >
            <i class="fa fa-th"></i> <span>เมนูระบบ</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu"  style="display: block;" >
            <li><a href="{{route('typerisk.index')}}"><i class="fa fa-object-group"></i> ประเภทความเสี่ยง</a></li>
            <li><a href="{{route('violencelevel.index')}}"><i class="fa fa-circle-o"></i> ระดับความรุนแรง</a></li>
            <li><a href="{{route('violence.index')}}"><i class="fa fa-line-chart"></i> ความรุนแรง</a></li>
            <li><a href="{{route('riskprogram.index')}}"><i class="fa fa-external-link"></i> โปรแกรมความเสี่ยง</a></li>
            <li><a href="{{route('incidentgroup.index')}}"><i class="fa fa-puzzle-piece"></i> หมวดหมู่อุบัติการณ์ </a></li>
            <li><a href="{{route('incidentlist.index')}}"><i class="fa fa-bell-o"></i> อุบัติการณ์ </a></li>
            <li><a href="{{route('incidentcase.index')}}"><i class="fa  fa-flash"></i> โอกาสที่จะเกิดความเสี่ยง </a></li>
            <li><a href="{{route('effect.index')}}"><i class="fa  fa-street-view"></i> ผู้ได้รับผลกระทบ </a></li>
          </ul>
        </li>
        <?php
        }
        ?>








        <?php
        if ( Auth::user()->level_id == '1')
        {
        ?>

        <li class="treeview menu-open">
          <a href="#" >
            <i class="fa fa-th"></i> <span>เมนูใช้งาน - ผู้ดูแลระบบ</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu"  style="display: block;" >
            <?php
            if ( Auth::user()->level_id == '1')
            {
            ?>
            <li><a href="{{route('users.index')}}"><i class="fa fa-users"></i> ผู้ใช้งานระบบ</a></li>
            <?php
            }
            ?>
            <li><a href="{{route('employee.index')}}"><i class="fa fa-child"></i> เจ้าหน้าที่</a></li>

            <li><a href="{{route('division.index')}}"><i class="fa fa-cube"></i> กลุ่มงาน </a></li>
            <li><a href="{{route('subdivision.index')}}"><i class="fa  fa-odnoklassniki"></i> ฝ่าย </a></li>
            <li><a href="#"><i class="fa fa-graduation-cap"></i> หัวหน้างาน </a></li>
          </ul>
        </li>
      <?php
      }
      ?>

        <!-- <li class="header"><h5><strong>ผู้ใช้งานระบบ</strong></h5></li> -->
        <li class="treeview menu-open">
          <a href="#" >
            <i class="fa  fa-hand-pointer-o"></i> <span>เมนูใช้งาน - ผู้ใช้งานระบบ</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: block;" >

            <li><a href="{{route('incident.index')}}" data-toggle="tooltip" data-placement="top" title="อุบัติการณ์ความเสี่ยงของเรา"><i class="fa f fa-info"></i>อุบัติการณ์ความเสี่ยงของเรา</a></li>

            <li><a href="{{route('incident.create')}}" data-toggle="tooltip" data-placement="top" title="เขียนความเสี่ยง"><i class="fa fa-pencil-square-o"></i>เขียนความเสี่ยง</a></li>

          </ul>
        </li>
        <?php
        //if ( Auth::user()->level_id == '3')
        //{
        ?>
        <?php
        if ( (Auth::user()->level_id == '1') || (Auth::user()->level_id == '2') || (Auth::user()->level_id == '3') )
        {
        ?>
        <li class="treeview menu-open">
          <a href="#" >
            <i class="fa fa-th"></i> <span>เมนูใช้งาน - กรรมการความเสี่ยง</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: block;" >
              <li>
                <a href="{{route('headrmremove.index')}}" data-toggle="tooltip" data-placement="top" title="ความเสี่ยงที่ถูกเขียนเข้ามาใหม่"><i class="fa fa-th-list"></i>
                  <span>ความเสี่ยงมาใหม่</span>
                   @if(get_count_newriskForHeadRM( Auth::user() ) > 0 )
                  <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">ใหม่ {{get_count_newriskForHeadRM( Auth::user() )}} </small>

                  </span>
                  @endif
                </a>
              </li>
              <li>
                <a href="{{route('headrmreview.index')}}" data-toggle="tooltip" data-placement="top" title="ความเสี่ยงจากหัวหน้างาน"><i class="fa fa-graduation-cap"></i> ความเสี่ยงจากหัวหน้างาน
                  <?php
                  if( get_AlereRMstep2( Auth::user() ) > 0 )
                  {
                  ?>
                  <span class="pull-right-container">
                   <small class="label pull-right bg-yellow">ใหม่ {{get_AlereRMstep2( Auth::user() )}} </small>

                  </span>
                  <?php
                  }
                  ?>
                </a>
              </li>

              <li>
                <a href="{{route('headrmsendback.index')}}" data-toggle="tooltip" data-placement="top" title="ความเสี่ยงส่งคืนจากหัวหน้ากลุ่มงาน">
                  <i class="fa fa-th-list"></i>
                  <span>ความเสี่ยงส่งคืน-หัวหน้างาน</span>
                   @if(get_count_riskSendbackFromHeadDivision( Auth::user() ) > 0 )
                  <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">ใหม่ {{get_count_riskSendbackFromHeadDivision( Auth::user() )}} </small>

                  </span>
                  @endif
                </a>
              </li>

              <li>
                <a href="{{route('headrmlistall.index')}}" data-toggle="tooltip" data-placement="top" title="ความเสี่ยงทั้งหมด"><i class="fa fa-database"></i> ความเสี่ยงทั้งหมด



                </a>
              </li>

          </ul>
        </li>
        <?php
        }
        ?>
        <?php
        //}
        ?>
        <?php
        if ( (Auth::user()->level_id == '1') || (Auth::user()->level_id == '2') || (Auth::user()->level_id == '4'))
        {
        ?>
        <li class="treeview menu-open">
          <a href="#" >
            <i class="fa fa-th"></i> <span>เมนูใช้งาน - หัวหน้ากลุ่มงาน</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: block;" >
              <li>
              <a href="{{route('headdivisionreview.index')}}" data-toggle="tooltip" data-placement="top" title="ความเสี่ยงมาใหม่"><i class="fa fa-th-list"></i> <span>ความเสี่ยงมาใหม่</span>
                <?php
                if( get_count_newriskForHeadDivision( Auth::user() ) > 0 )
                {
                ?>
                <span class="pull-right-container">
                 <small class="label pull-right bg-yellow">ใหม่ {{get_count_newriskForHeadDivision( Auth::user() )}} </small>

                </span>
                <?php
                }
                ?>
              </a>
            </li>
             <li>
               <a href="{{route('headdivisionreview.list')}}" data-toggle="tooltip" data-placement="top" title="ความเสี่ยงของหน่วยงาน">
                 <i class="fa fa-tasks"></i> ความเสี่ยงของหน่วยงาน
               </a>
             </li>
			       <li>
               <a href="{{route('usersindepreport.index')}}" data-toggle="tooltip" data-placement="top" title="ความเสี่ยงโดยเจ้าหน้าทีฝ่าย">
                 <i class="fa fa-tasks"></i> ความเสี่ยงโดยเจ้าหน้าทีฝ่าย
               </a>
             </li>
		  </ul>
        </li>


        <?php
        }
        ?>
        <?php
        if ( (Auth::user()->level_id == '1') || (Auth::user()->level_id == '2') || (Auth::user()->level_id == '5'))
        {
        ?>
        <li class="treeview menu-open">
          <a href="#" >
            <i class="fa fa-th"></i> <span>เมนูใช้งาน - หัวหน้าหน่วยงาน</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: block;" >
              <li>
              <a href="{{route('headsubdivisionreview.index')}}"  data-toggle="tooltip" data-placement="top" title="มีความเสี่ยงใหม่">
                <i class="fa fa-th-list"></i> <span>มีความเสี่ยงใหม่</span>
                <?php
                if( get_count_newriskForHeadSubDivision( Auth::user() ) > 0 )
                {
                ?>
                <span class="pull-right-container">
                 <small class="label pull-right bg-yellow">ใหม่ {{get_count_newriskForHeadSubDivision( Auth::user() )}} </small>

                </span>
                <?php
                }
                ?>
              </a>
            </li>
              <li><a href="{{route('headsubdivisionreview.list')}}" data-toggle="tooltip" data-placement="top" title="ความเสี่ยงของหน่วยงาน">
                <i class="fa fa-tasks"></i> ความเสี่ยงของหน่วยงาน</a>
              </li>
			        <li><a href="{{route('usersinsubdivisionreport.index')}}" data-toggle="tooltip" data-placement="top" title="ความเสี่ยงเจ้าหน้าที่หน่วยงาน">
                <i class="fa fa-tasks"></i> ความเสี่ยงเจ้าหน้าที่หน่วยงาน</a>
              </li>>
          </ul>
        </li>


        <?php
        }
        ?>
		 <?php
     /*
        if ( (Auth::user()->level_id == '1') || (Auth::user()->level_id == '2')
				|| (Auth::user()->level_id == '3') || (Auth::user()->level_id == '4') || (Auth::user()->level_id == '5')
			)
        {
        */
        ?>
		<li>
          <a href="{{route('reports.index')}}" data-toggle="tooltip" data-placement="top" title="รายงาน" >
          <i class="fa fa-pie-chart menu-open"></i> <span>รายงาน</span>
          </a>
        </li>

		<?php
		//}
		?>

        <?php
        //if ( Auth::user()->level_id == '4')
        //{
        ?>
		<!--
        <li>
          <a href="{{route('reports.index')}}">
          <i class="fa fa-pie-chart menu-open"></i> <span>รายงาน</span>
          </a>
        </li>
		-->




      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <script>

  </script>
  @endif
