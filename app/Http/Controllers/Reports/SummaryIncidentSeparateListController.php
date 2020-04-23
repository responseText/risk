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
use App\Exports\SummaryIncidentSeparateListExport;
class SummaryIncidentSeparateListController extends Controller
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
                "
                select
              		distinct(i.incident_list_id) ,
              		(select name from incident_list il where il.id=i.incident_list_id  ) as 'Incident_List',
              		(
              			select count(ii.id) from incident ii where headrm_delete=''
              							and headrm_sendto_headdivision_status='Y'
              							and (incident_date BETWEEN '".$param_s."' and  '".$param_e."')
              							and ii.incident_list_id =i.incident_list_id
              		) as Count
              	from incident i
              	where headrm_delete=''
              	and headrm_sendto_headdivision_status='Y'
              	and (incident_date BETWEEN '".$param_s."' and  '".$param_e."' )
              	ORDER BY Count desc
                ");
                return view('reports.summaryincidentseparatelist.index')->with('data',$data)->with('url_date' , $url_date );

        }
        else
        {
            $param_s = substr(Carbon::now(),1,10);
            $param_e = substr(Carbon::now(),1,10);
            return view('reports.summaryincidentseparatelist.index')
                ->with('url_date' , $url_date );

        }

    }
    else
    {
        return view('reports.summaryincidentseparatelist.index')->with('url_date' , $url_date );
    }
  }
  public function exportExcel($originaldate)
  {

    return Excel::download(new SummaryIncidentSeparateListExport($originaldate), 'report.xlsx' );

  }
}
