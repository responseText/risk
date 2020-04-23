@extends('layouts.page')
@section('title','ผู้ใช้งานระบบ' )
@section('content')
@include('layouts/function')

<div class="row">
  <form class="" action="{{route('users.update1', Auth::user()->id)}}" method="post">
    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="col-lg-5">
      <input type="password" class="form-control" name="password">
    </div>
    <div class="col-lg-1">
      <button class="btn btn-primary btn-md pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>
    </div>


  </form>
</div>



<script type="text/javascript">
$(function(){

$('.select2').select2();
});
</script>
@endsection
