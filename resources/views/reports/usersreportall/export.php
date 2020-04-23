

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
        <td>รายงานเจ้าหน้าที่ที่มีการรายงานอุบัติการณ์สูงสุด</td>
      </tr>
    </table>
    <table>
       <thead>

       <tr>
         <th class="text-center">เจ้าหน้าที่</th>
         <th class="text-center">จำนวน(ครั้ง)</th>


       </tr>


       <?php
         ?>
       </thead>
       <tbody>
         <?php
           foreach( $data as $rs)
           {
         ?>
         <?php
         if($rs->Count > 0)
         {
         ?>
         <tr>
             <td><?php echo $rs->prefix_name; ?><?php echo $rs->fname; ?>&nbsp;&nbsp;  <?php echo $rs->lname; ?></td>

             <td class="text-center"><?php echo $rs->Count; ?></td>


           </tr>
           <?php
           }
           ?>
           <?php
           }
           ?>

       </tbody>
   </table>
  </body>
</html>
