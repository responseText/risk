<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Incident;
use App\Division;
use App\SubDivision;
use App\TypeRisk;
use App\Violence;
use App\Month;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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


        return view('home')
          ->with('pieDivision',$pieDivision)
          ->with('pieIncidentGroup',$pieIncidentGroup)
          ->with('lineDivision1',$arr_lineDivision1)
          ->with('month',$arrmonth);
    }
}
