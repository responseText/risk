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

class SubDivisionDetailsController extends Controller
{
    public function index(Request $request)
    {
        $division_id ='';
        $arrsubdivision = array();
        $olddaterage = '';
        $data = Incident::where([
                                    ['headrm_sendto_headdivision_status','=','Y']
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
                $division_id='';
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

        $count          = $data->count();
        $data           =  $data->orderBy( 'incident_date','desc'  );
         $data           =  $data->paginate( $count  );
        $rs_division    = Division::select('id','name')
                                    ->where('status','=','enable')
                                    ->get();
      return view('reports.subdivision.index')
                ->with('division',$rs_division)             // ข้อมูลกลุ่มงานจากการ select ทั้งหมด      //
                ->with('division_id',$division_id )         // ข้อมูล กลุ่มงาน จากการเลือก select box   //
                ->with('arrsubdivision',$arrsubdivision )   // ข้อมูล Array กลุ่มงาน                  //
                ->with('olddaterage',$olddaterage )         // ข้อมูลวันที่เก่าที่เลือก                     //
                ->with('data',$data );                      // ข้อมูลจากการ select                  //
    }
    //--------------------------------------------------------------------------
    public function getsubdivision($id)
    {
                $data   =   SubDivision::select('id','name')->where([['division_id','=',$id],['status','=','enable']])
                            ->get();
                            return response()->json(  $data );
    }
}
