@extends('layouts.page')
@section('title','อุบัติการณ์ความเสี่ยง ' )
@section('content')
@include('layouts/function')
<style media="screen">
#printarea * {display:bolck;}

</style>
<div class="box" id="printarea">
  <div class="box-header">
    <h3 class="box-title"> <?php echo trans('buttons.info');?>อุบัติการณ์ความเสี่ยง  </h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">



      <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="box box-warning box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">ข้อมูลความเสี่ยง</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>วันที่เกิดเหตุ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">
                    <?php
                    if( $data->incident_date=='0000-00-00')
                    {
                      echo '0000-00-00';
                    }
                    else
                    {
                      echo long_th_date($data->incident_date);
                    }
                    //echo long_th_date($data->incident_date);?>&nbsp;
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
                    <?php echo $data->violence->name?>&nbsp;
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
                    ?>
                    <?php //echo $data->employee->prefix->name.$data->employee->fname.'  '.$data->employee->lname?>&nbsp;
                  </p>
                </div>
              </div>
              <?php
              if( Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
              {
              ?>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>ผู้เขียน</strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">
                  <p class="text-muted">
                    <?php
                    echo $data->writeByID->employee->prefix->name.$data->writeByID->employee->fname.'  '.$data->writeByID->employee->lname;
                    ?>
                    <strong class="bg-red">  ***  เห็นได้เฉพาะผู้ดูแลระบบ  ***  </strong>
                  </p>
                </div>
              </div>
              <?php
              }
              ?>
              <?php
              if( Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
              {
              ?>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12  col-label-show " >
                <strong>เขียนเมื่อ</strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-8 col-xs-12">
                  <p class="text-muted">
                    <?php
                    if(!empty($data->created_at) || $data->created_at !='')
                    {
                      $datewrite = explode(" ", $data->created_at);
                      echo  short_th_date( $datewrite[0] ).' '.$datewrite[1].' น.';
                    }
                    else
                    {
                      echo '-';
                    }

                    ?>
                    <strong class="bg-red">  ***  เห็นได้เฉพาะผู้ดูแลระบบ  ***  </strong>
                  </p>
                </div>
              </div>
              <?php
              }
              ?>










            </div>
          </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="box box-warning box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">เหตุการณ์ - การแก้ไข - ข้อเสนอแนะ</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>ชื่อเหตุการณ์ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">
                    <?php  if( $data->incident_title !='' ){ echo $data->incident_title; }else{ echo '-'; }?>

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
                      echo  $data->incident_propersal;
                    }else{
                      echo '-';
                    }
                    ?>
                  </p>
                </div>
              </div>




            </div>
          </div>
        </div>


      </div><!-- .row  -->




      <div class="row">
        <?php
        if( $data->headrm_sendto_headdivision_status =="Y" && $data->headdivision_receive_status =="Y" &&  $data->headdivision_edit !="")
        {
        ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="box box-info box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">การแก้ไข - ข้อเสนอแนะ : หัวหน้ากลุ่มมงาน</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>การแก้ไข</dt>
                <dd><?php echo $data->headdivision_edit; ?></dd>
                <dt>ข้อเสนอแนะ</dt>
                <dd><?php echo $data->headdivision_propersal; ?></dd>

              </dl>
            </div>
          </div>
        </div>
        <?php

        }
        ?>
        <?php
          if( $data->headrm_sendto_headdivision_status =="Y" && $data->headdivision_receive_status =="Y"
            &&  $data->headrm_review_status =="Y"    &&  $data->headrm_review_edit !="")
          {
          ?>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="box box-success box-solid">
              <div class="box-header with-border ">
                <h3 class="box-title">การแก้ไข - ข้อเสนอแนะ : กรรมการความเสี่ยง</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <dl class="dl-horizontal">
                  <dt>การแก้ไข</dt>
                  <dd><?php echo $data->headrm_review_edit; ?></dd>
                  <dt>ข้อเสนอแนะ</dt>
                  <dd><?php echo $data->headrm_review_propersal; ?></dd>

                </dl>
              </div>
            </div>
          </div>
          <?php

          }
          ?>


      </div>















    </div> <!-- .box-body  -->







  <div class="box-footer">
    <a href="javascript:print();" class="btn btn-md btn-block btn-default">
        <i class="fa fa-btn fa-print"></i>&nbsp;พิมพ์
    </a>


  </div>
</div><!-- /.box -->


@endsection
