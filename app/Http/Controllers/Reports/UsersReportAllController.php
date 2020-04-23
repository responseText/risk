<?php

namespace App\Http\Controllers\reports;

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
use App\Exports\UsersReportAllExport;
class UsersReportAllController extends Controller
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
                                -- i.by_user_id,
                                -- u.name  ,
                                count(i.by_user_id) As CountPost,
                                concat(pr.name,e.fname,'  ',e.lname ) as EmployeeName	,
                                e.division_id	 as DivisionID ,
                                d.name DivisionName

                                from
                                users u
                                INNER JOIN incident i on u.id=i.by_user_id
                                left JOIN employee e on u.employee_id=e.id
                                inner JOIN prefix pr on e.prefix_id=pr.id
                                inner JOIN division d on e.division_id=d.id
                                and (i.incident_date BETWEEN '".$param_s."' and  '".$param_e."')
                                and headrm_delete !='Y'
                                group by i.by_user_id
                                ORDER BY DivisionID asc
                            "
                        );
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
                                    -- i.by_user_id,
                                    -- u.name  ,
                                    count(i.by_user_id) As CountPost,
                                    concat(pr.name,e.fname,'  ',e.lname ) as EmployeeName	,
                                    e.division_id	 as DivisionID ,
                                    d.name DivisionName

                                    from
                                    users u
                                    INNER JOIN incident i on u.id=i.by_user_id
                                    left JOIN employee e on u.employee_id=e.id
                                    inner JOIN prefix pr on e.prefix_id=pr.id
                                    inner JOIN division d on e.division_id=d.id
                                    and (i.incident_date BETWEEN '".$param_s."' and  '".$param_e."')
                                    and e.division_id='".$division_id."'
                                    group by i.by_user_id
                                    ORDER BY DivisionID asc
                                "
                            );

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
                                -- i.by_user_id,
                                -- u.name  ,
                                count(i.by_user_id) As CountPost,
                                concat(pr.name,e.fname,'  ',e.lname ) as EmployeeName	,
                                e.division_id	 as DivisionID ,
                                d.name DivisionName

                                from
                                users u
                                INNER JOIN incident i on u.id=i.by_user_id
                                left JOIN employee e on u.employee_id=e.id
                                inner JOIN prefix pr on e.prefix_id=pr.id
                                inner JOIN division d on e.division_id=d.id
                                and (i.incident_date BETWEEN '".$param_s."' and  '".$param_e."')
                                and e.division_id='".$division_id."'
                                and e.subdivision_id='".$subdivision_id."'

                                group by i.by_user_id
                                ORDER BY DivisionID asc
                            "
                        );


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
      return view('reports.usersreportall.index')
        ->with('subdivision_id',$subdivision_id )
        ->with('division',$rs_division)
        ->with('division_id',$division_id)
        ->with('url_date' , $url_date )
        ->with('data',$data);
    }
    else
    {
      return view('reports.usersreportall.index')
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
