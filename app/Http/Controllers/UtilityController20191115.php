<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class UtilityController extends Controller
{
  //----------------------------------------------------------------------------
  public function __construct()
  {
    $this->middleware('auth');
  }
  //----------------------------------------------------------------------------
  public function index()
  {


    return view('utility.index');
  }
  //----------------------------------------------------------------------------
  public function alertnotkey(Request $request)
  {
    $date_request =$request->incident_date;
    $date_arr   = explode('-',$date_request);
    switch($date_arr[0]) {
			case "มกราคม" :      $myMonth = "01";  break;
			case "กุมภาพันธ์" :    $myMonth = "02";  break;
			case "มีนาคม" :       $myMonth = "03"; break;
			case "เมษายน" :      $myMonth = "04"; break;
			case "พฤษภาคม" :     $myMonth = "05";   break;
			case "มิถุนายน" :      $myMonth = "06";  break;
			case "กรกฎาคม" :     $myMonth = "07";   break;
			case "สิงหาคม" :     $myMonth = "08";  break;
			case "กันยายน" :      $myMonth = "09";  break;
			case "ตุลาคม" :      $myMonth = "10";  break;
			case "พฤศจิกายน" :    $myMonth = "11";   break;
			case "ธันวาคม" :     $myMonth = "12";  break;
		}
    $myYear=($date_arr[1]-543);
    $data= DB::select("
      select
      d.name ,
        (
          select count(id) from incident  where
            by_user_id in(
            select u.id from users u
            inner join employee e on u.employee_id=e.id
            where e.division_id=d.id
            and (incident_date between '".$myYear.'-'.$myMonth."-01' and '".$myYear.'-'.$myMonth."-31')
          )
        ) countID
      from division d
      where d.id < 11
      GROUP BY d.id
      having countID <1
    ");



    $myArray =array();
    foreach($data as $k ){
      $myArray[] = $k->name;

    }


    $myTxt = implode(',',$myArray);

            $msg = 'หน่วยงาน '.$myTxt. ' ยังไม่ได้ทำการคีย์ความเสี่ยงประจำเดือน '.$date_request.' กรุณาคียความเสี่ยงเข้าสู่ระบบด้วยค่ะ' ;
               $chOne = curl_init();
               //$msg = ''
               curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
               // SSL USE
               curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
               curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
               //POST
               curl_setopt( $chOne, CURLOPT_POST, 1);
               // Message
               curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$msg);
               //ถ้าต้องการใส่รุป ให้ใส่ 2 parameter imageThumbnail และimageFullsize
               //curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=hi&imageThumbnail=http://www.wisadev.com/wp-content/uploads/2016/08/cropped-wisadevLogo.png&imageFullsize=http://www.wisadev.com/wp-content/uploads/2016/08/cropped-wisadevLogo.png");
               // follow redirects
               curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
               //ADD header array
               $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ', );
               curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
               //RETURN
               curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
               $result = curl_exec( $chOne );
               //Check error
               if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
               else { $result_ = json_decode($result, true);
               echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
               //Close connect
               curl_close( $chOne );


      return response()->json([
                'status' => 'true' ,
                'text'   => $myTxt
              ]);

  }
}
