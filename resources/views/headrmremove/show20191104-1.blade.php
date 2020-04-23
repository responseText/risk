@extends('layouts.page')
@section('title','อุบัติการณ์ความเสี่ยง ' )
@section('content')
@include('layouts/function')
<style media="screen">
  .e5{
    padding:2px 10px 2px 10px;
  }
  .btn{
    margin: 0 5px 0 5px;
  }
</style>
<?php
$boxStyle = '';
if( $data->headrm_delete=='Y')
{
  $boxStyle='danger';
}
else
{
  $boxStyle='success';
}
?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title"> <?php echo trans('buttons.info');?>ความเสี่ยง . </h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <?php
          if( $data->headrm_delete=='Y')
          {
          ?>
          <div class="alert alert-danger alert-dismissible">

                <h4><i class="icon fa fa-ban"></i> แจ้งเตือนจากระบบ !</h4>
                ข้อมูลความเสี่ยงนี้ได้ถูกคณะกรรมการความเสี่ยงคัดออกจากระบบ</br>
                *** หากมีข้อสงสัยติดต่อคณะกรรมการความเสี่ยง  ***
              </div>
          <?php
          }
          ?>

          <div class="box box-{{$boxStyle}} box-solid">
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


            </div>
          </div>
        </div>
      </div><!-- .row  -->





      <?php
      if( $data->headrm_delete=='Y')
      {
      ?>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
          <div class="box box-{{$boxStyle}} box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">เหตุผลการลบความเสี่ยง</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
               <dt>เหตุผล</dt>
               <dd>{{$data->headrm_delete_descrition}}</dd>

             </dl>
           </div><!-- .body -->
           <div class="box-footer">
             <a href="{{route('headrmremove.index')}}" class="btn btn-default pull-left">
               <i class="fa fa-reply"></i>&nbsp;{{trans('buttons.cancel')}}
             </a>
             <a href="javascript:ajaxHeadRmConfirmRestore();" class="btn btn-success pull-right">
               <i class="fa fa-recycle"></i>&nbsp;{{trans('buttons.restore')}}
             </a>


           </div><!-- /.box-footer -->
          </div>
        </div>
      </div>
      <form  id="myForm" method="post">
      <input type="hidden" name="js_id" value="<?=$data->id?>">
      <input type="hidden" name="_method" value="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </form>

      <?php
      }
      //else
      //{
      ?>


      <form  class="form-horizontal <?php if( $data->headrm_delete=='Y'){ echo 'hidden';}?>" action="{{route('headrmremove.update',[ $data->id ])}}"  method="post">
      <input type="hidden" name="_method" value="PATCH">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">


      <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
          <div class="box box-success box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title">เลือกหน่วยงานที่ต้องการย้ายความเสี่ยง</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">




              <div class="form-group e5 {{ $errors->has('division') ? ' has-error' : '' }}">
                <label>กลุ่มงานที่รับผิดชอบ</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-object-group"></i>
                  </div>
                  <select class="form-control select2" name="division" id="division">
                      <option value="">***กลุ่มงานที่รับผิดชอบ***</option>
                      <?php
                      foreach ( $rs_division as $row )
                      {
                      ?>
                      <option value="{{$row->id}}" <?php if($row->id==$data->division_id){ echo 'selected="selected"';} ?> >
                        {{$row->name}}
                      </option>
                      <?php
                      }
                      ?>
                  </select>

                </div>
                @if ($errors->has('division'))
                    <span class="help-block">
                        <strong>{{ $errors->first('division') }}</strong>
                    </span>
                @endif
                <!-- /.input group -->
              </div>
              <div class="form-group e5 {{ $errors->has('subdivision') ? ' has-error' : '' }}">
                <label>หน่วยงานที่รับผิดชอบ</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-object-ungroup"></i>
                  </div>
                  <select class="form-control select2" name="subdivision" id="subdivision"  data-subdivision="<?=$data->sub_division_id?>">
                      <option value="">***หน่วยงานที่รับผิดชอบ***</option>

                  </select>

                </div>
                @if ($errors->has('subdivision'))
                    <span class="help-block">
                        <strong>{{ $errors->first('subdivision') }}</strong>
                    </span>
                @endif
                <!-- /.input group -->
              </div>

              <div class="form-group e5 {{ $errors->has('incident_group') ? ' has-error' : '' }}">
                <label>หมวดหมู่อุบัติการณ์</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-cube"></i>
                  </div>
                  <select class="form-control select2" name="incident_group" id="incident_group"  data-incident_group="<?=$data->incident_group_id?>">
                      <option value="">***หมวดหมู่อุบัติการณ์***</option>
                      <?php
                      foreach ( $rs_incidentgroup as $row )
                      {
                      ?>
                      <option value="{{$row->id}}" <?php if($row->id==$data->incident_group_id){ echo 'selected="selected"';} ?> >
                        {{$row->name}}
                      </option>
                      <?php
                      }
                      ?>
                  </select>

                </div>
                @if ($errors->has('incident_group'))
                    <span class="help-block">
                        <strong>{{ $errors->first('incident_group') }}</strong>
                    </span>
                @endif
                <!-- /.input group -->
              </div>
              <div class="form-group e5 {{ $errors->has('incident_list') ? ' has-error' : '' }}">
                <label>รายการอุบัติการณ์</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-cubes"></i>
                  </div>
                  <select class="form-control select2" name="incident_list" id="incident_list"  data-incident_list="<?=$data->incident_list_id?>">
                      <option value="">***รายการอุบัติการณ์***</option>

                  </select>

                </div>
                @if ($errors->has('incident_list'))
                    <span class="help-block">
                        <strong>{{ $errors->first('incident_list') }}</strong>
                    </span>
                @endif
                <!-- /.input group -->
              </div>


              <div class="form-group e5 {{ $errors->has('typerisk') ? ' has-error' : '' }}">
                <label>ประเภทความเสี่ยง:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-warning"></i>
                  </div>
                  <select class="form-control select2" name="typerisk" id="typerisk">
                      <option value="">***ประเภทความเสี่ยง***</option>
                      <?php
                      foreach ( $rs_typerisk as $row )
                      {
                      ?>
                      <option value="{{$row->id}}" <?php if($row->id==$data->type_risk_id){ echo 'selected="selected"';} ?> >
                        {{$row->name}}
                      </option>
                      <?php
                      }
                      ?>
                  </select>

                </div>
                @if ($errors->has('typerisk'))
                    <span class="help-block">
                        <strong>{{ $errors->first('typerisk') }}</strong>
                    </span>
                @endif
                <!-- /.input group -->
              </div>


              <div class="form-group e5 {{ $errors->has('violence') ? ' has-error' : '' }}">
                <label>ระดับความรุนแรง</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-warning"></i>
                  </div>
                  <select class="form-control select2" name="violence" id="violence" data-violence="<?=$data->violence_id?>">
                      <option value="">***ระดับความรุนแรง***</option>

                  </select>

                </div>
                @if ($errors->has('violence'))
                    <span class="help-block">
                        <strong>{{ $errors->first('violence') }}</strong>
                    </span>
                @endif
                <!-- /.input group -->
              </div>


            </div> <!-- box-body -->
            <div class="box-footer">
              <a href="{{route('headrmremove.index')}}" class="btn btn-default pull-left">
                <i class="fa fa-reply"></i>&nbsp;{{trans('buttons.cancel')}}
              </a>
              <a href="javascript:ajaxRmDelete('<?=$data->id?>');" class="btn btn-danger pull-left">
                <i class="fa fa-trash"></i>&nbsp;{{trans('buttons.softdelete')}}
              </a>
              <button class="btn btn-success pull-right" type="submit"  name="btnOK">
                <i class="fa fa-save"></i>&nbsp;{{trans('buttons.save')}}
              </button>


            </div><!-- /.box-footer -->

          </div>

        </div>
      </div>
  </form>
  <?php
  //}
  ?>

    </div> <!-- .box-body  -->


</div><!-- /.box -->

<script type="text/javascript" src="{{asset('js/system/headrmremove/js-handle.js')}}"></script>
<script type="text/javascript">
$(function(){
  $('.select2').select2();

  if( $('#division').val() !='' )
  {
       division_id= $('#division').val();
       var subdivision_id =   $('#subdivision').attr('data-subdivision');
      //-------------------------------------------------------------------------------------
      $("#subdivision").empty().append('<option value="">หน่วยงานที่รับผิดชอบ</option>');//ล้างข้อมูล
      $.get('{{ url('headrmremove') }}/getsubdivision/'+division_id , function(data) {
        //alert(data);

        $('#subdivision')
            .empty()
            .append('<option value="">หน่วยงานที่รับผิดชอบ</option>');
            $.each( data , function (i, item) {

                    $('#subdivision').append( $('<option>', {
                        value: item.id,
                        text : item.name
                    }));
            });
            $('#subdivision option[value="'+subdivision_id+'"]').attr('selected','selected');
        });
    }
    //-----------------------------------------------------------------------------------------------

    if( $('#typerisk').val() !='' )
    {
         typerisk_id= $('#typerisk').val();
         var violence_id =   $('#violence').attr('data-violence');
        //-------------------------------------------------------------------------------------
        $("#violence").empty().append('<option value="">***ระดับความรุนแรง***</option>');//ล้างข้อมูล
        $.get('{{ url('headrmremove') }}/getviolence/'+typerisk_id , function(data) {
          //alert(data);

          $('#violence')
              .empty()
              .append('<option value="">***ระดับความรุนแรง***</option>');
              $.each( data , function (i, item) {

                      $('#violence').append( $('<option>', {
                          value: item.id,
                          text : item.name
                      }));
              });
              $('#violence option[value="'+violence_id+'"]').attr('selected','selected');
          });
      }
      //------------------------------------------------------------------------------------
      if( $('#incident_group').val() !='' )
      {
           incidentgroup_id= $('#incident_group').val();
           var incidentlist_id =   $('#incident_list').attr('data-incident_list');
          //-------------------------------------------------------------------------------------
          $("#incident_list").empty().append('<option value="">รายการอุบัติการณ์</option>');//ล้างข้อมูล
          $.get('{{ url('headrmremove') }}/getincidentlist/'+incidentgroup_id , function(data) {
            //alert(data);

            $('#incident_list')
                .empty()
                .append('<option value="">รายการอุบัติการณ์</option>');
                $.each( data , function (i, item) {

                        $('#incident_list').append( $('<option>', {
                            value: item.id,
                            text : item.name
                        }));
                });
                $('#incident_list option[value="'+incidentlist_id+'"]').attr('selected','selected');
            });
        }

//----------------------------------------------------------------------------------------------------------
  $("#division").change(function(){

    $("#subdivision").empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');//ล้างข้อมูล

    var division_id ;
    division_id = $('#division').val();
    $.get('{{ url('incident') }}/getsubdivision/'+division_id , function(data) {
      //alert(data);

      $('#subdivision')
          .empty()
          .append('<option value="">***โปรดเลือกหน่วยงาน***</option>');
          $.each( data , function (i, item) {

                  $('#subdivision').append( $('<option>', {
                      value: item.id,
                      text : item.name
                  }));

          });
    });
  });

//------------------------------------------------------------------------------------------
  $("#typerisk").change(function(){

    $("#violence").empty().append('<option value="">***ระดับความรุนแรง***</option>');//ล้างข้อมูล

    var typerisk_id ;
    typerisk_id = $('#typerisk').val();
    //alert(typerisk_id);
    $.get('{{ url('incident') }}/getviolence/'+typerisk_id , function(data) {
      //alert(data);
console.log( data );
      $('#violence')
          .empty()
          .append('<option value="">***ระดับความรุนแรง***</option>');
          $.each( data , function (i, item) {

                  $('#violence').append( $('<option>', {
                      value: item.id,
                      text : item.code+' : '+item.name
                  }));

          });
    });
  });
  //----------------------------------------------------------------------------------------------------------
    $("#incident_group").change(function(){

     $("#incident_list").empty().append('<option value="">รายการอุบัติการณ์</option>');//ล้างข้อมูล

      var incidentgroup_id ;
      incidentgroup_id = $('#incident_group').val();
      $.get('{{ url('headrmremove') }}/getincidentlist/'+incidentgroup_id , function(data) {
        //alert(data);

        $('#incident_list')
            .empty()
            .append('<option value="">***รายการอุบัติการณ์***</option>');
            $.each( data , function (i, item) {

                    $('#incident_list').append( $('<option>', {
                        value: item.id,
                        text : item.name
                    }));

            });
      });
    });



});
</script>
@endsection
