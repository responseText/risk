@extends('layouts.page')

@section('content')
@include('layouts/function')

<script type="text/javascript" src="../../AdminLTE-2.4.5/bower_components/datatables.net/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="../../AdminLTE-2.4.5/bower_components/datatables.net/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../../AdminLTE-2.4.5/bower_components/datatables.net/js/jszip.min.js"></script>
<script type="text/javascript" src="../../AdminLTE-2.4.5/bower_components/datatables.net/js/pdfmake.min.js"></script>
<script type="text/javascript" src="../../AdminLTE-2.4.5/bower_components/datatables.net/js/vfs_fonts.js"></script>
<script type="text/javascript" src="../../AdminLTE-2.4.5/bower_components/datatables.net/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="../../AdminLTE-2.4.5/bower_components/datatables.net/js/buttons.print.min.js"></script>


<!--
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
-->
<!--
<script type="text/javascript" src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
-->

<!--
https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js
https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js
https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js
https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js
-->

  <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
          <div class="panel-heading"><h3>รายงานสรุปจำนวนอุบัติการณ์ตามโปรแกรมความเสี่ยง</h3></div>
          <div class="box-body">
            <h4><?=$data_title[0]->RiskProgramName?>&nbsp;&nbsp;::&nbsp;หมวด&nbsp;<?=$data_title[0]->IncidentGroupName?></h4><hr>

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
                        <li><a href="witness/exportExcel/"><i class="fa fa-file-excel-o"></i>ส่งออก EXCEL</a></li>

                    </ul>
                  </div>
                </div>
              </div>
            </div>
-->
            <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover table-responsive" >
                  <thead>
                    <tr>

                      <th class="text-center" width="10%">เกิดขึ้นเมื่อ</th>
                      <th class="text-center">ชื่ออุบัติการณ์</th>
                      <th class="text-center">เหตุการณ์</th>

                      <th class="text-center">ประเภทความเสี่ยง</th>
                      <th class="text-center">ความรุนแรง</th>
                      <th class="text-center">ผู้พบเห็น</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                     if(count($data)==0 )
                     {
                    ?>
                    <tr>
                      <td colspan="7" class="text-center">
                        <div class="alert-danger text-center">
                          ไม่พบข้อมูล.
                        </div>
                      </td>

                    </tr>
                    <?php
                    }
                    else
                    {
                      $i=1;
                      foreach ( $data as $rs)
                      {


                    ?>
                    <tr>

                      <td>
                        <?php echo $rs->incident_date;?>&nbsp;<?php echo showTime($rs->incident_time);?>&nbsp;น.
                      </td>
                      <td>
                        <a href="<?=route('reports.riskprogram.detail',[$rs->id])?>"  target="_blank">  <?php echo wordwrap($rs->incident_title, 200, '<br>');?></a>

                      </td>
                      <td>
                        <?php echo wordwrap($rs->incident_event, 350, '<br>');?>

                      </td>
                      
                      <td><?php echo $rs->typerisk->name;?></td>
                      <td>
                        <strong style="color:<?php echo  $rs->violence->violence_level->color;?> ;">
                          <?php echo $rs->violence->code;?>
                        </strong> &nbsp;&nbsp;
                        <i class="fa fa-line-chart" style="color:<?php echo  $rs->violence->violence_level->color;?> ;"></i>

                      </td>
                      <td>
                        <?php
              				          if(empty($rs->emloyee_discover->fname))
                                {
                                  echo '<span class="bg-red">ผู้เห็นเหตุการณ์นี้ถูกลบออกจากระบบ</span>';
                                }
                                else
                                {
                                  echo $rs->emloyee_discover->prefix->name.$rs->emloyee_discover->fname.'   '.$rs->emloyee_discover->lname;
                                }
              				  //echo $rs->employee->prefix->name.$rs->employee->fname.'   '.$rs->employee->lname;
              				  ?>

                      </td>
                    </tr>
                    <?php
                        $i++;
                      }
                    }
                    ?>
                  </tbody>
                </table>

            </div>









          </div>
        </div>
      </div>
  </div>

  <script type="text/javascript">
$(function () {

  var table =$('#example2').DataTable({
    /*dom: 'fBrtip',*/
  /*  "dom": 'Blfrtip',*/
  // "dom": '<"top"i>rt<"bottom"flp><"clear">',
  "dom": '<"top"flB>rt<"clear"><"bottom"ip><"clear">',

    buttons: [
                    { extend: 'copy', className: 'btn btn-primary' },
                    { extend: 'excel', className: 'btn btn-primary' },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A3' ,
                        className: 'btn btn-primary'
                    },
                    { extend: 'print', className: 'btn btn-primary' }

                ],

    "scrollX": true,
    "scrollY": true,
    "order": [[ 0, "desc" ]],

    'lengthMenu': [[10, 25, 50,100,150,200,300,-1], [10, 25, 50,100,150,200,300, "ทั้งหมด" ]],
    'responsive': true ,
    //paging: false,
    //searching: false,
    /*
    "language": {
          "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
      }
      */
      "language": {
              /*"url": 'lang/th.json'*/
              "url": '../../js/lang/th.json'
          }


   });


});


  </script>
@endsection
