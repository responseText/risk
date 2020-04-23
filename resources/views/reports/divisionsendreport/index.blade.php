@extends('layouts.page')

@section('content')
@include('layouts/function')
<?php
$data_date = '';
$arr_subdivision = array();
//$division = '';
if(isset($_POST))
{

  //-------------------------------------------------
  if(!empty($_POST['subdivision']))
  {

      foreach ($_POST['subdivision'] as  $value) {
        $arr_subdivision[] = $value;
        //echo $value.'<br>';
      }
  }
  //--------------------------------------------------
  if(!empty($_POST['filterdaterage']))
  {
    $data_date =$_POST['filterdaterage'];
  }
  else
  {
    $data_date = '';
  }

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
  echo $urlse_date;

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

          <form action="{{route('reports.divisionsendreport')}}" method="POST">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right "  name="filterdaterage" id="filterdaterage" value="">
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 ">
                <button type="submit" name="button" class="btn btn-primary btn-block">ค้นหา</button>
              </div>

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
        รายงานกลุ่มงานที่รายงานอุบัติการณ์สูงสุด
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
            <li><a href="divisionsendreport/exportExcel/<?=$urlse_date?>"><i class="fa fa-file-excel-o"></i>ส่งออก EXCEL</a></li>

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
              <tr>
                <th class="text-center" width="80%">กลุ่มงาน</th>
                <th class="text-center" width="20%">จำนวน(ครั้ง)</th>
              </tr>
              </thead>
              <tbody>

              <?php
                foreach ( $data as $rs )
                {
              ?>
              <tr>
                <td >
                  <?php echo $rs->name_depart; ?>

                </td>

                <td class="text-center" > <?php echo $rs->count1; ?></td>

              </tr>

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
    "order": [[ 0, "asc" ]],
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
