@extends('layouts.page')
@section('title','ข้อมูลเจ้าหน้าที่' )
@section('content')
@include('layouts/function')
<form class="form-horizontal" action="{{route('employee.store')}}"  method="post">

    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('buttons.edit');?>ข้อมูลเจ้าหน้าที่ </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">

    <div class="form-group {{ $errors->has('prefix') ? ' has-error' : '' }}">
        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">คำนำหน้า</label>

        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
          <select id="prefix" name="prefix" class="select2 form-control">
              <option value="">**คำนำหน้า***</option>
              <?php
              foreach( $rs_prefix as $rs )
              {
              ?>
              <option value="{{$rs->id}}" >{{$rs->name}}</option>

              <??>
              <?php
              }
              ?>
            </select>

            @if ($errors->has('prefix'))
                <span class="help-block">
                    <strong>{{ $errors->first('prefix') }}</strong>
                </span>
            @endif
        </div>


    </div>
    <div class="form-group{{ $errors->has('fname') ? ' has-error' : '' }}">
        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ชื่อ</label>

        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">

          <input type="text" name="fname" class="form-control" value="{{old('fname')}}">

            @if ($errors->has('fname'))
                <span class="help-block">
                    <strong>{{ $errors->first('fname') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('lname') ? ' has-error' : '' }}">
        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">นามสกุล</label>

        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">

          <input type="text" name="lname" class="form-control" value="{{old('lname')}}">

            @if ($errors->has('lname'))
                <span class="help-block">
                    <strong>{{ $errors->first('lname') }}</strong>
                </span>
            @endif
        </div>
    </div>








    <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ตำแหน่ง</label>

        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">

          <select id="violencelevel" name="position" class="select2 form-control">
              <option value="">**ตำแหน่ง***</option>
              <?php
              foreach( $rs_position as $rs )
              {
              ?>
              <option value="{{$rs->id}}" >{{$rs->name}}</option>

              <??>
              <?php
              }
              ?>
            </select>

            @if ($errors->has('position'))
                <span class="help-block">
                    <strong>{{ $errors->first('position') }}</strong>
                </span>
            @endif
        </div>
    </div>


    <div class="form-group{{ $errors->has('division') ? ' has-error' : '' }}">
        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">กลุ่มงาน</label>

        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">

          <select id="division" name="division" class="select2 form-control">
              <option value="">**กลุ่มงาน***</option>
              <?php
              foreach( $rs_division as $rs )
              {
              ?>
              <option value="{{$rs->id}}" >{{$rs->name}}</option>

              <??>
              <?php
              }
              ?>
            </select>

            @if ($errors->has('division'))
                <span class="help-block">
                    <strong>{{ $errors->first('division') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('subdivision') ? ' has-error' : '' }}">
        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">หน่วยงาน</label>

        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">

          <select id="subdivision" name="subdivision" class="select2 form-control"  >
              <option value="">**หน่วยงาน***</option>

            </select>

            @if ($errors->has('subdivision'))
                <span class="help-block">
                    <strong>{{ $errors->first('subdivision') }}</strong>
                </span>
            @endif
        </div>
    </div>




      </div><!-- /.box-body -->
      <div class="box-footer">
        <a href="{{route('employee.index')}}" class="btn btn-md btn-default">
            <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
        </a>
        <button class="btn btn-primary btn-md pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>

      </div><!-- /.box-footer -->


</div><!-- /.box -->
</form>
<script type="text/javascript">
$(function(){



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


    $('.select2').select2();
}) ;
</script>
@endsection
