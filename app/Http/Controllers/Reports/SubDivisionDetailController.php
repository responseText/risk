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
use App\Exports\SubDivisionDetailExport;

class SubDivisionDetailController extends Controller
{
  public function index(Request $request)
  {
    $url_date='';
    $arrsubdivision = array();
    $division_id =0;
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

      $data = Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'],
                                  ['headrm_delete','=','']
                              ]);
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
              $data->whereBetween("incident_date",[$param_s , $param_e]);
          }
          else
          {
              $olddaterage='';
          }
          if(isset($request->division))
          {
              if( $request->division != '0' || !empty($request->division) )
              {
                  $division_id = $request->division;
                  $data->where('division_id',$division_id) ;
              }
              else
              {
                  $division_id=0;
              }
          }
          if(isset($request->subdivision))
          {

              foreach( $request->subdivision as $k )
              {
                  $arrsubdivision[] = $k;
              }

              $data->whereIn('sub_division_id',$arrsubdivision)  ;

          }
          else
          {
              $arrsubdivision=array();
          }
      }
      $count          = $data->count();
      $data           =  $data->orderBy( 'incident_date','desc'  );
      $data           =  $data->paginate( $count  );
      return view('reports.subdivisiondetail.index')
        ->with('arrsubdivision',$arrsubdivision )
        ->with('division',$rs_division)
        ->with('division_id',$division_id)
        ->with('url_date' , $url_date )
        ->with('data',$data);
    }
    else
    {
      return view('reports.subdivisiondetail.index')
        ->with('arrsubdivision',$arrsubdivision )
        ->with('division',$rs_division)
        ->with('url_date' , $url_date )
        ->with('division_id',$division_id);

    }
  }
  //--------------------------------------------------
  public function show($id)
  {
    $rs = Incident::findorfail($id);
    return view('reports.subdivisiondetail.show')
              ->with('data' , $rs );

  }
  //--------------------------------------------------------------------------
  public function getsubdivision($id)
  {
              $data   =   SubDivision::select('id','name')->where([['division_id','=',$id],['status','=','enable']])
                          ->get();
                          return response()->json(  $data );
  }
  public function exportExcel($division,$subdivision,$originaldate)
  {

    return Excel::download(new SubDivisionDetailExport($division,$subdivision,$originaldate), 'ความเสี่ยงที่เกิดขึ้นแยกหน่วยงาน(ละเอียด).xlsx' );
    /*
    list($sdate,$edate) =  explode("_" ,$originaldate);
    $data = Incident::where([['headrm_sendto_headdivision_status','Y']]);

          if($division !='')
          {
              $data->where('division_id','=',$division) ;
          }
$aa = explode('-',$subdivision);
echo count($aa);
print_r($aa);
          if(count($aa) > 1 )
          {
            $data->whereIn('sub_division_id',$aa) ;
          }
          else
          {

          }

          $data->whereBetween('incident_date', [ $sdate ,  $edate ] ) ;

          $count          = $data->count();

          $data->orderBy( 'incident_date','desc'  );
          $data           =  $data->paginate( $count  );
          dd($data);
        */




  }
}
