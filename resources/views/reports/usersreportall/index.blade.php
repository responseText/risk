@extends('layouts.page')

@section('content')
@include('layouts/function')
<?php
$data_date = '';

$urlsubdivision=0;

if(isset($_POST))
{

  //-------------------------------------------------
/*
  if(!empty($_POST['subdivision']))
  {

      foreach ($_POST['subdivision'] as  $value) {
        $arr_subdivision[] = $value;
        //echo $value.'<br>';
        //$urlsubdivision.=$value.'-';
      }

      $urlsubdivision=implode('-',$arr_subdivision);
  }
*/


  //--------------------------------------------------
  if(!empty($_POST['filterdaterage']))
  {
    $data_date =$_POST['filterdaterage'];
  }
  else
  {
    $data_date = '';
  }
  //-----------------------------------------------------
  $urlse_date='';
  if($url_date!='' || !empty($url_date))
  {
  list($s_date,$e_date) =  explode("_" ,$url_date);

  $p_date1 = explode("-", $s_date);
  $ss_date1 = $p_date1[2].'-'.$p_date1[1].'-'.$p_date1[0];

  $p_date2 = explode("-", $e_date);
  $ee_date2 = $p_date2[2].'-'.$p_date2[1].'-'.$p_date2[0];
  $urlse_date=$ss_date1.'_'.$ee_date2;
  }
}
?>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="alert alert-info alert-dismissible" role="alert">
       <h4><i class="icon fa fa-info"></i> ข้อความระบบ!</h4>
      รายงานนี้คิดจากกรณีความเสี่ยงที่ กรรมการความเสี่ยง ได้ทำการส่งความเสี่ยงให้หัวหน้ากลุ่มงานแล้ว  ไม่ว่าหัวหน้ากลุ่มงานจะ <strong class="text-danger">รับหรือไม่รับ</strong>ความเสี่ยง รายงานความเสี่ยงรายงานนี้ก็จะนำมาคิดด้วย
    </div>
  </div>
</div>




<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

      <div class="box box-primary">

        <div class="box-body">

          <form action="{{route('reports.usersreportall')}}" method="POST">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="box box-primary">

                  <div class="box-body">

                    <form action="{{route('reports.subdivisiondetail')}}" method="POST">
                      <input type="hidden" name="_method" value="POST">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 ">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right "  name="filterdaterage" id="filterdaterage" value="">
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
                        <select id="division" name="division" class="select2 form-control">
                            <option value="">*** กลุ่มงาน ***</option>
                            <?php
                            foreach( $division as $rs )
                            {
                            ?>
                            <option value="{{$rs->id}}" <?php if($division_id==$rs->id){ echo 'selected="selected"';}?>>{{$rs->name}}</option>

                            <??>
                            <?php
                            }
                            ?>
                          </select>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
                        <select id="subdivision" name="subdivision" class="select2 form-control" data-subdivision="<?=$subdivision_id?>">
                            <option value="" >***โปรดเลือกหน่วยงาน***</option>
                          </select>
                      </div>
                        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 ">
                          <button type="submit" name="button" class="btn btn-primary btn-block">ค้นหา</button>
                        </div>

                    </div><!-- /.row -->
                    </form>

                  </div><!-- /.box-body -->
                </div> <!-- .box box-primary   -->

              </div><!-- .col-xs-12 col-sm-12 col-md-12 col-lg-12   -->
          </div>


          </form>

        </div><!-- /.box-body -->
      </div> <!-- .box box-primary   -->

    </div><!-- .col-xs-12 col-sm-12 col-md-12 col-lg-12   -->
</div>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="box box-primary">
      <div class="box-body">

        รายงาน เจ้าหน้าที่ที่มีการรายงานสูงสุดแบบกลุ่มตามหน่วยงาน
      </div>
    </div>
  </div>
</div>
  <?php
  if(isset($data))
  {
  ?>
  <!--
<div class="row">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="margin pull-right">
      <div class="btn-group pull-right">
        <button type="button" class="btn btn-default"><i class="fa fa-gear"></i></button>
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
          <li><a href="javascript:print_preview();"><i class="fa fa-print"></i>พิมพ์</a></li>


        </ul>
      </div>
    </div>
  </div>
</div>
-->
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="box box-primary">
      <div class="box-body">
        <table id="datatable" class="table table-bordered table-hover table-responsive display nowrap"  style="width:100%" >
          <thead>
          <tr class="table-primary  bg-primary text-center">
            <th class="text-center" width="45%">เจ้าหน้าที่</th>
            <th class="text-center" width="45%">หน่วยงาน</th>

            <th class="text-center"width="10%">จำนวน(ครั้ง)</th>

          </tr>
          </thead>
          <tbody>
            <?php
            if( count($data) <= 0 )
            {
            ?>
            <tr>
              <td colspan="3" class="text-center bg-red"> <?=trans('system.not_found')?> </td>
            </tr>
            <?php
            }
            else
            {
            ?>
              <?php
              foreach ( $data as $rs )
              {
              ?>
              <tr>
                <td >
                  <?php echo $rs->EmployeeName; ?>

                </td>
                <td >
                  <?php echo $rs->DivisionName; ?>

                </td>

                <td class="text-center" > <?php echo $rs->CountPost; ?></td>

              </tr>

              <?php
              }
              ?>
            <?php
            }
            ?>

          </tbody>

        </table>

      </div>
    </div>

  </div>
</div>




<?php
}
?>

<script>
function print_preview()
{

  print();

}
$(function () {
  var subdivision_id=$('#subdivision').data('subdivision');
  var division_id = $('#division').val();
  if(division_id != '' || division_id !== 'undefined')
  {
    $("#subdivision").empty().append('<option value="">***หน่วยงาน***</option>');//ล้างข้อมูล

    $.get('{{ url('reports/usersreportall') }}/getsubdivision/'+division_id , function(data) {
      $('#subdivision')
          .empty()
          .append('<option value="">***หน่วยงาน***</option>');
          $.each( data , function (i, item) {

                  $('#subdivision').append( $("<option >", {
                      value: item.id,
                      text : item.name
                  }));
          });

          $('#subdivision option[value="'+subdivision_id+'"]').attr('selected','selected');
          /*
          if( arr.length > 0 )
          {
            $.each(arr, function( index, value ) {
              $('#subdivision option[value="'+value+'"]').attr('selected','selected');
            });
          }
          */
    });

  }

  $("#division").change(function(){

    $("#subdivision").empty().append('<option value="">***โปรดเลือกหน่วยงาน***</option>');//ล้างข้อมูล

    var division_id ;
    division_id = $('#division').val();
    $.get('{{ url('reports/usersreportall') }}/getsubdivision/'+division_id , function(data) {
      //alert(data);

      $('#subdivision')
          .empty()
          .append('<option value="">***โปรดเลือกหน่วยงาน***</option>');
          $.each( data , function (i, item) {

                  $('#subdivision').append( $('<option>', {
                      value: item.id,
                      text : item.name
                  }));

          });
    });
  });
  $('#filterdaterage').daterangepicker({
     locale:{
         cancelLabel: 'ลบ' ,
         applyLabel: 'ตกตง',
         locale: 'th',

     }
  }).val("<?=$data_date?>");
  $('.select2').select2();







    var rows_selected = [];
    var table =$('#datatable').DataTable({
      "dom": '<"top"B>rt<"clear"><"bottom"><"clear">',

          buttons: [
                          { extend: 'copy', className: 'btn btn-primary' },
                          {

                            extend: 'excel',
                            className: 'btn btn-primary'
                          },
                          {
                              extend: 'pdfHtml5',
                              orientation: 'landscape',
                              pageSize: 'A4' ,
                              className: 'btn btn-primary'
                          },
                          { extend: 'print', className: 'btn btn-primary' }

                      ],

          "scrollX": true,
          "scrollY": true,
    'columnDefs':
    [
      {
       'targets': 0,
       'searchable':false,
       'orderable':false,

      }
      ,

      {
        'targets': 1,
        'searchable':false,
        'orderable':false,
        'className': 'text-left'
      },
      {
        'targets': 2,
        'searchable':false,
        'orderable':false,
        'className': 'text-center'
      }
    ],

    'rowCallback': function(row, data, dataIndex){
         // Get row ID
         var rowId = data[0];

         // If row ID is in the list of selected row IDs
         if($.inArray(rowId, rows_selected) !== -1){
            $(row).find('input[type="checkbox"]').prop('checked', true);
            $(row).addClass('selected');
         }
      },
      "order": [[ 1, "asc" ]],
   "aLengthMenu": [100],

      'responsive': true ,
      'paging': false,
      'searching': false,
      /*
      "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        }
        */
        "language": {
                /*"url": 'lang/th.json'*/
                "url": '../js/lang/th.json'
            }


     });
});
</script>
@endsection
