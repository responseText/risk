@extends('layouts.page')
@section('title','ผู้ใช้งานระบบ' )
@section('content')
@include('layouts/function')
<style media="screen">
.text-muted{
  margin-top: 5pt;
}

</style>
<form class="form-horizontal" action="{{route('users.updatepassword')}}"  method="post">

    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('buttons.edit');?>รหัสผ่านใช้งานระบบ </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">




    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ผู้ใช้งานระบบ</label>

        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
          <label class="text-muted">
            <?php echo $data->name;?>
          </label>
        </div>


    </div>
        <div class="form-group {{ $errors->has('employee') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">เจ้าหน้าที่</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
              <label class="text-muted">
                <?php echo $data->employee->prefix->name.$data->employee->fname.'   '.$data->employee->lname;?>
              </label>



            </div>
          </div>



            <div class="form-group {{ $errors->has('level_access') ? ' has-error' : '' }}">
                <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ระดับผู้ใช้งาน</label>

                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
                    <label class="text-muted">

                        <?php
                        
                        if( count($user_access) > 0 )
                        {
                          echo implode(" , ", $user_access) ;
                        }
                        else
                        {
                          echo "ผู้ใช้งานระบบทั่วไป";
                        }
                        ?>



                  </label>
                </div>
            </div>
            <?php
            //if(!empty($data->level_id))
            //{
            //  if($data->level_id == '4')
              //{
            ?>

            <div class="row ">
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12  control-label" >
                <strong>หน่วยงาน</strong>
              </div>
              <div class="col-lg-9  col-md-9 col-sm-6 col-xs-12">
                <label class="text-muted">
                  <?php echo $data->employee->division->name;?>
                </label>
              </div>
            </div>
            <?php
            //  }

            //}

            ?>

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








      </div><!-- /.box-body -->
      <div class="box-footer">
        <a href="{{route('users.show1',[$data->id])}}" class="btn btn-md btn-default">
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
