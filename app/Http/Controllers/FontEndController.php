<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth ;
use Session;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Incident;
use App\Division;
use App\SubDivision;
use App\TypeRisk;
use App\Violence;
use App\Month;
use App\IncidentGroup;
use App\RiskProgram;
class FontEndController extends Controller
{


  public function index( Request $request )
  {
  
$url="index";

if (!Auth::check()) {
  $url="index1";
}
else {
  $url="index-intro";
}
  $year1 = date('Y');
  $dmy1='';
  $dmy2='';
  $array_data             = array();
  $arrmonth  = array();
      $result = DB::table('month1')
          ->select('month_name')
          ->orderBy('orderby','asc')
          ->get();
  foreach( $result as $k =>$v)
  {
  //echo $k;
   $arrmonth[] = $v->month_name;
  }
 if(empty($request->budget_year))
 {
   $year1 =  $year1-1;
   $dmy1  = "$year1-10-01";
   $dmy2  = ($year1+1)."-09-30";

 }
 else
 {
     $year1 = $request->budget_year;
     $year1 =  $year1-1;
     $dmy1  = "$year1-10-01";
     $dmy2  = $request->budget_year."-09-30";
 }
     //echo $year1;
     $division = Division::select('id','name')->where('status','=','enable')->get();
    $incidentGroup = IncidentGroup::select('id','name')->where('status','=','enable')->get();


     foreach( $division as $k =>$v )
     {
       $arr_month1 =array();


       if( $v->id )
       {

         $lineCountDivision = DB::select(
            "select
            ( select count(*) from incident where month(incident_date)=a.id  and division_id=$v->id and incident_date between '$dmy1' and '$dmy2' ) as 'Count'
            from month1 a order by a.orderby  asc
            ");
            foreach( $lineCountDivision as $j)
            {
             $arr_month1[] = $j->Count;
            }
          //  $array_data['series'][$v->id]['name'] =  $v->name;
          //  $array_data['series'][$v->id]['data'] =  $arr_month1;
            $array_data[$v->id]['name'] =  $v->name;
            $array_data[$v->id]['data'] =  $arr_month1;

       }

      }
      //return response()->json($array_data);
      //--------------------------------------------------------------------
      foreach( $incidentGroup as $k =>$v )
      {
        $arr_monthIncidentGroup =array();


        if( $v->id )
        {


         $columnCountGroup = DB::select(
            "select
            ( select count(*) from incident where month(incident_date)=a.id  and incident_group_id=$v->id and incident_date between '$dmy1' and '$dmy2' ) as 'Count'
            from month1 a order by a.orderby  asc
            ");
             foreach( $columnCountGroup as $j)
             {
              $arr_monthIncidentGroup[] = $j->Count;
             }
           //  $array_data['series'][$v->id]['name'] =  $v->name;
           //  $array_data['series'][$v->id]['data'] =  $arr_month1;
             $array_dataIncidentGroup[$v->id]['name'] =  $v->name;
             $array_dataIncidentGroup[$v->id]['data'] =  $arr_monthIncidentGroup;

        }


       }



      //$budget_year;
      if(!isset($request->budget_year))
      {
        $budget_year  =  date('Y');
      }
      else
      {
        $budget_year  = $request->budget_year;
      }

      $pieChart1 = DB::select(
         "select
         a.name ,
         ( select count(*) from incident where incident_group_id=a.id and incident_date between '$dmy1' and '$dmy2' ) as 'Count'
         from risk_program a group by a.name
         ");

         $columnChart = DB::select(
            "select
            a.name ,
            ( select count(*) from incident where incident_group_id=a.id and incident_date between '$dmy1' and '$dmy2' ) as 'Count'
            from incident_group a group by a.name
            ");

      $allRisk = Incident::whereBetween('incident_date', [$dmy1 , $dmy2])->count() ;




    $countAllRisk = DB::table('incident')->whereBetween('incident_date', [$dmy1 , $dmy2])->count();
    $countAllRiskHeadRMForsend = DB::table('incident')
                                    ->orWhere('headrm_sendto_headdivision_status','=','N')
                                    ->orWhere('headrm_sendto_headdivision_status','=',null)
                                    ->whereBetween('incident_date', [$dmy1 , $dmy2])->count();
    $countAllRiskHeadDivision = DB::table('incident')
                                    ->Where([
                                              ['headrm_sendto_headdivision_status','=','Y'],
                                              ['headdivision_receive_status','=',null] ,
                                              ['headrm_review_status','=',null] ,
                                            ])
                                    ->whereBetween('incident_date', [$dmy1 , $dmy2])->count();
    $countAllRiskHeadRMEvaluation = DB::table('incident')
                                    ->Where([
                                              ['headrm_sendto_headdivision_status','=','Y'],
                                              ['headdivision_receive_status','=','Y'] ,
                                              ['headrm_review_status','=',null] ,
                                            ])
                                    ->whereBetween('incident_date', [$dmy1 , $dmy2])->count();

    /*
    $countNoUsers=Incident::select('discover_employee_id',DB::raw('count(id) as Count_user'))
                  ->Where([['headrm_sendto_headdivision_status','=','Y'],['headrm_delete','!=','Y']])
                  ->whereBetween('incident_date', [$dmy1 , $dmy2])
                  ->groupBy('discover_employee_id')
                  ->orderBy('Count_user','desc')
                  ->take(10)
                  ->get();
      */
      $countNoUsers=Incident::select('discover_employee_id',DB::raw('count(id) as Count_user'))
                    ->Where([['headrm_sendto_headdivision_status','=','Y'],['headrm_delete','!=','Y']])
                    ->whereBetween('incident_date', [$dmy1 , $dmy2])
                    ->groupBy('discover_employee_id')
                    ->orderBy('Count_user','desc')
                    ->take(10)
                    ->get();
      $SemiCircle=DB::table('incident')
                      ->join('typerisk','incident.type_risk_id','=','typerisk.id')
                      ->select( 'typerisk.name',DB::raw('count(incident.id) as y'))
                      ->Where([['headrm_sendto_headdivision_status','=','Y'],['headrm_delete','!=','Y']])
                      ->whereBetween('incident_date', [$dmy1 , $dmy2])
                      ->groupBy('incident.type_risk_id')
                      ->get();

      $typePatient=DB::table('incident')
                      ->join('effect','incident.effect_id','=','effect.id')
                      ->select( 'effect.name',DB::raw('count(incident.id) as y'))
                      ->Where([['headrm_sendto_headdivision_status','=','Y'],['headrm_delete','!=','Y']])
                      ->whereBetween('incident_date', [$dmy1 , $dmy2])
                      ->groupBy('incident.effect_id')
                      ->get();

      $violencelevelCircle=DB::select(
         "
         select name ,
            (
             	select count(*) from incident
             	where violence_id in (
             		(select id from violence where violencelevel_id=vl.id)
             	)
             	and incident_date BETWEEN '".$dmy1."' and '".$dmy2."'
             ) as value

             from violence_level vl

         ");
         $riskProgram=DB::select(
            "select  name ,
                (
                	select count(*) from incident
                	where incident_group_id in (
                		(select id from incident_group where risk_program_id=vl.id)
                	)
                	 and incident_date BETWEEN '".$dmy1."' and '".$dmy2."'
                 ) as y

                 from risk_program vl
               ");
$alldivision = Division::withTrashed()->select('id','name')->count(); // ***เพิ่มมาใหม่  เพื่อใช้คำนวณดึงจำนวนกลุ่มงาน
            return view($url)
                  ->with('alldivision',$alldivision)
                  ->with('countAllRisk',$countAllRisk)
                  ->with('pieChart1',$pieChart1)
                  ->with('columnChart',$columnChart)
                  ->with('countNoUsers',$countNoUsers)
                  ->with('semiCircle',$SemiCircle)
                  ->with('typePatient',$typePatient)
                  ->with('riskProgram',$riskProgram)

                  ->with('violencelevelCircle',$violencelevelCircle)
                  ->with('allRisk',$allRisk)
                  ->with('countAllRiskHeadRMForsend',$countAllRiskHeadRMForsend)
                  ->with('countAllRiskHeadDivision',$countAllRiskHeadDivision)
                  ->with('countAllRiskHeadRMEvaluation',$countAllRiskHeadRMEvaluation)
                  ->with('line',$array_data)
                  ->with('column',$array_dataIncidentGroup)
                  ->with('column2',$array_dataIncidentGroup)
                  ->with('month',$arrmonth)
                  ->with('request_year',$budget_year);




  }

  public function indexsearch(Request $request)
  {
    $url="index";

    if (!Auth::check()) {
      $url="index1";
    }
    else {
      $url="index-intro";
    }
      $year1 = date('Y');
      $dmy1='';
      $dmy2='';
      $array_data             = array();
      $array_dataIncidentGroup             = array();
      $arrmonth  = array();
          $result = DB::table('month1')
              ->select('month_name')
              ->orderBy('orderby','asc')
              ->get();
      foreach( $result as $k =>$v)
      {
      //echo $k;
       $arrmonth[] = $v->month_name;
      }
     if(empty($request->budget_year))
     {
       $year1 =  $year1-1;
       $dmy1  = "$year1-10-01";
       $dmy2  = ($year1+1)."-09-30";

     }
     else
     {
         $year1 = $request->budget_year;
         $year1 =  $year1-1;
         $dmy1  = "$year1-10-01";
         $dmy2  = $request->budget_year."-09-30";
     }
         //echo $year1;
         $division = Division::select('id','name')->where('status','=','enable')->get();



         foreach( $division as $k =>$v )
         {
           $arr_month1 =array();


           if( $v->id )
           {

             $lineCountDivision = DB::select(
                "select
                ( select count(*) from incident where month(incident_date)=a.id  and division_id=$v->id and incident_date between '$dmy1' and '$dmy2' ) as 'Count'
                from month1 a order by a.orderby  asc
                ");

                foreach( $lineCountDivision as $j)
                {
                 $arr_month1[] = $j->Count;
                }
              //  $array_data['series'][$v->id]['name'] =  $v->name;
              //  $array_data['series'][$v->id]['data'] =  $arr_month1;
                $array_data[$v->id]['name'] =  $v->name;
                $array_data[$v->id]['data'] =  $arr_month1;

           }

          }
          //--------------------------------------------------------------------
          $columnCountGroup = DB::select(
             "select
             a.name ,
             ( select count(*) from incident where incident_group_id=a.id and incident_date between '$dmy1' and '$dmy2' ) as 'Count'
             from incident_group a group by a.name
             ");
          //return response()->json($array_data);


          //$budget_year;
          if(!isset($request->budget_year))
          {
            $budget_year  =  date('Y');
          }
          else
          {
            $budget_year  = $request->budget_year;
          }

          $pieChart1 = DB::select(
             "select
             a.name ,
             ( select count(*) from incident where incident_group_id=a.id and incident_date between '$dmy1' and '$dmy2' ) as 'Count'
             from risk_program a group by a.name
             ");
          $allRisk = Incident::whereBetween('incident_date', [$dmy1 , $dmy2])->count() ;



          $countAllRisk = DB::table('incident')->whereBetween('incident_date', [$dmy1 , $dmy2])->count();
          $countAllRiskHeadRMForsend = DB::table('incident')
                                          ->orWhere('headrm_sendto_headdivision_status','=','N')
                                          //->orWhere('headrm_sendto_headdivision_status','=',null)
                                          ->whereBetween('incident_date', [$dmy1 , $dmy2])->count();
    $countAllRiskHeadDivision = DB::table('incident')
                                    ->Where([
                                              ['headrm_sendto_headdivision_status','=','Y'],
                                              ['headdivision_receive_status','=',null] ,
                                              ['headrm_review_status','=',null]
                                            ])
                                    ->whereBetween('incident_date', [$dmy1 , $dmy2])->count();
      $countAllRiskHeadRMEvaluation = DB::table('incident')
                                ->Where([
                                          ['headrm_sendto_headdivision_status','=','Y'],
                                          ['headdivision_receive_status','=','Y'] ,
                                          ['headrm_review_status','=',null] ,
                                        ])
                                ->whereBetween('incident_date', [$dmy1 , $dmy2])->count();
        /*$countNoUsers=DB::table('incident')->select('by_user_id',DB::raw('count(id) as Count_user'))
                      ->Where([['headrm_sendto_headdivision_status','=','Y']])
                      ->whereBetween('incident_date', [$dmy1 , $dmy2])
                      ->groupBy('by_user_id')
                      ->orderBy('Count_user','desc')
                      ->take(10)
                      ->get();
                      */
                      $countNoUsers=Incident::select('discover_employee_id',DB::raw('count(id) as Count_user'))
                                    ->Where([['headrm_sendto_headdivision_status','=','Y'],['headrm_delete','!=','Y']])
                                    ->whereBetween('incident_date', [$dmy1 , $dmy2])
                                    ->groupBy('discover_employee_id')
                                    ->orderBy('Count_user','desc')
                                    ->take(10)
                                    ->get();

                    $SemiCircle=DB::table('incident')
                                    ->join('typerisk','incident.type_risk_id','=','typerisk.id')
                                    ->select( 'typerisk.name',DB::raw('count(incident.id) as y'))
                                    ->Where([['headrm_sendto_headdivision_status','=','Y'],['headrm_delete','!=','Y']])
                                    ->whereBetween('incident_date', [$dmy1 , $dmy2])
                                    ->groupBy('incident.type_risk_id')
                                    ->get();
                      $violencelevelCircle=DB::select(
                         "
                         select name ,
                            (
                             	select count(*) from incident
                             	where violence_id in (
                             		(select id from violence where violencelevel_id=vl.id)
                             	)
                             	and incident_date BETWEEN '".$dmy1."' and '".$dmy2."'
                             ) as value

                             from violence_level vl

                         ");
                         $riskProgram=DB::select(
                            "select  name ,
(
	select count(*) from incident
	where incident_group_id in (
		(select id from incident_group where risk_program_id=vl.id)
	)
	 and incident_date BETWEEN '".$dmy1."' and '".$dmy2."'
 ) as y

 from risk_program vl
                               ");


                         $typePatient=DB::table('incident')
                                         ->join('effect','incident.effect_id','=','effect.id')
                                         ->select( 'effect.name',DB::raw('count(incident.id) as y'))
                                         ->Where([['headrm_sendto_headdivision_status','=','Y'],['headrm_delete','!=','Y']])
                                         ->whereBetween('incident_date', [$dmy1 , $dmy2])
                                         ->groupBy('incident.effect_id')
                                         ->get();
              $alldivision = Division::withTrashed()->select('id','name')->count(); // ***เพิ่มมาใหม่  เพื่อใช้คำนวณดึงจำนวนกลุ่มงาน
                return view($url)
                      ->with('alldivision',$alldivision)
                      ->with('countAllRisk',$countAllRisk)
                      ->with('pieChart1',$pieChart1)
                      ->with('columnChart',$columnCountGroup)
                      ->with('countNoUsers',$countNoUsers)
                      ->with('semiCircle',$SemiCircle)

                      ->with('riskProgram',$riskProgram)
                      ->with('typePatient',$typePatient)
                      ->with('violencelevelCircle',$violencelevelCircle)
                      ->with('allRisk',$allRisk)
                      ->with('countAllRiskHeadRMForsend',$countAllRiskHeadRMForsend)
                      ->with('countAllRiskHeadDivision',$countAllRiskHeadDivision)
                      ->with('countAllRiskHeadRMEvaluation',$countAllRiskHeadRMEvaluation)
                      ->with('line',$array_data)
                      ->with('column',$array_dataIncidentGroup)
                      ->with('month',$arrmonth)
                      ->with('request_year',$budget_year);




  }

  public function test2()
  {
    $arrProgram =array();
    $riskprogram = RiskProgram::select('id','name')->where('status','enable')->get();
    $riskgroup  =IncidentGroup::select('id','risk_program_id','name')->where('status','enable')->get();


    foreach($riskprogram as $a =>$b)
    {
      foreach($riskgroup as $k =>$v)
      {
        if($b->id == $v->risk_program_id)
        {
          //echo $b->id.'  -  '.$v->id.$v->name.'  <br>';
         $arrProgram[$b->id][] =$v->id;

        }

        //echo $b->id.' '.$a.'<br>';
      }

      //if($v->risk_program_id)
      //echo $v->name.' '.$k;
    }
//echo $arrProgram[1];
    //dd($arrProgram);
    foreach( $lineCountDivision as $j)
    {
     $arr_month1[] = $j->Count;
    }
      $c1= DB::select("select count(*) as 'CC'   from incident where incident_group_id in ' $arrProgram ' and incident_date between '2018-10-01' and '2019-09-30'");



    $arrabc = array();
    foreach ( $riskprogram as $j => $k )
    {
      //echo ($j+1).'-  ' .$k->id.'  '.$k->name.'<br>';
      $index=$j+1;
      $arrabc[$k->id]['name'] = $k->name;
      //echo $j+1;
      //foreach ( $arrProgram as $j1  )
    //  {
      //  echo $j1[0].'<br>';
        //echo ($j+1).'-  ' .$k->id.'  '.$k->name.'<br>';
        $ccount= DB::select("select count(*) as 'CC'   from incident where incident_group_id in '$arrProgram' and incident_date between '2018-10-01' and '2019-09-30'");
    //  }
//$ccount    = array();
      foreach( $ccount as $k11 => $k12 )
      {
        echo $k12->CC .'<br>';
      }
    }



    //dd($arrProgram);
      $columnCountGroup1 = DB::select(
         "select
         a.name ,
         ( select count(*) from incident where incident_group_id=a.id and incident_date between '2017-10-01' and '2018-09-30' ) as 'Count'
         from incident_group a group by a.name
         ");


        // echo $riskgroup;
     //return response()->json( $columnCountGroup1);
  }
  public function test($id)
  {
    $year1 = $id-1;
    $dmy1  = "$year1-10-01";
    $dmy2  = "$id-09-30";
    $array_data             = array();
    $arr_month              = array();
    $arr    = array();
    $arr1   = array();
    $result = array();

    $lineCountDivision;
    $division = Division::select('id','name')->where('status','=','enable')->get();



    $array_data['title'] ='teast';
    $array_data['subtitle'] ="Solar Employment Growth by Sector, $dmy1 - $dmy2";
    $array_data['yAxis'] ='Number of Employees';
    foreach( $division as $k =>$v )
    {
      $arr_month1 =array();


      if( $v->id )
      {

        $lineCountDivision = DB::select(
           "select
           ( select count(*) from incident where month(incident_date)=a.id  and division_id=$v->id and incident_date between '$dmy1' and '$dmy2' ) as 'Count'
           from month1 a order by a.orderby  asc
           ");
           foreach( $lineCountDivision as $j)
           {
            $arr_month1[] = $j->Count;


           }


           $array_data['series'][$v->id]['name'] =  $v->name;
           $array_data['series'][$v->id]['data'] =  $arr_month1;

           //$arr['name'][] = $v->name;
           //$arr['data'][] = $arr_month1;

      }

      //array_push($result,$arr);
    //  array_push($result,$arr1);
  }
return json_encode( $array_data);
    //return response()->json( $array_data );



        //return $arrmonth;

//return response()->json($array_data);
                      //  $data   =   Incident::get();
               //return response()->json(  $data );
               //return response()->json(  $data );
  }





























  /*
  public function index()
  {
    $url="index";

    if (!Auth::check()) {
      $url="index1";
    }
    else {
      $url="index";
    }
    $arrmonth  = array();
        $result = DB::table('month1')
            ->select('month_name')
            ->orderBy('orderby','asc')
            ->get();
    foreach( $result as $k =>$v)
    {
    //echo $k;
     $arrmonth[] = $v->month_name;
    }


    $arr_lineDivision1  = array();
    $lineDivision1 = DB::select(
        'select
        ( select count(*) from incident where month(incident_date)=a.id  and year(incident_date)=year(CURRENT_DATE) ) as "Count"
        from month1 a order by a.orderby  asc
        ');
        foreach( $lineDivision1 as $k)
        {
         $arr_lineDivision1[] = $k->Count;
            //return $arrmonth;
          }




    $pieDivision = DB::select('
    select
    a.name
    ,
    (
      select count(id) FROM incident where division_id=a.id
    ) as "count"

    from division a
    left join incident b on a.id=b.division_id
    GROUP BY a.name
    ');
    $pieIncidentGroup = DB::select('
    select
    a.name
    ,
    (
      select count(id) FROM incident where division_id=a.id
    ) as "count"

    from incident_group a
    left join incident b on a.id=b.incident_group_id
    GROUP BY a.name
    ');




    return view($url)
          ->with('pieDivision',$pieDivision)
          ->with('pieIncidentGroup',$pieIncidentGroup)
          ->with('lineDivision1',$arr_lineDivision1)
          ->with('month',$arrmonth)


          ;
  }
  */
  public function chart()
  {
    $years = ['2018'];
    $result = DB::table('division')
        ->leftJoin('incident', 'division.id', '=', 'incident.division_id')
        ->select('division.id as division', DB::raw('COUNT(incident.id) as total'))
  //->where( DB::raw("year(incident.incident_date)") , $years )
        //->select('division.name')
        ->groupBy('division.id')
        ->get();



    return json_encode($result);
  }

  public function chart2()
  {
      $pieChart2 = DB::select(
     "select
     a.name ,
     ( select count(*) from incident where incident_group_id=a.id and incident_date between '2017-10-01' and '2018-09-30' ) as 'Count'
     from risk_program a group by a.name
     ");
     $arr_pie1 =array();
 foreach ($pieChart2 as $k =>$v)
 {
   $arr_pie1[$k]['name']= $v->name;


 }

     return dd($pieChart2);
  }
  public function chart1()
  {
    $years = ['2019'];
    $result = DB::table('division')
        ->leftJoin('incident', 'division.id', '=', 'incident.division_id')
        ->select('division.id as division', DB::raw('COUNT(incident.id) as total'))
        ->where( DB::raw("year(incident_timee)") , $years )
        //->select('division.name')
        ->groupBy('division.id')
        ->get();



    return json_encode($result);
  }
  public function line111()
  {
    //$years = ['2019'];
    /*
$arrmonth  = array();
    $result = DB::table('division')
        ->select('id')
        ->get();
foreach( $result as $k =>$v)
{
 $arrmonth[] = $v->id;
    return $arrmonth;
  }
  */
  $arrmonth  = array();
  $lineDivision1 = DB::select(
      'select
      ( select count(*) from incident where month(incident_date)=a.id  and division_id="1" ) as "Count"
      from month1 a order by a.orderby  asc
      ');
      foreach( $lineDivision1 as $k)
      {
       $arrmonth[] = $k->Count;
          //return $arrmonth;
        }

      return $arrmonth;


    }
}
