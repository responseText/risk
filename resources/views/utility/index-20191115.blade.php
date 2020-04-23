@extends('layouts.page')
@section('title','อรรถประโยชน์' )
@section('content')
@include('layouts/function')
<script src="{{asset('/jojosati-bootstrap-datepicker-thai/js/bootstrap-datepicker1.js')}}"></script>
<script src="{{asset('/jojosati-bootstrap-datepicker-thai/js/bootstrap-datepicker-thai1.js')}}"></script>
<script src="{{asset('/jojosati-bootstrap-datepicker-thai/js/bootstrap-datepicker.th1.js')}}"></script>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">

    <form class="form-horizontal" id="myFormAlert">
      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">แจ้งเตือนหน่วยงานไม่ได้รายงานความเสี่ยง </h3>
        </div>
        <div class="box-body">


              <div class="form-group">
                <label for="inputEmail3" class="col-lg-2 col-md-2 control-label">เดือน</label>
                <div class="col-lg-10 col-md-10">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right col-lg-6 col-md-6" name ="incident_date" id="incident_date"  value="{{old('incident_date')}}">

                  </div>

                </div>
              </div>
        </div><!-- /.box-body -->
        <div class="box-footer">

               <button type="button" class="btn btn-primary btn-block">แจ้งเตือน</button>
       </div><!-- /.box-footer -->

      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function () {
  $('.select2').select2();
  $('#incident_date').datepicker({

    viewMode: 'months',
   format: 'MM-yyyy',
   minViewMode: "months",
    autoclose: true,
    language: 'th-th',
  });
  $('#myFormAlert button').click(function(){
      if($('#myFormAlert #incident_date').val()=='' )
      {
        alert('กรุณาเลือกช่วงเวลาที่ต้องการ.');
      }
      else{
        //var js_vars ;
        //js_vars = $('#myFormAlert #incident_date').val();
        if(confirm('คุณต้องการแจ้งเตือนการคีย์ความเสี่ยง'))
        {
          $.post('{{ url('utility') }}/alertnotkey' ,$( "#myFormAlert" ).serialize() , function(data) {

            if(data.status=='true')
            {
              alert('ระบบได้ทำการส่งการแจ้งเตือนเรียบร้อยแล้ว.');
            }

          });

        }
        else
        {
          return false;

        }

      }
  });


});

</script>
@endsection
