<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use DB;
use PDF;
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
use App\Exports\DivisionForDetailExport;
class DivisionForDetailController extends Controller
{
    //
    public function index(Request $request)
    {
      $url_date='';
      $division_id ='';

      $rs_division = Division::select('id','name')
                        ->where('status','=','enable')
                        ->get();

      $originaldate =  $request->filterdaterage;
      if(  $originaldate !='')
      {
        $url_date =  str_replace(" - ","_",$request->filterdaterage);
        $url_date =  str_replace("/","-",$url_date);
      }
      if(isset($request->division))
      {
          if( $request->division != '0' || !empty($request->division) )
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
          return view('reports.divisionfordetail.index')
                    ->with('division' , $rs_division )
                    ->with('division_id' , $division_id )
                    ->with('url_date' , $url_date )
                    ->with('originaldate',$originaldate)
                    ->with('data', $rs );
      }
      else
      {
          return view('reports.divisionfordetail.index')
                  ->with('division' , $rs_division )
                  ->with('division_id' , $division_id )
                  ->with('url_date' , $url_date )
                  ->with('originaldate',$originaldate);
      }


      return view('reports.divisionfordetail.index')
                ->with('division' , $rs_division )
                ->with('division_id' , $division_id )
                ->with('url_date' , $url_date )
                ->with('originaldate',$originaldate)
                ->with('data', $rs );

    }
    public function show($id)
    {
      $rs = Incident::findorfail($id);
      return view('reports.divisionfordetail.show')
                ->with('data' , $rs );

    }
    public function exportExcel($division,$originaldate)
    {
      return Excel::download(new DivisionForDetailExport($division,$originaldate), 'ความเสี่ยงที่เกิดขึ้นแยกกลุ่มงาน(ละเอียด).xlsx' );

    }

}
