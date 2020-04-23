

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style media="screen">
      @font-face{
        font-family: 'THSarabun';
        font-style: normal;
        font-weight: normal;
        src: url("{{asset('fonts/THSarabun.ttf')}}") format('truetype');
      }
      @font-face{
        font-family: 'THSarabun';
        font-style: normal;
        font-weight: Bold;
        src: url("{{asset('fonts/THSarabun Bold.ttf')}}") format('truetype');
      }
      @font-face{
        font-family: 'THSarabun';
        font-style: italic;
        font-weight: normal;
        src: url("{{asset('fonts/THSarabun Italic.ttf')}}") format('truetype');
      }
      @font-face{
        font-family: 'THSarabun';
        font-style: italic;
        font-weight: Bold;
        src: url("{{asset('fonts/THSarabun Bold Italic.ttf')}}") format('truetype');
      }
      body{
        font-family: "THSarabun";
      }
      table{
        border-collapse: collapse;
      }
      td,th{
        border:1px solid;
      }
    </style>

  </head>
  <body>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
          <div class="box-body">
            รายงานสรุปจำนวนอุบัติการณ์ตามโปรแกรมความเสี่ยง
          </div>
        </div>
      </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="box box-primary">
            <div class="box-body">

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
                <tbody>
                  <?php
                  $i=1;
                  $A1 =0;
                  $A2 =0;
                  $A3 =0 ; $A4 =0 ; $A5 =0 ; $A6 =0  ; $A7 =0 ; $A8 =0 ; $A9 =0 ; $A10 =0 ; $A11 =0  ; $A12 =0  ; $A13 =0;
                  $AAA=0;
                  foreach($data as $rs_data)
                  {
                  ?>
                  <tr>
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td valign="middle">

                      <?php echo $rs_data->name;?>


                    </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->AA_total; ?>

                    </td>
                    <td align="center" valign="middle">

                          <?php echo $rs_data->AA; $A1=$A1+$rs_data->AA;?>

                      </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->AB; $A2=$A2+$rs_data->AB;?>

                    </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->Aก; $A3=$A3+$rs_data->Aก;?>

                    </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->AC; $A4=$A4+$rs_data->AC;?>

                    </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->AD; $A5=$A5+$rs_data->AD;?>

                    </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->Aน; $A6=$A6+$rs_data->Aน;?>

                    </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->AE; $A7=$A7+$rs_data->AE;?>

                    </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->AF; $A8=$A8+$rs_data->AF;?>

                    </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->Aป; $A9=$A9+$rs_data->Aป; ?>

                      </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->AG; $A10=$A10+$rs_data->AG;?>


                    </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->AH; $A11=$A11+$rs_data->AH;?>


                    </td>
                    <td align="center" valign="middle">


                        <?php echo $rs_data->AI; $A12=$A12+$rs_data->AI;?>


                    </td>
                    <td align="center" valign="middle">


                        <?php echo $rs_data->Aม; $A13=$A13+$rs_data->Aม;?>

                      </td>
                    <td align="center" valign="middle">

                        <?php echo $rs_data->AA_total; ?>

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


                </tbody>
              </table>
              </div>
            <div>
          </div>
        </div>
    </div>

    </div>
    </div>


  </body>
</html>
