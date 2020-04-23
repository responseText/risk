

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
    <title>รายงานอุบัติการแยกตามหน่วยงาน ทั้งหมด <?=count($data)?> รายการ</title>
  </head>
  <body>
    <table>
       <thead>

       <tr>
         <th class="text-center">วันที่เกิด</th>
         <th class="text-center">ระดับ</th>
         <th class="text-center">ชื่อเหตุการณ์</th>
         <th class="text-center">รายละอียด</th>
         <th class="text-center">การจัดการเบื้องต้น</th>
         <th class="text-center">RM Comment</th>

       </tr>

       <tr>
         <td colspan="6">
   รายงานอุบัติการแยกตามหน่วยงาน ทั้งหมด <?=count($data)?> รายการ
         </td>

       </tr>
       <?php
         ?>
       </thead>
       <tbody>
         <?php
           foreach( $data as $rs)
           {
         ?>
         <tr>
             <td><?php echo $rs->incident_date;?>&nbsp; น.</td>
             <td><?php echo $rs->violence->code?></td>
             <td><?php echo $rs->incident_title;?></td>
             <td><?php echo $rs->incident_event;?></td>
             <td></td>
             <td></td>


           </tr>
           <?php
           }
           ?>

       </tbody>
   </table>
  </body>
</html>
