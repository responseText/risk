@extends('layouts.page')
@section('title','จัดการรูปประจำตัวผู้ใช้งาน' )
@section('content')
@include('layouts/function')

<script src="{{asset('dropzonejs/dist/dropzone.js')}}"></script>
<link rel="stylesheet" href="{{asset('dropzonejs/dist/dropzone.css')}}">
<style media="screen">

</style>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-2 col-lg-offset-2">

    <form
      action="{{ route('users.uploadimage') }}"
      enctype="multipart/form-data"
      method="POST"
      class="dropzone"
      id="myDropzone">
      <input type="hidden" name="js_id" value="<?=$id?>">
      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">


    </form>

  </div>

</div>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-2 col-lg-offset-2">

<p class="bg-red text-center">** รองรับรูปภาพนามสกล .jpg .jpeg .png .gif เท่านั้น. **<br>
  ** ขนาดไฟล์รูปภาพไม่เกิน 1 MB. **
</p>
  </div>

</div>

<script type="text/javascript">

Dropzone.options.myDropzone = {
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 10, // MB
  maxFiles:1,
  url : '<?=route('users.uploadimage')?>',
  method:'POST',

  uploadprogress: function(file, progress, bytesSent) {
    // Display the progress
    //console.log(file);
  },
  sending:function(file, xhr, formData) {
  // Will send the filesize along with the file as POST data.
    formData.append("js_id", "hellowold");
    //console.log( formData );
},
complete:function(){
  window.location.href ="<?=route('users.show1',$id)?>";
}

};

</script>
@endsection
