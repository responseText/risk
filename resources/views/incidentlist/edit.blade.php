@extends('layouts.page')
@section('title','หมวดหมู่อุบัติการณ์' )
@section('content')
@include('layouts/function')
<form class="form-horizontal" action="{{route('incidentlist.update',[ $data->id ])}}"  method="post">

    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('buttons.edit');?>หมวดหมู่อุบัติการณ์ </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">
    <div class="form-group{{ $errors->has('incident_group') ? ' has-error' : '' }}">
        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">หมวดอุบัติการณ์</label>

        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">

          <select id="incident_group" name="incident_group" class="select2 form-control">
              <option value="">**หมวดอุบัติการณ์***</option>
              <?php
              foreach( $rs_incident_group as $rs )
              {
              ?>
              <option value="{{$rs->id}}" <?php if($rs->id == $data->incident_group->id){echo 'selected="selected"';}?>>{{$rs->name}}</option>

              <??>
              <?php
              }
              ?>
            </select>

            @if ($errors->has('incident_group'))
                <span class="help-block">
                    <strong>{{ $errors->first('incident_group') }}</strong>
                </span>
            @endif
        </div>
    </div>

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">หมวดหมู่อุบัติการณ์</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                <input type="text" class="form-control" name="name" value="{{ $data->name }} ">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>




      </div><!-- /.box-body -->
      <div class="box-footer">
        <a href="{{route('incidentlist.index')}}" class="btn btn-md btn-default">
            <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
        </a>
        <button class="btn btn-primary btn-md pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>

      </div><!-- /.box-footer -->


</div><!-- /.box -->
</form>
<script type="text/javascript">
$(function(){
  $('.select2').select2();
});
</script>
@endsection
