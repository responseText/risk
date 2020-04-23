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
//use App\Exports\IncidentListExport;
class IncidentListController extends Controller
{
  public function index(Request $request)
  {
    $url_date='';
    $arrsubdivision = array();
    $division_id ='';
    $subdivision_id ='';
    $rs_division    = Division::select('id','name')
                                ->where('status','=','enable')
                                ->get();
    if(isset($request->filterdaterage))
    {
      $originaldate =  $request->filterdaterage;
      if(  $originaldate !='')
      {
        $url_date =  str_replace(" - ","_",$request->filterdaterage);
        $url_date =  str_replace("/","-",$url_date);
      }
      /*
      $data = Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'],
                                  ['headrm_delete','=','']
                              ]);
      */
      if(isset($request->filterdaterage))
      {
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
                              distinct i.incident_list_id
                              ,
                              (select il.name from incident_list il where il.id=i.incident_list_id ) as listName ,
                              (
                                select count(ii.id)
                                from
                                incident ii
                                where ii.headrm_sendto_headdivision_status='Y'
                                and ii.headrm_delete=''
                                and ii.incident_list_id=i.incident_list_id
                                and (incident_date  between '".$param_s."' and  '".$param_e."')
                              ) as inc_count
                              from
                              incident i
                              where
                              i.headrm_sendto_headdivision_status='Y'
                              and i.headrm_delete=''
                              and (incident_date  between '".$param_s."' and  '".$param_e."')
                              ORDER BY inc_count desc
                              ");
          }
          else
          {
              $olddaterage='';
          }
          if(isset($request->division))
          {
              if( $request->division != '' || !empty($request->division) )
              {
                  $division_id = $request->division;
                  //$data->where('division_id',$division_id) ;
                  $data =DB::select(
                                "
                                select
                                  distinct i.incident_list_id
                                  ,
                                  (select il.name from incident_list il where il.id=i.incident_list_id ) as listName ,
                                  (
                                    select count(ii.id)
                                    from
                                    incident ii
                                    where ii.headrm_sendto_headdivision_status='Y'
                                    and ii.headrm_delete=''
                                    and ii.incident_list_id=i.incident_list_id
                                    and (ii.incident_date  between '".$param_s."' and  '".$param_e."')
                                    and ii.division_id ='".$division_id."'
                                  ) as inc_count
                                  from
                                  incident i
                                  where
                                  i.headrm_sendto_headdivision_status='Y'
                                  and i.headrm_delete=''
                                  and (i.incident_date  between '".$param_s."' and  '".$param_e."')
                                  and i.division_id ='".$division_id."'
                                  ORDER BY inc_count desc
                                  ");

              }
              else
              {
                  $division_id='';
              }
          }
          if(isset($request->subdivision))
          {

              $subdivision_id=$request->subdivision;
              //dd(implode(,)$arrsubdivision);
              $data =DB::select(
                            "
                            select
                              distinct i.incident_list_id
                              ,
                              (select il.name from incident_list il where il.id=i.incident_list_id ) as listName ,
                              (
                                select count(ii.id)
                                from
                                incident ii
                                where ii.headrm_sendto_headdivision_status='Y'
                                and ii.headrm_delete=''
                                and ii.incident_list_id=i.incident_list_id
                                and (ii.incident_date  between '".$param_s."' and  '".$param_e."')
                                and ii.division_id ='".$division_id."'
                                and ii.sub_division_id ='".$subdivision_id."'
                              ) as inc_count
                              from
                              incident i
                              where
                              i.headrm_sendto_headdivision_status='Y'
                              and i.headrm_delete=''
                              and (i.incident_date  between '".$param_s."' and  '".$param_e."')
                              and i.division_id ='".$division_id."'
                              and i.sub_division_id ='".$subdivision_id."'
                              ORDER BY inc_count desc
                              ");


              ///$data->whereIn('sub_division_id',$arrsubdivision)  ;

          }
          else
          {
              $subdivision_id='';
          }
      }
      //$count          = $data->count();
    //  $data           =  $data->orderBy( 'incident_date','desc'  );
      //$data           =  $data->paginate( $count  );
      return view('reports.incidentlist.index')
        ->with('subdivision_id',$subdivision_id )
        ->with('division',$rs_division)
        ->with('division_id',$division_id)
        ->with('url_date' , $url_date )
        ->with('data',$data);
    }
    else
    {
      return view('reports.incidentlist.index')
        ->with('subdivision_id',$subdivision_id )
        ->with('division',$rs_division)
        ->with('url_date' , $url_date )
        ->with('division_id',$division_id);

    }
  }
  //--------------------------------------------------------------------------
  public function getsubdivision($id)
  {
              $data   =   SubDivision::select('id','name')->where([['division_id','=',$id],['status','=','enable']])
                          ->get();
                          return response()->json(  $data );
  }
}
