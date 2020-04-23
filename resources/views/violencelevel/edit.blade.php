@extends('layouts.page')
@section('title','ข้อมูลระดับความรุนแรง' )
@section('content')
@include('layouts/function')
<form class="form-horizontal" action="{{route('violencelevel.update',[ $data->id ])}}"  method="post">

    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('buttons.edit');?>ระดับความรุนแรง </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">



        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">รหัส</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                <input type="text" class="form-control" name="code" value="{{ $data->code }} ">

                @if ($errors->has('code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('code') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ระดับความรุนแรง</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                <input type="text" class="form-control" name="name" value="{{ $data->name }} ">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">สี</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                <input type="color" class="form-control" id="colorpicker" name="color" value="{{ $data->color }}">

                @if ($errors->has('color'))
                    <span class="help-block">
                        <strong>{{ $errors->first('color') }}</strong>
                    </span>
                @endif
            </div>
        </div>




      </div><!-- /.box-body -->
      <div class="box-footer">
        <a href="{{route('violencelevel.index')}}" class="btn btn-md btn-default">
            <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
        </a>
        <button class="btn btn-primary btn-md pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>

      </div><!-- /.box-footer -->


</div><!-- /.box -->
</form>
@endsection
