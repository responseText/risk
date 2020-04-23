<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\IncidentGroup;
use App\IncidentList;
class IncidentListController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  /*
  public function search(Request $request)
  {
    //dd($_POST);
    $rs_incidentGroup = IncidentGroup::where('status','=','enable')->get();
    $rs_incidentGroup_id='';
    //dd($request);
    if( isset($request->selectGroup))
    {
      //dd($request);
      //echo $request->input('selectGroup');

      if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 )    )
      {
            $data    =   IncidentList::withTrashed()
                          //->where('')
                          ->where('incident_group_id','=',$request->selectGroup )
                          ->get();
            return view('incidentlist.index')
                        ->with('data',$data)
                        ->with('incidentgroup',$rs_incidentGroup)
                        ->with('selectgroupid',$request->selectGroup);

      }
      else
      {
        $data        =   IncidentList::where('incident_group_id','=',$request->selectGroup )
                          ->get();
                          return view('incidentlist.index')
                                      ->with('data',$data)
                                      ->with('incidentgroup',$rs_incidentGroup)
                                      ->with('selectgroupid',$request->selectGroup);

      }

    }
    else
    {
          return redirect()->route('incidentlist.index') ;
    }

  }
  */

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
    $rs_incidentGroup_id='';

    $rs_incidentGroup = IncidentGroup::where('status','=','enable')->get();
    if( isset($request->selectGroup))
    {
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
      {
            $data    =   IncidentList::withTrashed()
                          //->where('')
                          ->where('incident_group_id','=',$request->selectGroup )
                          ->get();
            return view('incidentlist.index')
                        ->with('data',$data)
                        ->with('incidentgroup',$rs_incidentGroup)
                        ->with('selectgroupid',$request->selectGroup);

      }
      else
      {
        $data        =   IncidentList::where('incident_group_id','=',$request->selectGroup )
                          ->get();
                          return view('incidentlist.index')
                                      ->with('data',$data)
                                      ->with('incidentgroup',$rs_incidentGroup)
                                      ->with('selectgroupid',$request->selectGroup);

      }
    }
    else
    {
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
      {
        $data               =   IncidentList::withTrashed()->get();

      }
      else
      {
        $data               =   IncidentList::get();

      }
      return view('incidentlist.index')
        ->with('incidentgroup',$rs_incidentGroup)
        ->with( 'data' , $data );
    }



  }
  //--------------------------------------------------------------------------
  public function create()
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


    //if   ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || Auth::user()->level_id == '3'   )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    {
      $rs_incident_group        =   IncidentGroup::where('status','=','enable')->get();
      return view('incidentlist.create')
              ->with( 'rs_incident_group' , $rs_incident_group);
    }
    else
    {
     abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }





  }
  // -------------------------------------------------------------------------
  public function store(Request $request)
  {
    $messages =
    [
        'name.required'                             => 'กรุณากรอกข้อมูลรายการอุบัติการณ์.',
        'incident_group.required'                   => 'กรุณาเลือกหมวดหมู่อุบัติการณ์.',
    ];
    $rules =
    [
        'name'                                    => 'required',
        'incident_group'                            => 'required',
    ];

   $validator = Validator::make($request->all(), $rules,$messages );

   if( $validator->fails() )
   {
       return redirect()
                 ->action( 'IncidentListController@create')
                 ->withErrors($validator)
                 ->withInput();
   }
   else
   {
       $myObj = new IncidentList;

       $myObj->name                        = $request->input('name');
       $myObj->incident_group_id            = $request->input('incident_group');
       $myObj->status                      = 'enable';
       $myObj->save();
       $id =   $myObj->id;

       if(  $myObj )
       {
           return redirect()->action( 'IncidentListController@index' );
       }
       else
       {
           return redirect()->action( 'IncidentListController@create');
       }
   }
  }
  //--------------------------------------------------------------------------
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

    $data='';
    //if(  (Auth::user()->level_id == 1 ) || (Auth::user()->level_id == 2) || (Auth::user()->level_id == 3)  )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    {
      $data               =   IncidentList::withTrashed()->findorfail($id);
      return view('incidentlist.show')
        ->with( 'data' , $data );
    }
    else
    {
      $data               =   IncidentList::findorfail($id);
      return view('incidentlist.show')
        ->with( 'data' , $data );
    }


  }
  public function edit($id)
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
      $data               =   IncidentList::withTrashed()->where('id',$id)  ->first();
      $rs_incident_group  =   IncidentGroup::where('status','=','enable')->get();

      return view('incidentlist.edit')
        ->with( 'data' , $data )
        ->with( 'rs_incident_group' , $rs_incident_group);


    }
    else
    {
    abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }





  }
  // -------------------------------------------------------------------------
  public function update(Request $request, $id)
  {
    $messages =
    [
        'name.required'                             => 'กรุณากรอกข้อมูลรายการอุบัติการณ์.',
        'incident_group.required'                   => 'กรุณาเลือกหมวดหมู่อุบัติการณ์.',
    ];
    $rules =
    [
        'name'                                    => 'required',
        'incident_group'                            => 'required',
    ];


     //dd($request);

     $validator = Validator::make($request->all(), $rules,$messages );

     if( $validator->fails() )
     {
         return redirect()
                   ->action( 'IncidentListController@edit',array($id))
                   //->route('company.create')
                   ->withErrors($validator)
                   ->withInput();
     }
     else
     {
      $myObj = IncidentList::withTrashed()->where('id', $id)
                  ->update([
                    'name'                    => $request->input('name') ,
                    'incident_group_id'        => $request->input('incident_group') ,
                  ]);
            return redirect()
                    ->action('IncidentListController@show',array($id) );

     }
  }
  //--------------------------------------------------------------------------
  public function destroy($id)
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
      $data = IncidentList::find($id);
      $data->delete();
      return redirect()
          ->action( 'IncidentListController@index');

     }
     else
     {
     abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
     }


  }
  /*----------------------------------- Delete All -------------------------------------*/
  public function softdeleteall(Request $request)
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
          $sql= IncidentList::whereIN('id',$request->checkboxID )
                    ->delete();
          if($sql)
          {
            return redirect()
              ->action( 'IncidentListController@index');
          }
          else
          {
            return redirect()
              ->action( 'IncidentListController@index');
          }
     }
     else
     {
     abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
     }


  }
  //--------------------------------------------------------------------------
  public function restore($id)
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
      $data =  IncidentList::where('id', $id)
        ->restore();
      return redirect()
          ->action( 'IncidentListController@index');
     }
     else
     {
     abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
     }




  }
  /*----------------------------------- Restore All -------------------------------------*/
 public function restoreall(Request $request)
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
         $data =  IncidentList::withTrashed()
                   ->whereIN('id',$request->checkboxID )
                   ->restore();
         if($data)
         {
           return redirect()
             ->action( 'IncidentListController@index');
         }
         else
         {
           return redirect()
             ->action( 'IncidentListController@index');
         }
    }
    else
    {
      abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }






 }

 // --------------------------------------------------------------------------
 public function trash($id)
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
       $data = IncidentList::onlyTrashed()
                  ->where('id', $id);
       $data->forceDelete();
       return redirect()
             ->action( 'IncidentListController@index');
    }
    else
    {
    abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }

 }
 /*----------------------------------- Delete All -------------------------------------*/
  public function trashall(Request $request)
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
        $sql=  IncidentList::whereIN('id',$request->checkboxID )
                  ->forceDelete();
        if($sql)
        {
          return redirect()
            ->action( 'IncidentListController@index');
        }
        else
        {
          return redirect()
            ->action( 'IncidentListController@index');
        }
     }
     else
     {
     abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
     }



  }

  //--------------------------------------------------------------------------
  public function getstatus($id)
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
                            $data              =   IncidentList::withTrashed()->where('id',$id)
                               ->select('status')
                               ->first();
                            return response()->json([
                                'status' => $data->status
                              ]);
     }
     else
     {
     abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
     }




  }
  //--------------------------------------------------------------------------
  public function changestatus(Request $request)
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

      $myObj = IncidentList::withTrashed()
                  ->where( 'id', $request->js_id )
                  ->update([
                    'status'  => $request->status ,
                  ]);

      if($myObj)
      {
      //  $newstatus="";
        $oldstatus =  IncidentList::withTrashed()
                  ->where('id',  $request->js_id)
                  ->select('status')
                  ->first();


       $class='';
       if($oldstatus->status == 'enable')
       {
         $class = 'text-success';
       }
       else
       {
         $class = 'text-danger';
       }
        //return $oldstatus->status;

        $status   = $oldstatus->status;

        return response()->json([
            'js_id'   => $request->js_id ,
            'state'   =>'true' ,
            'cssclass'=> $class ,
            'status'  => $oldstatus->status ,
            'icon'    => ( $status == 'enable'?  'fa-check' :  'fa-times' ) ,
            'message' =>'ระบบได้ปรับปรุงสถานะการใช้งานเรียบร้อยแล้ว.' ,
            'class'   => ( $status == 'enable'? 'btn-success': 'btn-danger' ) ,
            'txt'     => ( $status == 'enable'?  trans('buttons.enable') :  trans('buttons.disable') ) ,
            'value'   => ( $status == 'enable'?  'enable' : 'disable' ) ,
          ]);
      }



     }
     else
     {
       abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
     }


  }
}
