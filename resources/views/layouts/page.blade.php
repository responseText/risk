
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ระบบความเสี่ยง โรงพยาบาลทองแสนขัน</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="description" content="ระบบความเสี่ยง โรงพยาบาลทองแสนขัน" />
  <meta name="keywords" content="ระบบความเสี่ยง , โรงพยาบาลทองแสนขัน , ระบบความเสี่ยงโรงพยาบาลทองแสนขัน , laravel ,ทองแสนขัน ,อุตรดิตถ์" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  @include('layouts/js')
  @include('layouts/css')
  @include('layouts/fn')

</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php
// --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  ------------------------------------------
$arr_user_level=array();
if( !empty(Auth::user()->user_level))
{
  if(count(Auth::user()->user_level) > 0 )
  {
    foreach( Auth::user()->user_level as $kk => $vv)
    {
      $arr_user_level[]=$vv->level_id;
    }
  }
}
else {

}
?>
<div class="wrapper">

@include('layouts/header')



@include('layouts/side-left')



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  @include('layouts/content')
  </div>
  <!-- /.content-wrapper -->
  @include('layouts/footer')



  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


</body>

</html>
