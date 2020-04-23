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
  //echo $urlse_date;

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

          <form action="{{route('reports.riskprogram')}}" method="POST">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right "  name="filterdaterage" id="filterdaterage" value="">
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
                <select id="riskprogram" name="riskprogram" class="select2 form-control">
                    <option value="">*** โปรแกรมความเสี่ยง ***</option>
                    <?php
                    foreach( $riskprogram as $rs )
                    {
                    ?>
                    <option value="{{$rs->id}}" <?php if($riskprogram_id==$rs->id){ echo 'selected="selected"';}?>>{{$rs->name}}</option>

                    <??>
                    <?php
                    }
                    ?>
                  </select>
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
        รายงานสรุปจำนวนอุบัติการณ์ตามโปรแกรมความเสี่ยง
      </div>
    </div>
  </div>
</div>
  <?php
  //if(isset($data))
  //{
  ?>
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
            <li><a href="riskprogram/exportExcel/<?=$riskprogram_id?>/<?=$urlse_date?>"><i class="fa fa-file-excel-o"></i>ส่งออก EXCEL</a></li>

        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-primary">
        <div class="box-body">

          <form id="myFormMain" action="{{route('reports.riskprogram.list-main')}}" method="post" target="_blank">
            <input type="hidden" name="_method" value="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="inputUrlSEDate" name="inputUrlSEDate" value="<?=$urlse_date?>">
            <input type="hidden" id="inputGroupID" name="inputGroupID" value="">
          </form>
          <form id="myFormSub" action="{{route('reports.riskprogram.list-sub')}}" method="post" target="_blank">
            <input type="hidden" name="_method" value="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="inputUrlSEDate" name="inputUrlSEDate" value="<?=$urlse_date?>">
            <input type="hidden" id="inputGroupID" name="inputGroupID" value="">
            <input type="hidden" id="inputViolenceID" name="inputViolenceID" value="">
          </form>
          <div class="table-responsive">
            <table class="" border="1" width="100%">
              <thead>


                  <tr>
                    <td width="4%" rowspan="3" align="center" valign="middle">ลำดับ</td>
                    <td width="25%" rowspan="3" align="center" valign="middle">เรื่อง</td>
                    <td width="5%" rowspan="3" align="center" valign="middle">จำนวน</td>
                    <td colspan="13" align="center" valign="middle">ระดับความรุนแรง</td>
                    <td width="27%" rowspan="3" align="center" valign="middle">รวมทั้งหมดจากอุบัติการณ์</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center" valign="middle">เกือบพลาด</td>
                    <td colspan="3" align="center" valign="middle">น้อย</td>
                    <td colspan="3" align="center" valign="middle">ปานกลาง</td>
                    <td colspan="4" align="center" valign="middle">มาก</td>
                  </tr>
                  <tr>
                    <td width="4%" align="center" valign="middle">A</td>
                    <td width="4%" align="center" valign="middle">B</td>
                    <td width="4%" align="center" valign="middle">ก</td>
                    <td width="3%" align="center" valign="middle">C</td>
                    <td width="3%" align="center" valign="middle">D</td>
                    <td width="2%" align="center" valign="middle">น</td>
                    <td width="4%" align="center" valign="middle">E</td>
                    <td width="4%" align="center" valign="middle">F</td>
                    <td width="4%" align="center" valign="middle">ป</td>
                    <td width="3%" align="center" valign="middle">G</td>
                    <td width="3%" align="center" valign="middle">H</td>
                    <td width="2%" align="center" valign="middle">I</td>
                    <td width="2%" align="center" valign="middle">ม</td>
                  </tr>
                    </thead>
                  <?php
                  $i=1;
                  $A1 =0;
                  $A2 =0;
                  $A3 =0 ; $A4 =0 ; $A5 =0 ; $A6 =0  ; $A7 =0 ; $A8 =0 ; $A9 =0 ; $A10 =0 ; $A11 =0  ; $A12 =0  ; $A13 =0;
                  $AAA=0;
                  foreach($rs_data_riskprogram as $rs_data)
                  {
                  ?>
                  <tr>
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td valign="middle">
                      <a href="" class="info_link" data-programid="<?php echo $rs_data->id;?>">
                      <?php echo $rs_data->name;?>
                      </a>

                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->AA_total !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link" data-programid="<?php echo $rs_data->id;?>">
                        <?php echo $rs_data->AA_total; ?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>

                    </td>
                    <td align="center" valign="middle">
                        <?php
                        if($rs_data->AA !='0')
                        {
                        ?>
                        <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="1">
                          <?php echo $rs_data->AA; $A1=$A1+$rs_data->AA;?>
                        </a>
                        <?php
                        }
                        else
                        {
                          echo '0';
                        }
                        ?>
                      </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->AB !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="2">
                        <?php echo $rs_data->AB; $A2=$A2+$rs_data->AB;?>
                      <a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->Aก !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="13">
                        <?php echo $rs_data->Aก; $A3=$A3+$rs_data->Aก;?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->AC !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="3">
                        <?php echo $rs_data->AC; $A4=$A4+$rs_data->AC;?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->AD !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="4">
                        <?php echo $rs_data->AD; $A5=$A5+$rs_data->AD;?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->Aน !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="10">
                        <?php echo $rs_data->Aน; $A6=$A6+$rs_data->Aน;?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->AE !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="5">
                        <?php echo $rs_data->AE; $A7=$A7+$rs_data->AE;?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->AF !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="6">
                        <?php echo $rs_data->AF; $A8=$A8+$rs_data->AF;?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->Aป !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="11">
                        <?php echo $rs_data->Aป; $A9=$A9+$rs_data->Aป; ?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                      </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->AG !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="7">
                        <?php echo $rs_data->AG; $A10=$A10+$rs_data->AG;?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>

                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->AH !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="8">
                        <?php echo $rs_data->AH; $A11=$A11+$rs_data->AH;?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>

                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->AI !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="9">
                        <?php echo $rs_data->AI; $A12=$A12+$rs_data->AI;?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                    </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->Aม !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link2" data-programid="<?php echo $rs_data->id;?>" data-violenceid="12">
                        <?php echo $rs_data->Aม; $A13=$A13+$rs_data->Aม;?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                      </td>
                    <td align="center" valign="middle">
                      <?php
                      if($rs_data->AA_total !='0')
                      {
                      ?>
                      <a href="javascript:void(0);" class="info_link" data-programid="<?php echo $rs_data->id;?>">
                        <?php echo $rs_data->AA_total; ?>
                      </a>
                      <?php
                      }
                      else
                      {
                        echo '0';
                      }
                      ?>
                    </td>
                  </tr>
                  <?php
                  $i++;
                  }
                  ?>

                  <tr>
                    <td colspan="3" align="center" valign="middle">รวมระดับความรุนแรงตามระดับ</td>

                    <td align="center" valign="middle"><?php echo $A1;?></td>
                    <td align="center" valign="middle"><?php echo $A2;?></td>
                    <td align="center" valign="middle"><?php echo $A3;?></td>
                    <td align="center" valign="middle"><?php echo $A4;?></td>
                    <td align="center" valign="middle"><?php echo $A5;?></td>
                    <td align="center" valign="middle"><?php echo $A6;?></td>
                    <td align="center" valign="middle"><?php echo $A7;?></td>
                    <td align="center" valign="middle"><?php echo $A8;?></td>
                    <td align="center" valign="middle"><?php echo $A9;?></td>
                    <td align="center" valign="middle"><?php echo $A10;?></td>
                    <td align="center" valign="middle"><?php echo $A11;?></td>
                    <td align="center" valign="middle"><?php echo $A12;?></td>
                    <td align="center" valign="middle"><?php echo $A13;?></td>
                    <td align="center" valign="middle"><?php $AAA= ($AAA+$A1+$A2+$A3+$A4+$A5+$A6+$A7+$A8+$A9+$A10+$A11+$A12+$A13 ) ; echo $AAA;  ?></td>
                  </tr>
                </table>
          </div>
        <div>
      </div>
    </div>
</div>

</div>
</div>
<?php
//}
?>

<script>
function print_preview()
{

  print();

}


function ajax_sendMain()
{

  //$('#myFormMain').
}



$(function () {
  $('.info_link').click(function(){
     //alert($(this).text());
     //console.log( $(this).data('programid') );
     $('#myFormMain #inputGroupID').val( $(this).data('programid') );
      $('#myFormMain').submit();


   });
   $('.info_link2').click(function(){
      //alert($(this).text());
      //console.log( $(this).data('programid') );
      $('#myFormSub #inputGroupID').val( $(this).data('programid') );
      $('#myFormSub #inputViolenceID').val( $(this).data('violenceid') );
      //alert( $('#myFormMain #inputViolenceID').val() );
      //alert( $(this).data('violenceid') );
       $('#myFormSub').submit();


    });
  $('#filterdaterage').daterangepicker({
     locale:{
         cancelLabel: 'ลบ' ,
         applyLabel: 'ตกตง',
         locale: 'th',

     }
  }).val("<?=$data_date?>");

$('form').submit(function(){
  if( $('#riskprogram').val() =='' )
  {
    alert('กรุณาเลือกโปรแกรมความเสี่ยง');
    $('#riskprogram').focus();
    return false;
  }
});


  $('.select2').select2();
});
</script>
@endsection
