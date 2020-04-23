@extends('layouts.page')
@section('title','ข้อมูลหมวดหมู่อุบัติการณ์' )
@section('content')
@include('layouts/function')
<form class="form-horizontal" action="{{route('incidentgroup.store')}}"  method="post">

    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('buttons.edit');?>ข้อมูลหมวดหมู่อุบัติการณ์ </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">หมวดหมู่อุบัติการณ์</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('risk_program') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">โปรแกรมความเสี่ยง</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">

              <select id="violencelevel" name="risk_program" class="select2 form-control">
                  <option value="">**ระดับความรุนแรง***</option>
                  <?php
                  foreach( $rs_riskprogram as $rs )
                  {
                  ?>
                  <option value="{{$rs->id}}">{{$rs->name}}</option>

                  <??>
                  <?php
                  }
                  ?>
                </select>

                @if ($errors->has('risk_program'))
                    <span class="help-block">
                        <strong>{{ $errors->first('risk_program') }}</strong>
                    </span>
                @endif
            </div>
        </div>




      </div><!-- /.box-body -->
      <div class="box-footer">
        <a href="{{route('incidentgroup.index')}}" class="btn btn-md btn-default">
            <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
        </a>
        <button class="btn btn-primary btn-md pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>

      </div><!-- /.box-footer -->


</div><!-- /.box -->
</form>
<script type="text/javascript">
$(function(){
    $('.select2').select2();
}) ;
</script>
@endsection
