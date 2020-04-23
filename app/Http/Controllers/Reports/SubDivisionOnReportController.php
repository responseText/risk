<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use PDF;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
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
use App\Exports\SubDivisionOnReportExport;
class SubDivisionOnReportController extends Controller
{
  public function index(Request $request)
  {
      $url_date='';
      $param_s = substr(Carbon::now(),1,10);
      $param_e = substr(Carbon::now(),1,10);

      if(isset($request->filterdaterage))
      {
          $originaldate =  $request->filterdaterage;
          if(  $originaldate !='')
          {
            $url_date =  str_replace(" - ","_",$request->filterdaterage);
            $url_date =  str_replace("/","-",$url_date);
          }
          if( $request->filterdaterage != '0' || !empty($request->filterdaterage) )
          {
              $olddaterage =$request->filterdaterage;
              list($param_d1,$param_d2) =  explode(" - " ,$request->filterdaterage);
              $param_dd1 = explode("/" ,$param_d1 );
              $param_dd2 = explode("/" ,$param_d2 );
              $param_s = $param_dd1[2].'-'.$param_dd1[1].'-'.$param_dd1[0];
              $param_e = $param_dd2[2].'-'.$param_dd2[1].'-'.$param_dd2[0];
              //$data->whereBetween("incident_date",[$param_s , $param_e]);

              $data =DB::select(
                  "select
                      o.id ,
                      ( select d.name from division d where d.id = o.division_id) as 'Division_name',
                      o.name
                      ,
                      ( select count(i.id) from incident i where i.headrm_sendto_headdivision_status='Y' and (i.sub_division_id = o.id)
                          and incident_date between '".$param_s."' and  '".$param_e."' and headrm_sendto_headdivision_status='Y'
                          and headrm_delete=''
                      ) as 'Count'
                  from subdivision o order by Count  desc
                  ");
                  return view('reports.subdivisiononreport.index')->with('data',$data)->with('url_date' , $url_date );

          }
          else
          {
              $param_s = substr(Carbon::now(),1,10);
              $param_e = substr(Carbon::now(),1,10);
              return view('reports.subdivisiononreport.index')
                  ->with('url_date' , $url_date );

          }

      }
      else
      {
          return view('reports.subdivisiononreport.index')->with('url_date' , $url_date );
      }





  }
  public function exportExcel($originaldate)
  {

    return Excel::download(new SubDivisionOnReportExport($originaldate), 'report.xlsx' );

  }
}
