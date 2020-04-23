

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
    <table>
      <tr>
        <td>รายงานความเสี่ยงอุบัติการณ์ทั่วไป</td>
      </tr>
    </table>
    <table>
       <thead>

       <tr>
         <th class="text-center">วันที่เกิด</th>
         <th class="text-center">กลุ่มงานที่รับผิดชอบ</th>
         <th class="text-center">หน่วยงานที่รับผิดชอบ</th>
         <th class="text-center">หมวดหมู่อุบัติการณ์</th>
         <th class="text-center">รายการอุบัติการณ์</th>
         <th class="text-center">ประเภทความเสี่ยง</th>
         <th class="text-center">ระดับความรุนแรง</th>
         <th class="text-center">เกิดขึ้นกับ</th>
         <th class="text-center">ผู้พบเห็น</th>
         <?php
         if( Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
         {
         ?>
         <th class="text-center">ผู้เขียน</th>
         <?php
          }
         ?>

         <th class="text-center">ชื่อเหตุการณ์</th>
         <th class="text-center">สถานที่เกิดเหตุ</th>
         <th class="text-center">เหตุการณ์</th>
         <th class="text-center">การจัดการเบื้องต้น</th>
         <th class="text-center">ข้อเสนอแนะ</th>
         <th class="text-center">การแก้ไข-หัวหน้างาน</th>
         <th class="text-center">ข้อเสนอแนะ-หัวหน้างาน</th>
         <th class="text-center">การแก้ไข-คณะกรรมการ RM</th>
         <th class="text-center">ข้อเสนอแนะ-คณะกรรมการ RM</th>

       </tr>


       <?php
         ?>
       </thead>
       <tbody>
         <?php
         if( count($data) < 0 )
         {
         ?>
         <tr>
           <td colspan="6" class="text-center bg-red"> ไม่พบข้อมูล </td>
         </tr>
         <?php
         }
         else
         {
         ?>
         <tr>
           <td colspan="6">
             <strong class="text-muted">
               <?php

                 echo 'รายงานอุบัติการทั้งหมด';

               ?>


               <?php echo count($data);?>  รายการ </strong>

           </td>
         </tr>

         <?php
           foreach ( $data as $rs )
           {
         ?>
         <tr>
           <td><?php echo $rs->incident_date;?>&nbsp;<?php echo $rs->incident_time;?> </td>
           <td><?php echo $rs->division->name?></td>
           <td><?php echo $rs->subdivision->name?></td>
           <td><?php echo $rs->incident_group->name?></td>
           <td>
             <?php
             if( $rs->incident_list_id=='' )
             {
               echo '-';
             }
             else
             {
               if( $rs->incident_list_id== '' )
               {
                 echo '-';
               }
               else
               {
                 if(empty($rs->incident_list->id))
                 {
                   echo '<strong class="bg-red">*** รายการนี้ถูกลบออกจากระบบ ***</strong>' ;
                 }
                 else
                 {
                   echo $rs->incident_list->name;
                 }
               }
             }
             ?>
           </td>
           <td><?php echo $rs->typerisk->name?></td>
           <td><?php echo $rs->violence->name?></td>
           <td><?php echo $rs->effect->name?></td>
           <td>
          <?php
           if(empty($rs->employee->fname))
           {
             echo '<span class="bg-red">ผู้เห็นเหตุการณ์นี้ถูกลบออกจากระบบ</span>';
           }
           else
           {
             echo $rs->employee->prefix->name.$rs->employee->fname.'   '.$rs->employee->lname;
           }
           ?>
           </td>
           <?php
           if( Auth::user()->level_id == '1' || Auth::user()->level_id == '2')
           {
           ?>
           <td>
             <?php
             if(empty($rs->writeByID->employee->fname))
             {
               echo '<span class="bg-red">ผู้เขียนเหตุการณ์นี้ถูกลบออกจากระบบ</span>';
             }
             else
             {
               echo $rs->writeByID->employee->prefix->name.$rs->writeByID->employee->fname.'   '.$rs->writeByID->employee->lname;
             }
             ?>
           </td>

           <?php
            }
           ?>




           <td><?php echo $rs->incident_title;?></td>
           <td><?php echo $rs->incident_place;?></td>
           <td><?php echo $rs->incident_event;?></td>
           <td><?php if($rs->incident_edit=''){echo '';}else{echo $rs->incident_edit;}?></td>
           <td><?php if($rs->incident_propersal==''){echo '';}else{  echo $rs->incident_propersal;}?></td>

           <td><?php if($rs->headdivision_edit==''){echo '';}else{ echo $rs->headdivision_edit;}?></td>
           <td><?php if($rs->headdivision_propersal==''){echo '';}else{ echo $rs->headdivision_propersal;}?></td>
           <td><?php if($rs->headrm_review_edit==''){echo '';}else{echo $rs->headrm_review_edit;}?></td>
           <td><?php if($rs->headrm_review_propersal==''){echo '';}else{echo $rs->headrm_review_propersal;}?></td>

         </tr>
         <?php
           }
         }
         ?>

       </tbody>
   </table>
  </body>
</html>
