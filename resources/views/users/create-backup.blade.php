@extends('layouts.page')
@section('title','ผู้ใช้งานระบบ' )
@section('content')
@include('layouts/function')
<form class="form-horizontal" action="{{route('users.store')}}"  method="post">

    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('buttons.add');?>ผู้ใช้งานระบบ </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">

      <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
          <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ผู้ใช้งานระบบ</label>

          <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">

              @if ($errors->has('name'))
                  <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
          </div>
        </div>

        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">รหัสผ่าน</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
              <input type="password" name="password" class="form-control" value="">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ยืนยันรหัสผ่าน</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
              <input type="password" name="password_confirmation" class="form-control" >

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>









        <div class="form-group {{ $errors->has('employee') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">เจ้าหน้าที่</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
              <select id="employee" name="employee" class="select2 form-control">
                  <option value="">***เจ้าหน้าที่***</option>
                  <?php
                  foreach( $rs_employee as $rs )
                  {
                  ?>
                  <option value="{{$rs->id}}" <?php if ($rs->id == old('employee')){ echo 'selected="selected"';}?>>
                    <?php echo $rs->prefix->name.$rs->fname.'  '. $rs->lname; ?>
                  </option>

                  <??>
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


        </div>



        <div class="form-group {{ $errors->has('level_access') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ระดับผู้ใช้งาน</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
              <select id="level_access" name="level_access" class="select2 form-control">
                  <option value="">***ระดับผู้ใช้งาน***</option>
                  <?php
                  foreach( $rs_levelaccess as $rs )
                  {
                  ?>
                  <option value="{{$rs->id}}" <?php if ($rs->id == old('level_access')){ echo 'selected="selected"';}?>>
                    <?php echo $rs->name; ?>
                  </option>

                  <??>
                  <?php
                  }
                  ?>
                </select>

                @if ($errors->has('level_access'))
                    <span class="help-block">
                        <strong>{{ $errors->first('level_access') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div id="area_division" class="form-group  <?php if(old('level_access') =='4' ||old('level_access') =='5'  ){echo '';}else{ echo 'hide'; }?> {{ $errors->has('division') ? ' has-error' : '' }}"  >
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">กลุ่มงาน</label>
            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
              <select id="division" name="division" class="form-control">
                  <option value="">***กลุ่มงาน***</option>
                  <?php
                  foreach( $rs_division as $rs )
                  {
                  ?>
                  <option value="{{$rs->id}}" <?php if ($rs->id == old('division')){ echo 'selected="selected"';}?>>
                    <?php echo  $rs->name; ?>
                  </option>

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
        <div id="area_subdivision" class="<?php if(old('level_access') =='5'  ){echo '';}else{ echo 'hide'; }?> form-group {{ $errors->has('subdivision') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">หน่วยงาน</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
              <select id="subdivision" name="subdivision" class=" form-control" data-subdivision="{{old('subdivision')}}">
                  <option value="">***หน่วยงาน***</option>
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
        <a href="{{route('users.index')}}" class="btn btn-md btn-default">
            <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
        </a>
        <button class="btn btn-primary btn-md pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>

      </div><!-- /.box-footer -->


</div><!-- /.box -->
</form>
<script type="text/javascript">
$(function(){


///$('#area_division').hide();
    $('.select2').select2();

    $('#level_access').change(function(){

      var  level_access_val = $('#level_access').val();
      if( level_access_val == '4' )
      {
        //$('#area_division').show();
        $('#area_division').removeClass('hide');
        $('#area_subdivision').addClass('hide');
      }
      else if(level_access_val == '5')
      {
          $('#area_division').removeClass('hide');
          $('#area_subdivision').removeClass('hide');
          $("#division").change(function(){

            $("#subdivision").empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');//ล้างข้อมูล

            var division_id ;
            division_id = $('#division').val();
            $.get('{{ url('users') }}/getsubdivision/'+division_id , function(data) {
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
      }
      else{
        $('#area_division').addClass('hide');
        $('#area_subdivision').addClass('hide');
      }

    });
    //-------------------------------------------------------------------------
    $('#division').change(function(){
      var division_id ;
      division_id = $('#division').val();
      $.get('{{ url('users') }}/getsubdivision/'+division_id , function(data) {
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
    //--------------------------------------------------------------------------
    if($('#level_access').val() !='' )
    {
      if( $('#level_access').val() =='5')
      {
        var subdivision_id =   $('#subdivision').attr('data-subdivision');
        console.log(subdivision_id);
        var  division_id = $("#division").val();



        //$("#division").change(function(){

          $("#subdivision").empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');//ล้างข้อมูล

          var division_id ;
          division_id = $('#division').val();
          $.get('{{ url('users') }}/getsubdivision/'+division_id , function(data) {
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
        //});
      }
    }
}) ;
</script>
@endsection
