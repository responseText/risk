<?php
function showStatus($param)
{

  switch($param)
  {
    case 'enable': return '<i class="fa fa-check"></i>&nbsp;ใช้งาน'; break;
    case 'disable': return '<i class="fa fa-times"></i>&nbsp;ไม่ใช้งาน'; break;
  }

}

function long_th_date($param)
{

    $myDateArray=explode("-",$param);
		$myDay = sprintf("%d",$myDateArray[2]);
		switch($myDateArray[1]) {
			case "01" : $myMonth = "มกราคม";  break;
			case "02" : $myMonth = "กุมภาพันธ์";  break;
			case "03" : $myMonth = "มีนาคม"; break;
			case "04" : $myMonth = "เมษายน"; break;
			case "05" : $myMonth = "พฤษภาคม";   break;
			case "06" : $myMonth = "มิถุนายน";  break;
			case "07" : $myMonth = "กรกฎาคม";   break;
			case "08" : $myMonth = "สิงหาคม";  break;
			case "09" : $myMonth = "กันยายน";  break;
			case "10" : $myMonth = "ตุลาคม";  break;
			case "11" : $myMonth = "พฤศจิกายน";   break;
			case "12" : $myMonth = "ธันวาคม";  break;
		}
		$myYear = sprintf("%d",$myDateArray[0])+543;
        return($myDay . " " . $myMonth . " " . $myYear);

}
function long_th_date1($param)
{

    $myDateArray=explode("-",$param);
		$myDay = sprintf("%d",$myDateArray[2]);
		switch($myDateArray[1]) {
			case "01" : $myMonth = "มกราคม";  break;
			case "02" : $myMonth = "กุมภาพันธ์";  break;
			case "03" : $myMonth = "มีนาคม"; break;
			case "04" : $myMonth = "เมษายน"; break;
			case "05" : $myMonth = "พฤษภาคม";   break;
			case "06" : $myMonth = "มิถุนายน";  break;
			case "07" : $myMonth = "กรกฎาคม";   break;
			case "08" : $myMonth = "สิงหาคม";  break;
			case "09" : $myMonth = "กันยายน";  break;
			case "10" : $myMonth = "ตุลาคม";  break;
			case "11" : $myMonth = "พฤศจิกายน";   break;
			case "12" : $myMonth = "ธันวาคม";  break;
		}
		$myYear = sprintf("%d",$myDateArray[0])+543;
        return($myYear . " " . $myMonth . " " . $myDay);

}
function short_th_date($param)
{

    $myDateArray=explode("-",$param);
		$myDay = sprintf("%d",$myDateArray[2]);
		switch($myDateArray[1]) {
      case "01" : $myMonth = "ม.ค.";  break;
			case "02" : $myMonth = "ก.พ.";  break;
			case "03" : $myMonth = "มี.ค."; break;
			case "04" : $myMonth = "เม.ย."; break;
			case "05" : $myMonth = "พ.ค.";   break;
			case "06" : $myMonth = "มิ.ย.";  break;
			case "07" : $myMonth = "ก.ค.";   break;
			case "08" : $myMonth = "ส.ค.";  break;
			case "09" : $myMonth = "ก.ย.";  break;
			case "10" : $myMonth = "ต.ค.";  break;
			case "11" : $myMonth = "พ.ย.";   break;
			case "12" : $myMonth = "ธ.ค.";  break;
		}
		$myYear = sprintf("%d",$myDateArray[0])+543;
        return($myDay . " " . $myMonth . " " . $myYear);

}


function showTime($param)
{
  $myTime=explode(":",$param);
  return $myTime[0].':'.$myTime[1];

}

?>
