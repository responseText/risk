@extends('layouts.page')
@section('title','อุบัติการณ์ความเสี่ยง ' )
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
//print_r($arr_subdivision);
//print_r($arr_user_level);
?>














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
              <h3 class="box-title">รายละเอียดความเสี่ยงของหน่วยงานที่ได้รับ : <?=$titlename?></h3>
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
              if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level))
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


<!--  ****************  เริ่มต้น ส่วนแสดงของกรรมการ   ****************   -->

<?php
if($data->headrm_review_status == "Y" )
{
?>



      <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">ความคิดเห็นของกรรมการความเสี่ยง</h3>
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
                    if( $data->headrm_review_edit !='' )
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


              <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-label-show " >
                <strong>ข้อเสนอแนะ </strong>
                </div>
                <div class="col-lg-8  col-md-7 col-sm-7 col-xs-12">
                  <p class="text-muted">

                    <?php
                    if( $data->headrm_review_propersal !='' )
                    {
                      echo $data->headrm_review_propersal ;
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
} // .end if else  $data->headdivision_receive_status == null
?>

<!--  ****************  สิ้นสุด ส่วนแสดงของกรรมการ   ****************   -->






















<?php
$HeadDivision =true;
//$arrSubDivision=array('13','16','17','18','19','22','24','28');

//if( Auth::user()->level_id == 4 && (Auth::user()->division_id==$data->division_id) &&  !in_array($data->sub_division_id,$arrSubDivision)    )
if( in_array(4,$arr_user_level) &&  in_array( $data->division_id ,$arr_division) &&  !in_array( $data->sub_division_id ,$arr_subdivision) )
//if( in_array('4',$arr_user_level) )
{
  $HeadDivision=true;
}
else
{
  $HeadDivision=false;

}
?>





      <form class="form-horizontal" action="{{route('rmdivisionreview.update',[ $data->id ])}}"  method="post">
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
              <a href="{{route('rmdivisionreview.index')}}" class="btn btn-default">{{trans('buttons.cancel')}}</a>
              <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalSendBack">ส่งคืนความเสี่ยงให้กรรมการ</a>

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
<div class="modal fade" id="exampleModalSendBack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content  ">
      <div class="modal-header alert-warning">
        <h4 class="modal-title" id="exampleModalLabel">คุณต้องการจะส่งคืนความเสี่ยงให้คณะกรรมการ</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
    <h4>คุณต้องการจะส่งคืนความเสี่ยงให้คณะกรรมการ  เพื่อตรวจสอบอีกครั้งว่าเป็นความเสี่ยงของหน่วยงานที่เรารับผิดชอบหรือไม่</h4>
      </div>
      <div class="modal-footer">
        <form id="myFormSendback" action="{{route('rmdivisionreview.sendbackrm')}}" method="post">
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
//-----------------------------------------------------------------------------
$(function(){

});
</script>
@endsection
