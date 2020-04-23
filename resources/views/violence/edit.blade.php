@extends('layouts.page')
@section('title','ข้อมูลความรุนแรง' )
@section('content')
@include('layouts/function')
<form class="form-horizontal" action="{{route('violence.update',[ $data->id ])}}"  method="post">

    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('buttons.edit');?>ความรุนแรง </h3>
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
        <div class="form-group{{ $errors->has('violencelevel') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ระดับ</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">

              <select id="violencelevel" name="violencelevel" class="select2 form-control">
                  <option value="">**ระดับความรุนแรง***</option>
                  <?php
                  foreach( $rs_violencelevel as $rs )
                  {
                  ?>
                  <option value="{{$rs->id}}" <?php if($rs->id == $data->violence_level->id){echo 'selected="selected"';}?>>{{$rs->name}}</option>

                  <??>
                  <?php
                  }
                  ?>
                </select>

                @if ($errors->has('violencelevel'))
                    <span class="help-block">
                        <strong>{{ $errors->first('violencelevel') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('typerisk') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ประเภทความเสี่ยง</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                <select id="violencelevel" name="typerisk" class="select2 form-control">
                    <option value="">**ประเภทความเสี่ยง***</option>
                    <?php
                    foreach( $rs_typerisk as $rs )
                    {
                    ?>
                    <option value="{{$rs->id}}" <?php if($rs->id == $data->type_risk->id){echo 'selected="selected"';}?>>{{$rs->name}}</option>

                    <??>
                    <?php
                    }
                    ?>
                  </select>
                @if ($errors->has('typerisk'))
                    <span class="help-block">
                        <strong>{{ $errors->first('typerisk') }}</strong>
                    </span>
                @endif
            </div>
        </div>




      </div><!-- /.box-body -->
      <div class="box-footer">
        <a href="{{route('violence.index')}}" class="btn btn-md btn-default">
            <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
        </a>
        <button class="btn btn-primary btn-md pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>

      </div><!-- /.box-footer -->


</div><!-- /.box -->
</form>
<script type="text/javascript">
$(function(){

  $('.select2').select2();
  //alert('1111');
});
</script>
@endsection
