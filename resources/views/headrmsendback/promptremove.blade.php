@extends('layouts.page')
@section('title','ลบอุบัติการณ์ความเสี่ยง ' )
@section('content')
@include('layouts/function')
<div class="box box-danger box-solid">
  <div class="box-header">
    <h3 class="box-title">ความเสี่ยงที่ต้องการลบ . </h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row">

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box box-warning box-solid">
          <div class="box-header with-border ">
            <h3 class="box-title">รายละเอียดความเสี่ยง</h3>
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
                    echo wordwrap($data->incident_title,300,'<br/>');
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
                    echo wordwrap($data->incident_event,300,'<br/>');
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
                    echo wordwrap($data->incident_edit,300,'<br/>');
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
                    echo  wordwrap($data->incident_propersal,300,'<br/>');
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <form id="FormHeadRmDelete" class="form-horizontal" action="{{route('headrmsendback.headrmdelete')}}"  method="post">
          <input type="hidden" name="_method" value="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="js_id" value="{{ $data->id }}">

          <div class="box box-warning box-solid">
            <div class="box-header">
              <h3 class="box-title"> <?php echo trans('buttons.info');?>เหตุผลที่ต้องการลบความเสี่ยง</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row {{ $errors->has('headrmdeletedescription') ? ' has-error' : '' }}">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <textarea name="headrmdeletedescription"
                  class="form-control " rows="5" placeholder="รายละเอียด ...">

                   </textarea>
                  @if ($errors->has('headrmdeletedescription'))
                      <span class="help-block">
                          <strong>{{ $errors->first('headrmdeletedescription') }}</strong>
                      </span>
                  @endif
                </div>
              </div>

            </div> <!-- .box-body -->
            <div class="box-footer">
              <a href="{{route('headrmremove.index')}}" class="btn btn-default pull-left">
                <i class="fa fa-reply"></i>&nbsp;{{trans('buttons.cancel')}}
              </a>

              <button class="btn btn-danger pull-right" type="button"  name="btnOK" onclick="ajaxHeadRmConfirmDelete(<?=$data->id?>);">
                <i class="fa fa-trash"></i>&nbsp;{{trans('buttons.softdelete')}}
              </button>


            </div><!-- /.box-footer -->
          </div> <!-- .box -->

          </form>

        </div>
      </div>



    </div> <!-- .box-body -->


</div> <!-- .box -->
<script type="text/javascript" src="{{asset('js/system/headrmremove/js-handle.js')}}"></script>
@endsection
