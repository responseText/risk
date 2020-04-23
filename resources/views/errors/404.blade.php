@extends('layouts.page')
@section('title','เกิดข้อผิดพลาด' )
@section('content')




<style>

</style>
<div class="row1">
  <div class="col-lg-12 ">
      <div class="callout callout-danger">
          <h4><i class="icon fa fa-ban"></i>เกิดข้อผิดพลาด !</h4>

          <p>
          {{ $exception->getMessage() }}
          </p>

  </div>
  <div class="col-lg-12 ">
      <a class="btn btn-danger col-lg-12 col-md-12 col-sm-12 col-xs-12 " href="javascript:history.back();">กลับ</a>
  </div>

</div>

@endsection
