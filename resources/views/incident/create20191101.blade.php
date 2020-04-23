@extends('layouts.page')
@section('title','อุบัติการณ์ความเสี่ยง ' )
@section('content')
@include('layouts/function')
<style media="screen">
  .e5{
    padding:2px 10px 2px 10px;
  }
</style>
<form class="form-horizontal" action="{{route('incident.store')}}"  method="post">

    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('buttons.add');?>อุบัติการณ์ความเสี่ยง  </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">


            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">


<div class="box box-success box-solid">
  <div class="box-header with-border ">
    <h3 class="box-title">ข้อมูลความเสี่ยง</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">

<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                  <div class="form-group e5 {{ $errors->has('incident_date') ? ' has-error' : '' }}">
                    <label>วันที่เกิดเหตุ: <strong class="text-danger">( ** ปีให้กรอกเป็น คริสต์ศักราช  **)</strong></label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right col-lg-6 col-md-6" name ="incident_date" id="incident_date"  value="{{old('incident_date')}}">

                    </div>




                    @if ($errors->has('incident_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('incident_date') }}</strong>
                        </span>
                    @endif
                    <!-- /.input group -->
                  </div>

</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <!-- time Picker -->
                  <div class="form-group e5 {{ $errors->has('incident_time') ? ' has-error' : '' }}">
                    <label>เวลาเกิดเหตุ:<strong class="text-danger">( **รูปแบบเวลา xx:xx  **)</strong></label></label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                      </div>
                      <input type="text" class="form-control timepicker" name ="incident_time" id="incident_time" value="{{old('incident_time')}}">

                    </div>
                    @if ($errors->has('incident_time'))
                        <span class="help-block">
                            <strong>{{ $errors->first('incident_time') }}</strong>
                        </span>
                    @endif
                    <!-- /.input group -->
                  </div>


</div><!-- .col-lg-6 col-md-6 -->
</div><!-- .row -->












                  <div class="form-group e5 {{ $errors->has('division') ? ' has-error' : '' }}">
                    <label>กลุ่มงานที่รับผิดชอบ</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <select class="form-control select2" name="division" id="division">
                          <option value="">***กลุ่มงานที่รับผิดชอบ***</option>
                          <?php
                          foreach ( $rs_division as $row )
                          {
                          ?>
                          <option value="{{$row->id}}"  <?php if($row->id == old('division')){ echo 'selected="selected"'; }?> >
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
                        <i class="fa fa-calendar"></i>
                      </div>
                      <select class="form-control select2" name="subdivision" id="subdivision" data-subdivision="{{old('subdivision')}}">
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
                    <label>หมวดหมู่อุบัติการณ์:</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <select class="form-control select2" name="incident_group" id="incident_group">
                          <option value="">***หมวดหมู่อุบัติการณ์***</option>
                          <?php
                          foreach ( $rs_incidentgroup as $row )
                          {
                          ?>
                          <option value="{{$row->id}}" <?php if($row->id == old('incident_group')){ echo 'selected="selected"'; }?> > {{$row->name}} </option>
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


                  <div class="form-group  e5 {{ $errors->has('incident_list') ? ' has-error' : '' }}">
                    <label>รายการอุบัติการณ์</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <select class="form-control select2" name="incident_list" id="incident_list" data-incident_list="<?=old('incident_list')?>">
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
                        <i class="fa fa-calendar"></i>
                      </div>
                      <select class="form-control select2" name="typerisk" id="typerisk">
                          <option value="">***ประเภทความเสี่ยง***</option>
                          <?php
                          foreach ( $rs_typerisk as $row )
                          {
                          ?>
                          <option value="{{$row->id}}" <?php if($row->id == old('typerisk')){ echo 'selected="selected"'; }?> > {{$row->name}} </option>
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
                        <i class="fa fa-calendar"></i>
                      </div>
                      <select class="form-control select2" name="violence" id="violence" data-violence="<?=old('violence')?>">
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







                  <div class="form-group e5 {{ $errors->has('effect') ? ' has-error' : '' }}">
                    <label>เกิดขึ้นกับ</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <select class="form-control select2" name="effect" id="effect">
                          <option value="">***เกิดขึ้นกับ***</option>
                          <?php
                          foreach ( $rs_effect as $row )
                          {
                          ?>
                          <option value="{{$row->id}}"  <?php if($row->id == old('effect')){ echo 'selected="selected"'; }?> > {{$row->name}} </option>
                          <?php
                          }
                          ?>
                      </select>

                    </div>
                    @if ($errors->has('effect'))
                        <span class="help-block">
                            <strong>{{ $errors->first('effect') }}</strong>
                        </span>
                    @endif
                    <!-- /.input group -->
                  </div>



                  <div class="row">

                    <?php
                    $arrc = array();
                    $j = 0;
                    if(!empty(old('incidentcase')))
                    {

                      while($j<count( old('incidentcase')) )
                      {
                        $arrc[] = old('incidentcase.'.$j);
                        $j++;
                      }
                    }



                    foreach ( $rs_incidentcase as $row )
                    {


                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                      <!--  <div class="checkbox">  -->
                          <label>


                            <input name="incidentcase[]" type="checkbox"  VALUE="{{$row->id}}"
                            <?php
                            if( in_array( $row->id  , $arrc) )
                            {
                              echo 'checked="checked"';
                            }
                            ?>
                            >

                          {{$row->name}} &nbsp;
                          </label>
                      <!--   </div>  -->

                     </div>
                     <?php

                     }
                     ?>

                  </div>

                  <div class="form-group e5 {{ $errors->has('employee') ? ' has-error' : '' }}">
                    <label>ผู้พบเห็น</label>
                      <select class="form-control select2" name="employee" id="employee">
                          <option value="">***ผู้พบเห็น***</option>
                          <?php
                          foreach ( $rs_employee as $row )
                          {
                          ?>
                          <option value="{{$row->id}}" <?php if($row->id == old('employee')){ echo 'selected="selected"'; }?> > {{$row->prefix->name}}{{$row->fname}}&nbsp;&nbsp;{{$row->lname}} </option>
                          <?php
                          }
                          ?>
                      </select>
                      @if ($errors->has('employee'))
                          <span class="help-block">
                              <strong>{{ $errors->first('employee') }}</strong>
                          </span>
                      @endif
                  </div>

  </div><!-- box-body  -->
</div> <!-- box box-success box-solid  -->
            </div> <!--   /.col-lg-6 col-md-6 col-sm-12 col-xs-12  -->

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">



              <div class="box box-success box-solid">
                    <div class="box-header with-border ">
                      <h3 class="box-title">เหตุการณ์ - การแก้ไข - ข้อเสนอแนะ</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group e5 {{ $errors->has('incident_title') ? ' has-error' : '' }}">
                            <label>ชื่อเหตุการณ์ :: :: </label>
                            <input type="text" name="incident_title" class="form-control"  placeholder="ชื่อเหตุการณ์ ..." value="{{old('incident_title') }}">


                              @if ($errors->has('incident_title'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('incident_title') }}</strong>
                                  </span>
                              @endif
                            </div>
                          </div>

                        </div>


                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group e5 {{ $errors->has('incident_place') ? ' has-error' : '' }}">
                            <label>สถานที่เกิดเหตุ</label>
                            <input type="text" name="incident_place" class="form-control"  placeholder="สถานที่เกิดเหตุ ..." value="{{old('incident_place')}}">


                              @if ($errors->has('incident_place'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('incident_place') }}</strong>
                                  </span>
                              @endif
                            </div>
                          </div>

                        </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group e5 {{ $errors->has('incident_event') ? ' has-error' : '' }}">
                            <label>เหตุการณ์</label>
                            <textarea class="form-control"  name="incident_event" rows="5" placeholder="เหตุการณ์ ...">{{old('incident_event')}}</textarea>

                              @if ($errors->has('incident_event'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('incident_event') }}</strong>
                                  </span>
                              @endif
                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group e5 {{ $errors->has('incident_edit') ? ' has-error' : '' }}">
                              <label>การแก้ไขเบื้องต้น</label>
                              <textarea class="form-control"  name="incident_edit" rows="5" placeholder="การแก้ไขเบื้องต้น...">{{old('incident_edit')}}</textarea>

                                @if ($errors->has('incident_edit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('incident_edit') }}</strong>
                                    </span>
                                @endif
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group e5 {{ $errors->has('incident_propersal') ? ' has-error' : '' }}">
                                <label>ข้อเสนอแนะ</label>
                                <textarea class="form-control"  name="incident_propersal" rows="5" placeholder="ข้อเสนอแนะ...">{{old('incident_propersal')}}</textarea>
                                      <span class="help-block">
                                          <strong>{{ $errors->first('incident_propersal') }}</strong>
                                      </span>
                                </div>
                              </div>

                            </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
            </div><!--   /.col-lg-6 col-md-6 col-sm-12 col-xs-12  -->



      </div><!-- /.box-body -->
      <div class="box-footer">
        <a href="{{route('incident.index')}}" class="btn btn-md btn-default">
            <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
        </a>
        <button class="btn btn-primary btn-md pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>

      </div><!-- /.box-footer -->


</div><!-- /.box -->
</form>
<script type="text/javascript">
  $(function(){
    $('#incident_date').datepicker({
      /*
      autoclose: true,
      language: 'th'
      */
      format:'dd/mm/yyyy',
      autoclose: true,
      language: 'th'




    });
    //Timepicker
    $('#incident_time').timepicker({
      showMeridian: false,
      showInputs: false
    });
    $('#incident_time').val("<?=old('incident_time')?>");

    $('.select2').select2();


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
    if( $('#division').val() !='')
    {
      //alert($('#division').val());
      $("#subdivision").empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');//ล้างข้อมูล
      var division_id ;
      division_id = $('#division').val();
      var subdivision_id =   $('#subdivision').attr('data-subdivision');
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
            $('#subdivision option[value="'+subdivision_id+'"]').attr('selected','selected');

      });
    }

    $("#incident_group").change(function(){

      $("#incident_list").empty().append('<option value="">***รายการอุบัติการณ์***</option>');//ล้างข้อมูล

      var incident_group_id ;
      incident_group_id = $('#incident_group').val();
      $.get('{{ url('incident') }}/getincidentlist/'+incident_group_id , function(data) {
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
    if( $("#incident_group").val() != '' )
    {
      $("#incident_list").empty().append('<option value="">***รายการอุบัติการณ์***</option>');//ล้างข้อมูล
      var incident_group_id ;
      incident_group_id = $('#incident_group').val();
      var incident_list_id =   $('#incident_list').attr('data-incident_list');
      $.get('{{ url('incident') }}/getincidentlist/'+incident_group_id , function(data) {
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
            $('#incident_list option[value="'+incident_list_id+'"]').attr('selected','selected');

      });
    }
    //-------------------------------------------------------------------------------------------
    $("#typerisk").change(function(){

      $("#violence").empty().append('<option value="">***ระดับความรุนแรง***</option>');//ล้างข้อมูล

      var typerisk_id ;
      typerisk_id = $('#typerisk').val();
      //alert(typerisk_id);
      $.get('{{ url('incident') }}/getviolence/'+typerisk_id , function(data) {
        //alert(data);
//console.log( data );
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
    //--------------------------------------------------------------------------
    if($("#typerisk").val() !='')
    {
      $("#violence").empty().append('<option value="">***ระดับความรุนแรง***</option>');//ล้างข้อมูล
      var typerisk_id ;
      typerisk_id = $('#typerisk').val();
      var violence_id =   $('#violence').attr('data-violence');

      $.get('{{ url('incident') }}/getviolence/'+typerisk_id , function(data) {
        //alert(data);
//console.log( data );
        $('#violence')
            .empty()
            .append('<option value="">***ระดับความรุนแรง***</option>');
            $.each( data , function (i, item) {

                    $('#violence').append( $('<option>', {
                        value: item.id,
                        text : item.code+' : '+item.name
                    }));

            });
            $('#violence option[value="'+violence_id+'"]').attr('selected','selected');
      });
    }





  });
</script>
@endsection
