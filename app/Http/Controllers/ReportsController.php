<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Incident;
use App\Evaluation;
use App\IncidentGroup;
use App\IncidentList;
use App\Division;
use App\SubDivision;
use App\TypeRisk;
use App\IncidentCase;
use App\Employee;
use App\Prefix;
use App\Effect;
use App\Violence;
use App\ViolenceLevel;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DivisionDetailExport;

class ReportsController extends Controller
{
  //--------------------------------------------------------------------------
  public function exportm($type,$division_id)
  {
    return Excel::download(new DivisionDetailExport($division_id), 'posts88.' . $type);

  }
  //----------------------------------------------------------------------------
    public function index()
    {
      return view('reports.index');
    }
    //------------------------------------------------------------------------
    //-----------------------------------------------------------------------
    public function divisiondetail(Request $request)
    {

        $rs_division = Division::select('id','name')
                          ->where('status','=','enable')
                          ->get();

      $originaldate =  $request->filterdaterage;

      $division_id ='';
      if(isset($request->division))
      {
        if( $request->division != '' || !empty($request->division) )
        {
          $division_id = $request->division;
        }
        else
        {
          $division_id='';
        }


      }


      if( isset($request->filterdaterage))
      {
        list($param_date1,$param_date2) =  explode(" - " ,$request->filterdaterage);

        $p_date1 = explode("/", $param_date1);
        $pp_date1 = $p_date1[2].'-'.$p_date1[1].'-'.$p_date1[0];

        $p_date2 = explode("/", $param_date2);
        $pp_date2 = $p_date2[2].'-'.$p_date2[1].'-'.$p_date2[0];
      //  echo $pp_date1.' --- '.$pp_date2.'    '.$request->division;
        if($division_id != '')
        {
          $rs   = Incident::where([
                                    ['headrm_delete','=',''],
                                    ['headrm_sendto_headdivision_status','=','Y'],
                                    ['division_id','=',$division_id]
                                  ])
                                  //->orWhere('division_id','=',$division_id)
                                  ->whereBetween('incident_date', [$pp_date1, $pp_date2])
                                  ->orderBy('incident_date','desc')
                                  ->get();
        }
        else
        {
          $rs   = Incident::where([
                                    ['headrm_delete','=',''],
                                    ['headrm_sendto_headdivision_status','=','Y']
                                  ])
                                  //->orWhere('division_id','=',$division_id)
                                  ->whereBetween('incident_date', [$pp_date1, $pp_date2])
                                  ->orderBy('incident_date','desc')
                                  ->get();
        }

        //dd($rs);
      }
      else
      {
        return view('reports.divisiondetail.index')
                ->with('division' , $rs_division )
                ->with('division_id' , $division_id )
                ->with('originaldate',$originaldate);

      }
      return view('reports.divisiondetail.index')
              ->with('division' , $rs_division )
              ->with('division_id' , $division_id )
              ->with('originaldate',$originaldate)
              ->with('data', $rs );

/*
        return view('reports.typerisk')
                ->with('division' , $rs_division )
                ->with('division_id' , $division_id )
                ->with('originaldate',$originaldate);
*/




    }


    //-------------------------------------------------------------------------

    public function export(Request $request)
    {

      $rq_daterage = $request->originaldate;
      $rq_division = $request->division_id;
      $rq_typefile = $request->type_file;

      list($param_date1,$param_date2) =  explode(" - " ,$rq_daterage);

      $p_date1 = explode("/", $param_date1);
      $pp_date1 = $p_date1[2].'-'.$p_date1[1].'-'.$p_date1[0];

      $p_date2 = explode("/", $param_date2);
      $pp_date2 = $p_date2[2].'-'.$p_date2[1].'-'.$p_date2[0];
    //  echo $pp_date1.' --- '.$pp_date2.'    '.$request->division;

      $rs   = Incident::where([
                                ['headrm_delete','=',''],
                                ['headrm_sendto_headdivision_status','=','Y'],
                                ['division_id','=',$rq_division]
                              ])
                              //->orWhere('division_id','=',$division_id)
                              ->whereBetween('incident_date', [$pp_date1, $pp_date2])
                              ->orderBy('incident_date','desc')
                              ->get();


      $division_name =  $rs[0]->division->name;
      return view('reports.divisiondetail.export')
                ->with('data' , $rs)
                ->with('originaldate',$rq_daterage)
                ->with('division',$division_name)
                ->with('typefile',$rq_typefile);
    }
}
