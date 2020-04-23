@extends('layouts.page')
@section('title','หน่วยงาน ' )
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
?>
<form class="form-horizontal" action="{{route('subdivision.update',[ $data->id ])}}"  method="post">

    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('buttons.edit');?>หน่วยงาน  </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">
    <div class="form-group{{ $errors->has('division') ? ' has-error' : '' }}">
        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">กลุ่มงาน</label>

        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">

          <select id="division" name="division" class="select2 form-control"   data-division="<?php echo $data->division_id;?>">
              <option value="">**กลุ่มงาน***</option>
              <?php
              foreach( $rs_divsion as $rs )
              {
              ?>
              <option value="{{$rs->id}}" <?php if($rs->id == $data->division->id){echo 'selected="selected"';}?>>{{$rs->name}}</option>

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
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">หน่วยงาน </label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                <input type="text" class="form-control" name="name" value="{{ $data->name }} ">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
          <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label"> </label>
            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
              <div class="checkbox">
                <label>
                  <input name="is_division" type="checkbox" value="Y" <?php if($data->is_division=="Y"){ echo 'checked="checked"';}?>> เทียบเท่ากลุ่มงาน
                </label>
              </div>
            </div>
        </div>




      </div><!-- /.box-body -->
      <div class="box-footer">
        <a href="{{route('subdivision.index')}}" class="btn btn-md btn-default">
            <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
        </a>
        <button class="btn btn-primary btn-md pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>

      </div><!-- /.box-footer -->


</div><!-- /.box -->
</form>
@endsection
