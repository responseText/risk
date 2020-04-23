@extends('layouts.page')
@section('title','อุบัติการณ์ความเสี่ยง ' )
@section('content')
@include('layouts/function')
<style media="screen">
  .e5{
    padding:2px 10px 2px 10px;
  }
</style>
<div class="box">
  <div class="box-header">
    <h3 class="box-title"> <?php echo trans('buttons.info');?>ความเสี่ยงของหน่วยงานที่ได้รับ :  <?php echo $data->division->name?>
    </h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
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
					//echo $data->employee->prefix->name.$data->employee->fname.'  '.$data->employee->lname
				  if(empty($data->employee->fname))
                  {
                    echo '<span class="bg-red">ผู้เห็นเหตุการณ์นี้ถูกลบออกจากระบบ</span>';
                  }
                  else
                  {
                    echo $data->employee->prefix->name.$data->employee->fname.'   '.$data->employee->lname;
                  }
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
                      echo  $data->incident_propersal;
                    }else{
                      echo '-';
                    }
                    ?>
                  </p>
                </div>
              </div>
              <?php
              if( Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
              {
              ?>
              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>ผู้เขียน </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">
                    <?php
					if(empty($data->employee->fname))
                  {
                    echo '<span class="bg-red">ผู้เห็นเหตุการณ์นี้ถูกลบออกจากระบบ</span>';
                  }
                  else
                  {
                    echo $data->writeByID->employee->prefix->name.$data->writeByID->employee->fname.'   '.$data->writeByID->employee->lname;
                  }
                   // echo $data->employee->prefix->name.$data->employee->fname.'  '.$data->employee->lname;
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
$HeadDivision =true;
$arrSubDivision=array('13','16','17','18','19','22','24','28');

if( Auth::user()->level_id == 4 && (Auth::user()->division_id==$data->division_id) &&  !in_array($data->sub_division_id,$arrSubDivision)    )
{
  $HeadDivision=true;
}
else
{
  $HeadDivision=false;

}
?>





      <form class="form-horizontal" action="{{route('headdivisionreview.update',[ $data->id ])}}"  method="post">
      <input type="hidden" name="_method" value="PATCH">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">


      <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">ความคิดเห็นของหน่วยหน้ากลุ่มงาน</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <div class="form-group">
                  <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">การแก้ไข</label>
                  <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                    <textarea name="txt_edit" rows="5" cols="100" <?php if($HeadDivision){ echo '';}else{  echo 'disabled';}?> >{{$data->headdivision_edit}}</textarea>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ข้อเสนอแนะ</label>
                  <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                    <textarea name="txt_propersal" rows="5" cols="100" <?php if($HeadDivision){ echo '';}else{  echo 'disabled';}?>>{{$data->headdivision_propersal}}</textarea>
                  </div>
              </div>






            </div> <!-- box-body -->
            <div class="box-footer">
              <a href="{{route('headdivisionreview.index')}}" class="btn btn-default">{{trans('buttons.cancel')}}</a>
              <??>
              <?php
              if($HeadDivision)
              {
              ?>
              <button class="btn btn-success pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>
              <?php
              }
              ?>
            </div><!-- /.box-footer -->

          </div>

        </div>
      </div>
  </form>


    </div> <!-- .box-body  -->


</div><!-- /.box -->

<script type="text/javascript">
$(function(){

});
</script>
@endsection
