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
use App\RiskProgram;
class IncidentGroupController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  /*
  public function search(Request $request)
  {
    //dd($_POST);
    $rs_incidentProgram = RiskProgram::where('status','=','enable')->get();
    $rs_incidentProgram_id='';
    //dd($request);
    if( isset($request->selectProgram))
    {
      //dd($request);
      //echo $request->input('selectGroup');



    }
    else
    {
          return redirect()->route('incidentgroup.index') ;
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
    $rs_incidentProgram_id='';
    $rs_incidentProgram = RiskProgram::where('status','=','enable')->get();
    if( isset($request->selectProgram))
    {

        if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
        {
              $data    =   IncidentGroup::withTrashed()
                            //->where('')
                            ->where('risk_program_id','=',$request->selectProgram )
                            ->get();
              return view('incidentgroup.index')
                          ->with('data',$data)
                          ->with('incidentprogram',$rs_incidentProgram)
                          ->with('selectprogramid',$request->selectProgram);

        }
        else
        {
          $data        =   IncidentGroup::where('risk_program_id','=',$request->selectProgram )
                            ->get();
                            return view('incidentgroup.index')
                                        ->with('data',$data)
                                        ->with('incidentprogram',$rs_incidentProgram)
                                        ->with('selectprogramid',$request->selectProgram);

        }

    }
    else
    {
        if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
        {
          $data               =   IncidentGroup::withTrashed()->get();

        }
        else
        {
          $data               =   IncidentGroup::get();

        }
        return view('incidentgroup.index')
          ->with('incidentprogram',$rs_incidentProgram)
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
    {
        $rs_riskprogram        =   RiskProgram::where('status','=','enable')->get();
      return view('incidentgroup.create')
              ->with( 'rs_riskprogram' , $rs_riskprogram);
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
        'name.required'                          => 'กรุณากรอกหมวดหมู่อุบัติการณ์.',
        'risk_program.required'                   => 'กรุณาเลือกโปรแกรมความเสี่ยง.',
    ];
    $rules =
    [
        'name'                                    => 'required',
        'risk_program'                            => 'required',
    ];

   $validator = Validator::make($request->all(), $rules,$messages );

   if( $validator->fails() )
   {
       return redirect()
                 ->action( 'IncidentGroupController@create')
                 ->withErrors($validator)
                 ->withInput();
   }
   else
   {
       $myObj = new IncidentGroup;

       $myObj->name                        = $request->input('name');
       $myObj->risk_program_id            = $request->input('risk_program');
       $myObj->status                      = 'enable';
       $myObj->save();
       $id =   $myObj->id;

       if(  $myObj )
       {
           return redirect()->action( 'IncidentGroupController@index' );
       }
       else
       {
           return redirect()->action( 'IncidentGroupController@create');
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
    {
      $data               =   IncidentGroup::withTrashed()->findorfail($id);
      return view('incidentgroup.show')
        ->with( 'data' , $data );
    }
    else
    {
      $data               =   IncidentGroup::findorfail($id);
      return view('incidentgroup.show')
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
   if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
   {
      $data               =   IncidentGroup::withTrashed()->where('id',$id)  ->first();
      $rs_riskprogram        =   RiskProgram::where('status','=','enable')->get();

      return view('incidentgroup.edit')
        ->with( 'data' , $data )
        ->with( 'rs_riskprogram' , $rs_riskprogram);


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
        'name.required'                          => 'กรุณากรอกหมวดหมู่อุบัติการณ์.',
        'risk_program.required'                   => 'กรุณาเลือกโปรแกรมความเสี่ยง.',
    ];
    $rules =
    [
        'name'                                    => 'required',
        'risk_program'                            => 'required',
    ];

     //dd($request);

     $validator = Validator::make($request->all(), $rules,$messages );

     if( $validator->fails() )
     {
         return redirect()
                   ->action( 'IncidentGroupController@edit',array($id))
                   //->route('company.create')
                   ->withErrors($validator)
                   ->withInput();
     }
     else
     {
      $myObj = IncidentGroup::withTrashed()->where('id', $id)
                  ->update([
                    'name'                    => $request->input('name') ,
                    'risk_program_id'        => $request->input('risk_program') ,
                  ]);
            return redirect()
                    ->action('IncidentGroupController@show',array($id) );

     }
  }
  //--------------------------------------------------------------------------
  public function destroy($id)
  {
    DB::beginTransaction();
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
    {
      $rs1 = IncidentGroup::find($id);
      $rs1->delete();

      if( $rs1)
      {
        $rs2 = IncidentList::where('incident_group_id','=',$id);
        $rs2->delete();
        if(  $rs1 && $rs2)
        {
          DB::commit();
          return redirect()
              ->action( 'IncidentGroupController@index');
        }
        else
        {
        DB::rollBack();
        }
      }
      else
      {
        DB::rollBack();
      }




     }
     else
     {
     abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
     }


  }
  /*----------------------------------- Delete All -------------------------------------*/
  public function softdeleteall(Request $request)
  {
    DB::beginTransaction();
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
    {
          $sql1= IncidentGroup::whereIN('id',$request->checkboxID )
                    ->delete();
          if($sql1)
          {
            $sql2= IncidentList::whereIN('incident_group_id',$request->checkboxID )
                      ->delete();
            if( $sql2 )
            {
              DB::commit();
              return redirect()
                ->action( 'IncidentGroupController@index');
            }
            else
            {
              DB::rollBack();
              return redirect()
                ->action( 'IncidentGroupController@index');
            }
          }
          else
          {
            DB::rollBack();
            return redirect()
              ->action( 'IncidentGroupController@index');
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
    DB::beginTransaction();
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
    {

      $data1 =  IncidentGroup::where('id', $id)
        ->restore();
      if($data1)
      {
        $data2 =  IncidentList::where('incident_group_id', $id)
          ->restore();
        if( $data2 )
        {
          DB::commit();
          return redirect()
              ->action( 'IncidentGroupController@index');
        }
        else
        {
          DB::rollBack();
          return redirect()
              ->action( 'IncidentGroupController@index');
        }

      }
      else
      {
        DB::rollBack();
        return redirect()
            ->action( 'IncidentGroupController@index');
      }



     }
     else
     {
     abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
     }




  }
  /*----------------------------------- Restore All -------------------------------------*/
 public function restoreall(Request $request)
 {
   DB::beginTransaction();
   $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
   // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
   if(count(Auth::user()->user_level) > 0 )
   {
     foreach( Auth::user()->user_level as $kk => $vv)
     {
       $arr_user_level[]=$vv->level_id;
     }
   }
   if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
   {
         $data =  IncidentGroup::withTrashed()
                   ->whereIN('id',$request->checkboxID )
                   ->restore();
         if($data)
         {
           $data2 =  IncidentList::withTrashed()->whereIN('incident_group_id', $id)
             ->restore();
          if($data2)
          {
            DB::commit();
            return redirect()
              ->action( 'IncidentGroupController@index');
          }
          else
          {
            DB::rollBack();
            return redirect()
              ->action( 'IncidentGroupController@index');
          }

         }
         else
         {
           DB::rollBack();
           return redirect()
             ->action( 'IncidentGroupController@index');
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
   if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
   {
     DB::beginTransaction();
       $data = IncidentGroup::onlyTrashed()
                  ->where('id', $id);
       $data->forceDelete();
       if($data)
       {
         $data1 = IncidentList::onlyTrashed()
                    ->where('incident_group_id', $id);
         $data1->forceDelete();
         if($data1)
         {
           DB::commit();
           return redirect()
                 ->action( 'IncidentGroupController@index');
         }
         else
         {
           DB::rollBack();
           return redirect()
                 ->action( 'IncidentGroupController@index');
         }
       }
       else
       {
         DB::rollBack();
         return redirect()
               ->action( 'IncidentGroupController@index');
       }

    }
    else
    {
    abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }

 }
 /*----------------------------------- Delete All -------------------------------------*/
  public function trashall(Request $request)
  {
    DB::beginTransaction();
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
    {
        $sql=  IncidentGroup::whereIN('id',$request->checkboxID )
                  ->forceDelete();
        if($sql)
        {
          $sql1 =  IncidentList::whereIN('incident_group_id',$request->checkboxID )
                    ->forceDelete();
          if($sql1)
          {
            DB::commit();
            return redirect()
              ->action( 'IncidentGroupController@index');
          }
          else
          {
            DB::rollBack();
            return redirect()
              ->action( 'IncidentGroupController@index');
          }

        }
        else
        {
          DB::rollBack();
          return redirect()
            ->action( 'IncidentGroupController@index');
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
    {
                            $data              =   IncidentGroup::withTrashed()->where('id',$id)
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
    DB::beginTransaction();
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )
    {

      $myObj = IncidentGroup::withTrashed()
                  ->where( 'id', $request->js_id )
                  ->update([
                    'status'  => $request->status ,
                  ]);

      if($myObj)
      {
        $myObj2 = IncidentList::withTrashed()
                    ->where( 'incident_group_id', $request->js_id )
                    ->update([
                      'status'  => $request->status ,
                    ]);
          if( $myObj2 )
          {
            DB::commit();
            $oldstatus =  IncidentGroup::withTrashed()
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
          else
          {
            DB::rollBack();
            $oldstatus =  IncidentGroup::withTrashed()
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
                'state'   =>'false' ,
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
            DB::rollBack();
            $oldstatus =  IncidentGroup::withTrashed()
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
                'state'   =>'false' ,
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
