@extends('layouts.page')
@section('title','ความเสี่ยงที่รายงานโดยเจ้าหน้าที่ในกลุ่มงาน ' )
@section('content')
@include('layouts/function')
<div class="box box-success">
  <div class="box-header">
    <h3 class="box-title">ความเสี่ยงของ  :
      <?php
      echo $data->writeByID->employee->prefix->name;
      echo $data->writeByID->employee->fname;
      echo "  ";
      echo $data->writeByID->employee->lname;
      ?>
    </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">
  <div class="row">


    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

      <div class="box box-warning box-solid">
        <div class="box-header with-border ">
          <h3 class="box-title">ข้อมูลความเสี่ยง</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <dl class="dl-horizontal">
            <dt>วันที่เกิดเหตุ</dt>
            <dd>
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
            </dd>
            <dt>กลุ่มงานที่รับผิดชอบ</dt>
            <dd>
              <?php echo $data->division->name?>
            </dd>
            <dt>หน่วยงานที่รับผิดชอบ</dt>
            <dd>
              <?php echo $data->subdivision->name?>
            </dd>
            <dt>หมวดหมู่อุบัติการณ์</dt>
            <dd>
              <?php echo $data->incident_group->name?>
            </dd>
            <dt>รายการอุบัติการณ์</dt>
            <dd>
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
            </dd>
            <dt>ประเภทความเสี่ยง</dt>
            <dd>
              <?php echo $data->typerisk->name?>
            </dd>
            <dt>ระดับความรุนแรง</dt>
            <dd>
              <?php echo $data->violence->name?>
            </dd>
            <dt>เกิดขึ้นกับ</dt>
            <dd>
              <?php echo $data->effect->name?>
            </dd>
            <dt>ผู้พบเห็น</dt>
            <dd>
              <?php echo $data->employee->prefix->name.$data->employee->fname.'  '.$data->employee->lname?>
            </dd>

            <dt>ผู้เขียน</dt>
            <dd>
              <?php
              echo $data->writeByID->employee->prefix->name.$data->writeByID->employee->fname.'  '.$data->writeByID->employee->lname;
              ?>
            </dd>
            <dt>เขียนเมื่อ</dt>
            <dd>
              <?php
              if(!empty($data->created_at) || $data->created_at !='')
              {
                $datewrite = explode(" ", $data->created_at);
                echo  long_th_date( $datewrite[0] ).' '.$datewrite[1].' น.';
              }
              else
              {
                echo '-';
              }

              ?>
            </dd>
          </dl>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
      <div class="box box-warning box-solid">
        <div class="box-header with-border ">
          <h3 class="box-title">เหตุการณ์ - การแก้ไข - ข้อเสนอแนะ</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <dl class="dl-horizontal">
            <dt>ชื่อเหตุการณ์</dt>
            <dd><?php  if( $data->incident_title !='' ){ echo $data->incident_title; }else{ echo '-'; }?></dd>
            <dt>สถานที่เกิดเหตุ</dt>
            <dd><?php  if( $data->incident_place !='' ){ echo $data->incident_place; }else{ echo '-'; }?></dd>
            <dt>เหตุการณ์</dt>
            <dd>
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
            </dd>
            <dt>การแก้ไขเบื้องต้น</dt>
            <dd>
              <?php
              if( $data->incident_edit !='' )
              {
                echo $data->incident_edit;
              }else{
                echo '-';
              }
              ?>
            </dd>
            <dt>ข้อเสนอแนะ</dt>
            <dd>
              <?php
              if( $data->incident_propersal !='' )
              {
                echo  $data->incident_propersal;
              }else{
                echo '-';
              }
              ?>
            </dd>
          </dl>
        </div>
      </div>
    </div>
</div>

    <div class="row">
      <?php
      if( $data->headrm_sendto_headdivision_status =="Y" && $data->headdivision_receive_status =="Y" &&  $data->headdivision_edit !="")
      {
      ?>
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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




  </div>
  <div class="box-footer">
    <a href="{{ URL::previous() }}" class="btn  btn-default btn-block">
        <i class="fa fa-btn fa-reply"></i> {{trans('buttons.back')}}
    </a>

  </div>
</div>
@endsection
