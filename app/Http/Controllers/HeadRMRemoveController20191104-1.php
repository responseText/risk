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
class HeadRMRemoveController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {


    if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    {
      $data               =   Incident::where([['headrm_sendto_headdivision_status','=',null],['headrm_delete','=','']])
                                        ->orWhere('headrm_sendto_headdivision_status','=','N')->get();
    }
    return view('headrmremove.index')
      ->with( 'data' , $data );
  }
  // -------------------------------------------------------------------------------------------------------------------------
  public function show($id)
  {

      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $rs_incidentgroup       = IncidentGroup::where('status','=','enable')->get();
      $data               =   Incident::where([['headrm_sendto_headdivision_status','=',null]])->findorfail($id);
      return view('headrmremove.show')
        ->with( 'data' , $data )
        ->with('rs_division',$rs_division)
        ->with('rs_typerisk',$rs_typerisk)
        ->with('rs_incidentgroup',$rs_incidentgroup)
        ;
  }
  // -------------------------------------------------------------------------------------------------------------------------
  public function show1($id)
  {


      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $data               =   Incident::where([['headrm_sendto_headdivision_status','=',null]])->findorfail($id);
      return view('headrmremove.show1')
        ->with( 'data' , $data )
        ->with('rs_division',$rs_division)
        ->with('rs_typerisk',$rs_typerisk);

    //$data               =   Incident::where([['headrm_sendto_headdivision_status','=','N'],['id','=',$id]])->first();
    //echo  'This '.$data;
        //echo 'hellp';
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
                    ->action('HeadRMRemoveController@index' );


  }







  //-----------------------------------------------------------------------------
  //--------------------------------------------------------------------------
  public function getsubdivision($id)
  {
              $data   =   SubDivision::select('id','name')->where('division_id','=',$id)
                          ->get();
                          return response()->json(  $data );
  }

  //--------------------------------------------------------------------------
  public function getviolence($id)
  {
              $data   =   Violence::select('id','code','name')
                          ->where('typerisK_id','=',$id)
                          ->orderBy('code','asc')
                          ->get();
                          return response()->json(  $data );
  }
  //--------------------------------------------------------------------------
  public function getincidentlist($id)
  {
              $data   =   IncidentList::select('id','name')->where('incident_group_id','=',$id)
                          ->get();
                          return response()->json(  $data );
  }
  public function promptremove($id)
  {
                $data     =   Incident::where([['headrm_sendto_headdivision_status','=',null]])->findorfail($id);
          return view('headrmremove.promptremove')->with('id',$id)->with('data',$data);
  }
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
                  ->action( 'HeadRMRemoveController@promptremove',array($id))
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
            return redirect()->action( 'HeadRMRemoveController@show',array($id) );
        }
        else
        {
          DB::rollBack();
            return redirect()->action( 'HeadRMRemoveController@promptremove',array($id) );
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
          return redirect()->action( 'HeadRMRemoveController@show',array($id) );
      }
      else
      {
        DB::rollBack();
          return redirect()->action( 'HeadRMRemoveController@show',array($id) );
      }

  }

}
