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
use App\Exports\DivisionOnReportExport;
class DivisionOnReportController extends Controller
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
        (case
            when division_id=6 then
                case
                  when sd.id=16 then sd.name
                  when sd.id=17 then sd.name
                  when sd.id=18 then sd.name
                  when sd.id=19 then sd.name
                end
           else d.name
        end
        ) as name_depart
      ,
        (case
            when division_id=6 then
                case
                  when sd.id=16 then sd.id
                  when sd.id=17 then sd.id
                  when sd.id=18 then sd.id
                  when sd.id=19 then sd.id
                end
           else d.id
        end
        ) as id_depart
      ,
        (
        select
          case
            when d.id='6'  then
                case
                  when sd.id='16' then   (select count(id) from incident where division_id='6' and sub_division_id='16' and headrm_delete !='Y' and headrm_sendto_headdivision_status='Y' and (incident_date BETWEEN '".$param_s."' and  '".$param_e."'))
                  when sd.id='17' then   (select count(id) from incident where division_id='6' and sub_division_id='17' and headrm_delete !='Y' and headrm_sendto_headdivision_status='Y'  and (incident_date BETWEEN '".$param_s."' and  '".$param_e."'))
                  when sd.id='18' then   (select count(id) from incident where division_id='6' and sub_division_id='18' and headrm_delete !='Y' and headrm_sendto_headdivision_status='Y'  and (incident_date BETWEEN '".$param_s."' and  '".$param_e."'))
                  when sd.id='19' then   (select count(id) from incident where division_id='6' and sub_division_id='19' and headrm_delete !='Y' and headrm_sendto_headdivision_status='Y'  and (incident_date BETWEEN '".$param_s."' and  '".$param_e."'))

                end
           else  count(id)
          end
        from incident  where division_id=d.id and headrm_delete !='Y' and headrm_sendto_headdivision_status='Y'  and (incident_date BETWEEN '".$param_s."' and  '".$param_e."')
        ) as count1


      from division d
      INNER JOIN subdivision sd on d.id=sd.division_id
      GROUP BY name_depart
      having name_depart is not null
      ORDER BY d.id asc
                    ");
                    return view('reports.divisiononreport.index')->with('data',$data)->with('url_date' , $url_date );

            }
            else
            {
                $param_s = substr(Carbon::now(),1,10);
                $param_e = substr(Carbon::now(),1,10);
                return view('reports.divisiononreport.index')
                    ->with('url_date' , $url_date );

            }

        }
        else
        {
            return view('reports.divisiononreport.index')->with('url_date' , $url_date );
        }





    }
    public function exportExcel($originaldate)
    {

      return Excel::download(new DivisionOnReportExport($originaldate), 'report.xlsx' );

    }
}
