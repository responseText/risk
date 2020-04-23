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
use App\Evaluation;
use App\IncidentCase;
class HeadRMListAllController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  //----------------------------------------------------------------------------
  public function search(Request $request)
  {
    $division           = Division::select('id','name')->where([['status','=','enable']])->get();
    $evaluation           = Evaluation::select('id','name')->where([['status','=','enable']])->get();
    $data =Incident::where([['status','=','enable'],['headrm_delete','=','']]);
    $arr_division =array();
    if(!empty($request->input('filter-division')))
    {
      if(count($request->input('filter-division')) > 0 )
      {
        foreach ($request->input('filter-division') as $value)
        {
          $arr_division[] =$value;
        }
      }

      $data->whereIn('division_id',$arr_division)  ;
    }
    if(!empty($request->input('filter-daterage')))
    {
      list($param_d1,$param_d2) =  explode(" - " ,$request->input('filter-daterage'));
      $param_date1          = str_replace("/","-",$param_d1);
      $param_date2          = str_replace("/","-",$param_d2);
      $data->whereBetween("incident_date",[$param_date1 , $param_date2]);
    }
    if( !empty($request->input('evaluation')))
    {
      if($request->input('evaluation')=='99')
      {
        $data->where('incident_status_id','=',null)  ;
      }
      else
      {
          $data->where('incident_status_id','=',$request->input('evaluation'))  ;
      }


    }

   $data->orderBy('incident_date', 'desc');
   $count = $data->count();
   $data =  $data->paginate( $count  );
   return view('headrmlistall.index')
     ->with( 'data' , $data )
     ->with('division',$division)
     ->with('evaluation',$evaluation);
  }
  //-----------------------------------------------------------------------------
  public function index(Request $request)
  {
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    {
      $division           = Division::select('id','name')->where([['status','=','enable']])->get();
      $evaluation         = Evaluation::select('id','name')->where([['status','=','enable']])->get();
      $data               = Incident::where([['status','=','enable'],['headrm_delete','=',''] ]);
    }
    else
    {
    abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }
    if( !empty($request->input('filter-division')))
    {
          foreach( $request->input('filter-division') as $k )
          {
              $arr_filter_division[] = $k;
          }

        $data->whereIn('division_id',$arr_filter_division)  ;
    }

    if( !empty($request->input('evaluation')))
    {
      if($request->input('evaluation')=='99')
      {
        $data->where('incident_status_id','=',null)  ;
      }
      else
      {
          $data->where('incident_status_id','=',$request->input('evaluation'))  ;
      }


    }

    if( !empty($request->input('filter-daterage')))
    {
        list($param_d1,$param_d2) =  explode(" - " ,$request->input('filter-daterage'));
        $param_date1          = $param_d1;
        $param_date2          = $param_d2;
        $data->whereBetween("incident_date",[$param_date1 , $param_date2]);
    }
  $count = $data->count();
  $data =  $data->paginate( $count  );
    return view('headrmlistall.index')
      ->with( 'data' , $data )
      ->with('division',$division)
      ->with('evaluation',$evaluation);
  }
  public function show($id)
  {
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    {
      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      $rs_invaluation         = Evaluation::where('status','=','enable')->get();
      $data               =   Incident::findorfail($id);
      return view('headrmlistall.show')
        ->with( 'data' , $data )
        ->with('rs_division',$rs_division)
        ->with('rs_incidentcase',$rs_incidentcase)
        ->with('rs_invaluation',$rs_invaluation)
        ->with('rs_typerisk',$rs_typerisk);
    }
    else
    {
      abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }
  }
  public function callbackrm(Request $request)
  {
    //echo $request->js_id;
    $myObj = Incident::where('id', $request->js_id)
    ->update([
      'headrm_sendto_headdivision_status'     => null ,
      'headrm_sendto_headdivision_date'       => null,
      'headrm_sendto_headdivision_by_id'      => null
      ]);
      return redirect()
              ->action('HeadRMListAllController@index' );
  }
}
