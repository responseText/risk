@extends('layouts.page')
@section('title','ผู้ใช้งานระบบ' )
@section('content')
@include('layouts/function')
<form class="form-horizontal" action="{{route('users.store')}}"  method="post">

  <input type="hidden" name="_method" value="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="box">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('buttons.add');?>ผู้ใช้งานระบบ </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">

      <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
          <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">ผู้ใช้งานระบบ</label>

          <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">

              @if ($errors->has('name'))
                  <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
          </div>
        </div>

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









        <div class="form-group {{ $errors->has('employee') ? ' has-error' : '' }}">
            <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label">เจ้าหน้าที่</label>

            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
              <select id="employee" name="employee" class="select2 form-control">
                  <option value="">***เจ้าหน้าที่***</option>
                  <?php
                  foreach( $rs_employee as $rs )
                  {
                  ?>
                  <option value="{{$rs->id}}" <?php if ($rs->id == old('employee')){ echo 'selected="selected"';}?>>
                    <?php echo $rs->prefix->name.$rs->fname.'  '. $rs->lname; ?>
                  </option>

                  <??>
                  <?php
                  }
                  ?>
                </select>

                @if ($errors->has('employee'))
                    <span class="help-block">
                        <strong>{{ $errors->first('employee') }}</strong>
                    </span>
                @endif
            </div>


        </div>
<style>
.row{ margin:5px 5px 5px 5px;}
.r1{ margin:20px 20px 20px 20px;}
.c1{ padding:5px 5px 5px 5px;}
</style>

        <div class="form-group">
          <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label"></label>
          <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">

            <a href="javascript:void(0);" id="abc" class="btnAdd btn btn-primary"> <i class="fa fa-plus"></i> เพิ่ม </a>
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-3 col-md-3 col-sm-6 col-xs-12 control-label"></label>
          <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">

            <div id="idTemp"></div>
          </div>
        </div>


















      </div><!-- /.box-body -->
      <div class="box-footer">
        <a href="{{route('users.index')}}" class="btn btn-md btn-default">
            <i class="fa fa-btn fa-reply"></i> {{trans('buttons.cancel')}}
        </a>
        <button class="btn btn-primary btn-md pull-right" type="submit"  name="btnOK">{{trans('buttons.save')}}</button>

      </div><!-- /.box-footer -->


</div><!-- /.box -->
</form>
<script type="text/javascript">
$(function(){


///$('#area_division').hide();
    $('.select2').select2();

    var x = 0;
    var i = 0;
    $('.btnAdd').click(function(event){
        i++;
        x++;
        if(x >= 5)
        {
            $('.btnAdd').hide();
        }
        else
        {
            $('.btnAdd').show();
        }
        //$('#idTemp').append( '<div class="row r1" id="row'+i+'"><div class="col-11 c1"><select id="level_access'+i+'" name="level_access'+i+'" class="form-control"><option value="">***ระดับผู้ใช้งาน***</option></select></div><div class="c1 col-1" id="tagdivdelete'+i+'"><a id="btnDelete'+i+'" class="btnDelete btn btn-danger" href="javascript:void(0);">-</a></div> <div id="divDivision'+i+'" class="c1 col-11 "><select id="division'+i+'" name="division'+i+'" class="form-control" style="display:none;"><option value=""></option></select></div><div class="c1 col-11"><select id="subdivision'+i+'" name="subdivision'+i+'" class="form-control" style="display:none;"><option value="">***หน่วยงาน***</option></select></div> </div>');


        $('#idTemp').append( '<div class="row r1" id="row'+i+'"><div class="col-lg-8 col-md-8 col-sm-6 col-xs-6 c1"><input type="hidden" name="checkid[]" value="'+i+'"><select id="level_access'+i+'" name="level_access'+i+'" class="select22 form-control"><option value="">***ระดับผู้ใช้งาน***</option></select></div><div id="tagdivdelete'+i+'" class="c1 col-lg-1 col-md-1 col-sm-6 col-xs-6" ><a id="btnDelete'+i+'" class="btnDelete btn btn-danger" href="javascript:void(0);">-</a></div> </div>');
//<div id="divDivision'+i+'" class="c1 col-lg-8 col-md-8 col-sm-6 col-xs-6 "><select id="division'+i+'" name="division'+i+'" class="form-control" style="display:none;"><option value=""></option></select></div><div class="c1 col-lg-8 col-md-8 col-sm-6 col-xs-6"><select id="subdivision'+i+'" name="subdivision'+i+'" class="form-control" style="display:none;"><option value="">***หน่วยงาน***</option></select></div>

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('input[name="_token"]').val()
              }
          });

          $.post('{{ url('users') }}/getlevel' , function(data) {

            $.each(data, function(key, val) {
                 $('#level_access'+i).append( $('<option>', {
                                 value: val["id"],
                                 text : val["name"]
                         }));
             });
          });
          //$('#idTemp').delegate('#level_access'+i,'change',function(event){
          $('#level_access'+i).change(function(event) {
              var aaa1 =event.target.id;
              var js_level_access_id =$('#'+aaa1).attr('id');

              var js_level_access_value   = $('#'+js_level_access_id).val() ;
              var on_id1  = js_level_access_id.substring(12);
              console.log(js_level_access_id+'   on_id ='+on_id1+'   Values = '+js_level_access_value)
              $('#divDivision'+on_id1).remove();
              $('#divSubDivision'+on_id1).remove();


              //if ( $('#'+aaa1).parents('#row'+on_id1).length) {
              //if ( $('#'+aaa1).parents('#row'+on_id1).attr('id') == 'row'+on_id1) {
                  //alert('Your clicked element is having div#hello as parent'+$('#'+aaa1).parents('#row'+on_id1).attr('id'));


                  if( js_level_access_value == '4' || js_level_access_value == '7' )
                  {

                    $('#divDivision'+on_id1).remove();
                    $('#divSubDivision'+on_id1).remove();
                    $('#idTemp #row'+on_id1).append('<div id="divDivision'+on_id1+'" class="c1 col-lg-8 col-md-8 col-sm-6 col-xs-6 "><select id="division'+on_id1+'" name="division'+on_id1+'" class="select22 form-control" ><option value=""></option></select></div>');


                      $.post('{{ url('users') }}/getdivision', function(responseText) {
                      //var obj = $.parseJSON(responseText);
                      $('#division'+on_id1).empty() .html('<option value="">***กลุ่มงาน***</option>');
                          $.each(responseText, function(key, val) {
                              $('#division'+on_id1).append( $('<option>', {
                                          value: val["id"],
                                          text : val["name"]
                              }));
                          });
                      //console.log(data);
                      });
                      event.preventDefault();

                      /*
                      $('#subdivision'+on_id1).css('display','none');
                      $('#subdivision'+on_id1).empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');
                      */

                  }
                  else if(  js_level_access_value == '5' || js_level_access_value == '8')
                  {

                    $('#divDivision'+on_id1).remove();
                    $('#divSubDivision'+on_id1).remove();
                      //alert(on_id1+' '+js_level_access_value );
                      $('#idTemp #row'+on_id1).append('<div id="divDivision'+on_id1+'" class="c1 col-lg-8 col-md-8 col-sm-6 col-xs-6 "><select id="division'+on_id1+'" name="division'+on_id1+'" class="select22 form-control" ><option value=""></option></select></div>');

                      $.post('{{ url('users') }}/getdivision', function(responseText) {
                      //var obj = $.parseJSON(responseText);
                      $('#division'+on_id1)
                        .empty()
                        .html('<option value="">***กลุ่มงาน***</option>');
                          $.each(responseText, function(key, val) {
                              $('#division'+on_id1).append( $('<option>', {
                                          value: val["id"],
                                          text : val["name"]
                              }));
                          });
                      //console.log(data);
                      });


                      $('#division'+on_id1).change(function(event){
                      //$('#idTemp').delegate('#division'+on_id1,'change',function(event){

                          //alert('this is '+on_id1);
                          var bbb1                = event.target.id;
                          var get_division_id     = $('#'+bbb1).attr('id');
                          var get_division_value  = $('#'+get_division_id).val();
                          var xxx = $(get_division_id).val();
                          $('#divSubDivision'+on_id1).remove();
                          $('#idTemp #row'+on_id1).append('<div  id="divSubDivision'+on_id1+'" class="c1 col-lg-8 col-md-8 col-sm-6 col-xs-6"><select id="subdivision'+i+'" name="subdivision'+i+'" class="form-control"><option value="">***หน่วยงาน***</option></select></div>');
                          $.post('{{ url('users') }}/getsubdivision',{ js_division_id : get_division_value}, function(responseText1) {

                          //var obj12 = $.parseJSON(responseText1);

                          $('#subdivision'+on_id1)
                              .empty()
                              .html('<option value="">***โปรดเลือกหน่วยงาน***</option>');
                              $.each( responseText1 , function (ii, iitem) {
                                      $('#subdivision'+on_id1).append( $('<option>', {
                                          value: iitem.id,
                                          text : iitem.name
                                      }));
                              });
                          });
                          event.preventDefault();

                      });


                  }
                  else
                  {

                      //$('#division'+on_id1).empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');
                      $('#divDivision'+on_id1).remove();

                    //  $('#subdivision'+on_id1).empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');
                      $('#divSubDivision'+on_id1).remove();

                  }
            //  }
              event.preventDefault();
          }); // -------- end delegate


        //getLevelAccess(i);
        // ################# Load สิทธิ์ผู้ใช้งานระบบ   ---------------------------------------------
        /*
        $.get('{{ url('users') }}/getsubdivision1' , function(data) {
         //console.log('aaa'+data);
        //$.get('getlevelaccess.php', function( data ) {

          //  var obj = $.parseJSON( data );
            $('#level_access'+i).empty() .append('<option value="">***ระดับผู้ใช้งาน***</option>');
              //  $.each(obj, function(key, val) {
               $.each(data, function(key, val) {
                    $('#level_access'+i).append( $('<option>', {
                                    value: val["id"],
                                    text : val["name"]
                            }));
                });

        });
        */
        /*
        $('#idTemp').delegate('#level_access'+i,'change',function(event){
            var aaa1 =event.target.id;
            var js_level_access_id =$('#'+aaa1).attr('id');

            var js_level_access_value   = $('#'+js_level_access_id).val() ;
            var on_id1  = js_level_access_id.substring(12);


            if( js_level_access_value == '4' || js_level_access_value == '7' )
            {
                //alert(js_level_access_value);




                $.get('getdivision.php', function(responseText) {
                var obj = $.parseJSON(responseText);
                $('#division'+on_id1).empty() .append('<option value="">***กลุ่มงาน***</option>');
                    $.each(obj, function(key, val) {
                        $('#division'+on_id1).append( $('<option>', {
                                    value: val["id"],
                                    text : val["name"]
                        }));
                    });
                //console.log(data);
                });
                $('#division'+on_id1).css('display','');
                $('#subdivision'+on_id1).css('display','none');
                $('#subdivision'+on_id1).empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');
            }
            else if( js_level_access_value == '5' || js_level_access_value == '8')
            {
                //alert(on_id1+' '+js_level_access_value );

                $.get('getdivision.php', function(responseText) {
                var obj = $.parseJSON(responseText);
                $('#division'+on_id1).empty() .append('<option value="">***กลุ่มงาน***</option>');
                    $.each(obj, function(key, val) {
                        $('#division'+on_id1).append( $('<option>', {
                                    value: val["id"],
                                    text : val["name"]
                        }));
                    });
                //console.log(data);
                });
                $('#division'+on_id1).css('display','');

                $('#idTemp').delegate('#division'+on_id1,'change',function(event){
                    //alert('this is '+on_id1);
                    var bbb1                = event.target.id;
                    var get_division_id     = $('#'+bbb1).attr('id');
                    var get_division_value  = $('#'+get_division_id).val();
                    var xxx = $(get_division_id).val();


                    $.get('getsubdivision.php',{ js_division_id : get_division_value}, function(responseText1) {

                    var obj12 = $.parseJSON(responseText1);

                    $('#subdivision'+on_id1)
                        .empty()
                        .append('<option value="">***โปรดเลือกหน่วยงาน***</option>');
                        $.each( obj12 , function (ii, iitem) {
                                $('#subdivision'+on_id1).append( $('<option>', {
                                    value: iitem.id,
                                    text : iitem.name
                                }));
                        });
                    });
                    $('#subdivision'+on_id1).css('display','');
                });

            }
            else
            {
                $('#division'+on_id1).css('display','none');
                $('#division'+on_id1).empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');
                $('#subdivision'+on_id1).css('display','none');
                $('#subdivision'+on_id1).empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');
            }
        });
        */




/*
        if(x > 1)
        {
            $('.btnDelete').show();
        }
        else
        {
            $('.btnDelete').hide();
        }
        */
    });


    $('#idTemp').delegate('.btnDelete','click',function(event){
        //alert(event.target.id);
        var aaa =event.target.id;
        var bbb = $('#'+aaa).parents().attr('id') ;
        var ccc = $('#'+bbb).parents().attr('id');
        //alert(ccc);
        x--;
        if(x == 1)
        {
            $('.btnDelete').hide();
            $('#'+ccc).remove();
            $('#'+ccc).append('');
        }
        else
        {
            $('.btnAdd').show();
            $('.btnDelete').show();
            $('#'+ccc).remove();
            $('#'+ccc).append('');
        }
    });

    /*
$( "form" ).submit(function( event ) {

  $.each( $('.select22') ,function(){
  //  console.log( $('.select22 option:not(null)').length ) ;
    //console.log( '.select22 option').first().attr("value") ;
    if( $('.select22').val() == '')
    {
      console.log('5555');
    }
  });
    event.preventDefault();
});

*/



}) ;
</script>
@endsection
