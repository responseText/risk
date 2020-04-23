@extends('layouts.page')
@section('title','อุบัติการณ์ความเสี่ยง ' )
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
<style media="screen">
  .e5{
    padding:2px 10px 2px 10px;
  }
</style>

<div class="row">
  <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    @if(Session::has('message'))
    <div class="alert alert-success" role="alert">
    {{ Session::get('message') }}
    </div>
    @endif
  </div>

</div>

<div class="box">
  <div class="box-header">
    <h3 class="box-title"> <?php echo trans('buttons.info');?>ความเสี่ยงของหน่วยงานที่ได้รับ :  <?php echo $data->division->name?>
    </h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">

    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php
        $color='';

        if(empty($data->headrm_sendto_headdivision_status) && empty($data->headdivision_receive_status) && empty($data->headrm_review_status))
        {
          $color ='warning';
        }
        else if($data->headrm_sendto_headdivision_status=='Y' && empty($data->headdivision_receive_status) && empty($data->headrm_review_status))
        {
          $color ='warning';
        }
        else if($data->headrm_sendto_headdivision_status=='sendback' && empty($data->headdivision_receive_status) && empty($data->headrm_review_status))
        {
          $color ='warning';
        }
        else if($data->headrm_sendto_headdivision_status=='Y' && $data->headdivision_receive_status=='Y' && empty($data->headrm_review_status))
        {
          $color ='info';
        }
        else if($data->headrm_sendto_headdivision_status=='Y' && $data->headdivision_receive_status=='Y' && $data->headrm_review_status=='Y')
        {
          $color ='success';
        }

        ?>
        <div class="callout callout-<?=$color?>">
           <h4>สถานะของความเสี่ยงนี้</h4>

           <p>
             <?php

            if(empty($data->headrm_sendto_headdivision_status) && empty($data->headdivision_receive_status) && empty($data->headrm_review_status))
            {
              echo '&nbsp;<i class="fa  fa-hourglass-1"></i>&nbsp;&nbsp;รอกรรมการ RM รับ';
            }
            else if($data->headrm_sendto_headdivision_status=='sendback' && empty($data->headdivision_receive_status) && empty($data->headrm_review_status))
            {
              echo '&nbsp;<i class="fa fa-hourglass-half"></i>&nbsp;&nbsp;รอคณะกรรมการความเสี่ยงทบทวน แล้วส่งความเสี่ยงให้กลุ่มงานที่รับผิดชอบ';
            }
            else if($data->headrm_sendto_headdivision_status=='Y' && empty($data->headdivision_receive_status) && empty($data->headrm_review_status))
            {
              echo '&nbsp;<i class="fa fa-hourglass-half"></i>&nbsp;&nbsp;รอหัวหน้ากลุ่มงานทบทวน';
            }
            else if($data->headrm_sendto_headdivision_status=='Y' && $data->headdivision_receive_status=='Y' && empty($data->headrm_review_status))
            {
              echo '&nbsp;<i class="fa fa-hourglass-o"></i>&nbsp;รอคณะกรรม RM ทบทวน';
            }
            else if($data->headrm_sendto_headdivision_status=='Y' && $data->headdivision_receive_status=='Y' && $data->headrm_review_status=='Y')
            {
              echo '&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;คณะกรรม RM ประเมินแล้ว';
            }
            ?>

           </p>
        </div>
      </div>
    </div>

      <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">รายละเอียดความเสี่ยงของหน่วยงานที่ได้รับ</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">



              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>วันที่เกิดเหตุ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">
                    <?php echo long_th_date($data->incident_date);?>&nbsp;
                    เวลา&nbsp;<?php echo showTime($data->incident_time);?>&nbsp;น.
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>กลุ่มงานที่รับผิดชอบ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">
                  <p class="text-muted">
                    <?php echo $data->division->name?>&nbsp;
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>หน่วยงานที่รับผิดชอบ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">
                  <p class="text-muted">
                    <?php echo $data->subdivision->name?>&nbsp;
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>หมวดหมู่อุบัติการณ์</strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">
                  <p class="text-muted">
                    <?php echo $data->incident_group->name?>&nbsp;
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>รายการอุบัติการณ์</strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">
                  <p class="text-muted">
                    <?php
                    if( $data->incident_list_id=='' )
                    {
                      echo '-';
                    }
                    else
                    {
                      if( $data->incident_list_id== '' )
                      {
                        echo '-';
                      }
                      else
                      {
                        if(empty($data->incident_list->id))
                        {
                          echo '<strong class="bg-red">*** รายการนี้ถูกลบออกจากระบบ ***</strong>' ;
                        }
                        else
                        {
                          echo $data->incident_list->name;
                        }
                      }
                    }
                    ?>
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>ประเภทความเสี่ยง</strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">
                  <p class="text-muted">
                    <?php echo $data->typerisk->name?>&nbsp;
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>ระดับความรุนแรง</strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">
                  <p class="text-muted">
                    <?php echo $data->violence->code.'  :  '.$data->violence->name?>&nbsp;
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>เกิดขึ้นกับ</strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">
                  <p class="text-muted">
                    <?php echo $data->effect->name?>&nbsp;
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>ผู้พบเห็น</strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">
                  <p class="text-muted">
                    <?php
					if(empty($data->employee->fname))
                  {
                    echo '<span class="bg-red">ผู้เห็นเหตุการณ์นี้ถูกลบออกจากระบบ</span>';
                  }
                  else
                  {
                    echo $data->employee->prefix->name.$data->employee->fname.'   '.$data->employee->lname;
                  }

					//echo $data->employee->prefix->name.$data->employee->fname.'  '.$data->employee->lname
					?>&nbsp;
                  </p>
                </div>
              </div>

              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>สถานที่เกิดเหตุ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">
                    <?php  if( $data->incident_place !='' ){ echo $data->incident_place; }else{ echo '-'; }?>

                  </p>
                </div>
              </div>

              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>ชื่อเหตุการณ์ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">

                    <?php
                    if( $data->incident_title !='' )
                    {
                      echo $data->incident_title;
                    }
                    else
                    {
                      echo '-';
                    }
                    ?>
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>เหตุการณ์ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">

                    <?php
                    if( $data->incident_event !='' )
                    {
                      echo $data->incident_event;
                    }
                    else
                    {
                      echo '-';
                    }
                    ?>
                  </p>
                </div>
              </div>

              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>การแก้ไขเบื้องต้น </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">
                    <?php
                    if( $data->incident_edit !='' )
                    {
                      echo $data->incident_edit;
                    }else{
                      echo '-';
                    }
                    ?>
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>ข้อเสนอแนะ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">
                    <?php
                    if( $data->incident_propersal !='' )
                    {
                      echo $data->incident_propersal;
                    }else{
                      echo '-';
                    }
                    ?>
                  </p>
                </div>
              </div>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>Near Miss และ Sentinel Event</strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">



                  <?php
                  if(empty($data->incident_case_id)){ echo '&nbsp;-&nbsp;';}
                  $ab = explode(",",$data->incident_case_id);
                   foreach ( $rs_incidentcase as $k => $row )
                   {
                  ?>


                          <?php
                          if($k==0){
                            if($ab[0]=='1')
                            {
                              echo '<p class="text-muted">'.$row->name.'</p>';
                            }
                          }
                          else
                          {
                              if(isset( $ab[0]) )
                              {
                                if($ab[0]=='2')
                                {
                                    echo '<p class="text-muted">'.$row->name.'</p>';
                                }
                              }
                              if(isset( $ab[1]))
                              {
                                if($ab[1]=='2')
                                {
                                  echo '<p class="text-muted">'.$row->name.'</p>';
                                }
                              }
                          }

                          ?>



                  <?php
                   }
                  ?>
                </div>
              </div>

              <?php
              //if( Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
              if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
              {
              ?>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>ผู้เขียน </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">
                    <?php
                    echo $data->writeByID->employee->prefix->name.$data->writeByID->employee->fname.'  '.$data->writeByID->employee->lname;
                    ?>&nbsp;&nbsp;&nbsp;
                    <i class="alert-danger">&nbsp;&nbsp;&nbsp;*** เห็นได้เฉพาะผู้ดูแลระบบ ***&nbsp;&nbsp;&nbsp;</i>
                  </p>
                </div>
              </div>
              <?php
              }
              ?>



            </div>
          </div>
        </div>
      </div><!-- .row  -->



<?php
if($data->headrm_sendto_headdivision_status =='Y')
{
?>
      <?php
      if($data->headrm_sendto_headdivision_status =='Y' && $data->headdivision_receive_status =='Y')
      {
      ?>

      <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
          <div class="box box-info box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">ความคิดเห็นของหน่วยหน้ากลุ่มงาน</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>การแก้ไข </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">

                    <?php
                    if( $data->headdivision_edit !='' )
                    {
                      echo $data->headdivision_edit;
                    }
                    else
                    {
                      echo '-';
                    }
                    ?>
                  </p>
                </div>
              </div>


              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>ข้อเสนอแนะ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">

                    <?php
                    if( $data->headdivision_propersal !='' )
                    {
                      echo $data->headdivision_propersal ;
                    }
                    else
                    {
                      echo '-';
                    }
                    ?>
                  </p>
                </div>
              </div>


            </div> <!-- box-body -->

          </div><!-- box  -->
        </div>
      </div>
      <?php
      }
      ?>



      <?php
      if($data->headrm_sendto_headdivision_status =='Y' && $data->headdivision_receive_status =='Y' && $data->headrm_review_status =='Y')
      {
      ?>

      <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
          <div class="box box-warning box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">ความคิดเห็นของคณะกรรมการความเสี่ยง</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <div class="form-group">

                  <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                  <strong>การแก้ไข </strong>
                  </div>
                  <div class="col-lg-8 col-md-9 col-sm-6 col-xs-12">
                    <p class="text-muted">
                      <?php
                      if ($data->headrm_review_edit !='')
                      {
                        echo $data->headrm_review_edit;
                      }
                      else
                      {
                        echo '-';
                      }
                      ?>
                    </p>

                  </div>
              </div>
              <div class="form-group">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>ข้อเสนอแนะ </strong>
                </div>

                  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                    <p class="text-muted">
                      <?php
                      if ($data->headrm_review_propersal !='')
                      {
                        echo $data->headrm_review_propersal;
                      }
                      else
                      {
                        echo '-';
                      }
                      ?>
                    </p>

                  </div>
              </div>


              <div class="form-group  {{ $errors->has('evaluation') ? ' has-error' : '' }}">

                  <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                  <strong>การประเมินผลของคณะกรรมการ </strong>
                  </div>
                  <div class="col-lg-8 col-md-9 col-sm-6 col-xs-12">

                      <?php
                      if($data->incident_status_id !='')
                      {
                        switch ($data->incident_status_id) {
                          case '1' : echo '<p class="text-red"><i class="fa fa-thumbs-down"></i>&nbsp;'.$data->evaluation->name.'</p>';break;
                          case '2' : echo '<p class="text-aqua"><i class="fa fa-refresh"></i>&nbsp;'.$data->evaluation->name.'</p>';break;
                          case '3' : echo '<p class="text-green "><i class="fa fa-check"></i>&nbsp;'.$data->evaluation->name.'</p>';break;
                          default: echo '<p class="text-mute"><i class="fa fa-refresh"></i>&nbsp;'.$data->evaluation->name.'</p>';break;
                        }

                      }
                      else
                      {
                        echo '-';
                      }
                      ?>
                    </p>

                </div>
              </div>







            </div> <!-- box-body -->

          </div>

        </div>
      </div>
      <?php
      }
      ?>
<?php
}
?>


    </div> <!-- .box-body  -->
    <div class="box-footer">
    <?php
      if($data->headrm_sendto_headdivision_status=='Y' && $data->headdivision_receive_status!='Y' )
      {

      ?>
       <a href="#" data-toggle="modal" data-target="#exampleModalCallBack" class="btn btn-block btn-warning"><strong>เรียกคืนความเสี่ยง<?=$data->headdivision_receive_status?></strong></a>
      <?php
      }
      ?>
      <a href="{{route('headrmlistall.index')}}" class="btn btn-default btn-block"><strong>{{trans('buttons.back')}}</strong></a>

    </div>


</div><!-- /.box -->



<div class="modal fade" id="exampleModalCallBack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content  ">
      <div class="modal-header alert-warning">
        <h4 class="modal-title" id="exampleModalLabel">คุณต้องการเรียกคืนความเสี่ยงใช่หรือไม่</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
    <h4>คุณต้องการจะเรียกคืนความเสี่ยง  เพื่อทำการส่งความเสี่ยงไปให้หน่วยงานที่รับผิดชอบที่ถูกต้องหรือไม่</h4>
      </div>
      <div class="modal-footer">
        <form id="myFormCallback" action="{{route('headrmlistall.callbackrm')}}" method="post">
          <input type="hidden" name="_method" value="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" id="js_id" name="js_id" value="<?=$data->id?>">


        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="submit" class="btn btn-primary">ตกลง</button>
        </form>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
$(function(){
 $('.select2').select2();
});
</script>
@endsection
