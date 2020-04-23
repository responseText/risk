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
use App\IncidentGroup;
use App\IncidentList;
use App\IncidentCase;
class HeadRMSendBackController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
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


    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    {
      $data               =   Incident::where([['headrm_sendto_headdivision_status','=','sendback'],['headrm_delete','=','']])
                                        //->orWhere([['headrm_delete','=','']])
                                        ->get();
    }
    return view('headrmsendback.index')
      ->with( 'data' , $data );
  }

  public function show($id)
  {

      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $rs_incidentcase          = IncidentCase::where('status','=','enable')->get();
      $rs_incidentgroup       = IncidentGroup::where('status','=','enable')->get();
      $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      $data               =   Incident::where([['headrm_sendto_headdivision_status','=','sendback']])->findorfail($id);
      return view('headrmsendback.show')
        ->with( 'data' , $data )
        ->with('rs_division',$rs_division)
        ->with('rs_typerisk',$rs_typerisk)
        ->with('rs_incidentcase',$rs_incidentcase)
        ->with('rs_incidentgroup',$rs_incidentgroup)
        ->with('rs_incidentcase',$rs_incidentcase)
        ;
  }
  // -------------------------------------------------------------------------
  public function update(Request $request, $id)
  {

      $myObj = Incident::where('id', $id)
                  ->update([
                    'division_id'                           => $request->input('division') ,
                    'sub_division_id'                       => $request->input('subdivision') ,
                    'incident_group_id'                     => $request->input('incident_group') ,
                    'incident_list_id'                       => $request->input('incident_list') ,
                    'type_risk_id'                          => $request->input('typerisk') ,
                    'violence_id'                           => $request->input('violence') ,
                    'headrm_sendto_headdivision_status'     => 'Y' ,
                    'headrm_sendto_headdivision_date'       => Carbon::now(),
                    'headrm_sendto_headdivision_by_id'      => Auth::user()->id,

                  ]);
            return redirect()
                    ->action('HeadRMSendBackController@index' );


  }
  //---------------------------------------------------------------------------------------------------
  public function updateevent(Request $request)
  {

      $checkMyParam ;
      if(isset($request->incidentcase) )
      {
        $checkMyParam =count($request->input('incidentcase'));
      }
      else
      {
        $checkMyParam=0;
      }

      $myParam;
      if($checkMyParam >  0 )
      {
        $myParam=implode(',',$request->input('incidentcase'));
      }
      else
      {
        $myParam = null;
      }
      $myObj = Incident::where('id', $request->js_id)
                  ->update([
                    'incident_case_id'                           =>  $myParam
                  ]);
            $request->session()->flash('success', 'ข้อมูล Near Miss และ Sentinel Event ได้ปรับปรุงเรียบร้อยแล้ว');
            return redirect()->action('HeadRMSendBackController@show',array($request->js_id ));
            //return redirect()->action( 'HeadRMRemoveController@show',array($id) );


  }
  //-----------------------------------------------------------------------------
  public function promptremove($id)
  {
                $data     =   Incident::where([['headrm_sendto_headdivision_status','=','sendback']])->findorfail($id);
          return view('headrmsendback.promptremove')->with('id',$id)->with('data',$data);
  }
  //-----------------------------------------------------------------------------
  public function headrmdelete(Request $request)
  {
    $id = $request->js_id;
    $messages =
    [
        'headrmdeletedescription.required'                 => 'กรุณากรอกข้อมูลวันที่เกิดเหตุ.',

    ];
    $rules =
    [
        'headrmdeletedescription'                           =>'required' ,

    ];
    $validator = Validator::make($request->all(), $rules,$messages );

    if( $validator->fails() )
    {
        return redirect()
                  ->action( 'HeadRMSendBackController@promptremove',array($id))
                  ->withErrors($validator)
                  ->withInput();
    }
    else
    {
      DB::beginTransaction();
      $myObj = Incident::where('id', $id)
                  ->update([

                    'headrm_delete_descrition'            => $request->input('headrmdeletedescription') ,
                    'headrm_delete'                       => 'Y' ,
                    'headrm_delete_byid'                  => Auth::user()->id ,


                  ]);
        if(  $myObj )
        {
            DB::commit();
            return redirect()->action( 'HeadRMSendBackController@show',array($id) );
        }
        else
        {
          DB::rollBack();
            return redirect()->action( 'HeadRMSendBackController@promptremove',array($id) );
        }

    }

  }

//------------------------------------------------------------------------------
  public function rmrestore(Request $request)
  {
    $id = $request->js_id;
    DB::beginTransaction();
    $myObj = Incident::where('id', $id)
                ->update([

                  'headrm_delete_descrition'            => '' ,
                  'headrm_delete'                       => '' ,
                  'headrm_delete_byid'                  => '' ,

                ]);
      if(  $myObj )
      {
          DB::commit();
          return redirect()->action( 'HeadRMSendBackController@show',array($id) );
      }
      else
      {
        DB::rollBack();
          return redirect()->action( 'HeadRMSendBackController@show',array($id) );
      }

  }
}
