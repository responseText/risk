<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\IncidentCase;
class IncidentCasecontroller extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  // -------------------------------------------------------------------------
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    {
      $data               =   IncidentCase::withTrashed()->get();
    }
    else
    {
      $data               =   IncidentCase::get();
    }
    return view('incidentcase.index')
      ->with( 'data' , $data );
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    {
      return view('incidentcase.create');
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
       'name.required'                          => 'กรุณากรอกโอกาสที่ได้เกิดความเสี่ยง.',
   ];
   $rules =
   [
       'name'                                    => 'required',
   ];
   $validator = Validator::make($request->all(), $rules,$messages );

   if( $validator->fails() )
   {
       return redirect()
                 ->action( 'IncidentCaseController@create')
                 ->withErrors($validator)
                 ->withInput();
   }
   else
   {
       $myObj = new IncidentCase;
       $myObj->name                        = $request->input('name');
       $myObj->status                      = 'enable';
       $myObj->save();
       $id =   $myObj->id;

       if(  $myObj )
       {
           return redirect()->action( 'IncidentCaseController@index' );
       }
       else
       {
           return redirect()->action( 'IncidentCaseController@create');
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    {
      $data               =   IncidentCase::withTrashed()->findorfail($id);
      return view('incidentcase.show')
        ->with( 'data' , $data );
    }
    else
    {
      $data               =   IncidentCase::findorfail($id);
      return view('incidentcase.show')
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
      $data               =   IncidentCase::withTrashed()->where('id',$id)  ->first();
      return view('incidentcase.edit')
        ->with( 'data' , $data );

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
       'name.required'                               => 'กรุณากรอกโอกาสที่ได้เกิดความเสี่ยง.',


   ];
   $rules =
   [
       'name'                                       => 'required',


   ];
     //dd($request);

     $validator = Validator::make($request->all(), $rules,$messages );

     if( $validator->fails() )
     {
         return redirect()
                   ->action( 'IncidentCaseController@edit',array($id))
                   //->route('company.create')
                   ->withErrors($validator)
                   ->withInput();
     }
     else
     {
      $myObj = IncidentCase::withTrashed()->where('id', $id)
                  ->update([
                    'name'                    => $request->input('name') ,
                  ]);
            return redirect()
                    ->action('IncidentCaseController@show',array($id) );

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
      $data = IncidentCase::find($id);
      $data->delete();
      return redirect()
          ->action( 'IncidentCaseController@index');

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
          $sql= IncidentCase::whereIN('id',$request->checkboxID )
                    ->delete();
          if($sql)
          {
            return redirect()
              ->action( 'IncidentCaseController@index');
          }
          else
          {
            return redirect()
              ->action( 'IncidentCaseController@index');
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
      $data =  IncidentCase::where('id', $id)
        ->restore();
      return redirect()
          ->action( 'IncidentCaseController@index');
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
         $data =  IncidentCase::withTrashed()
                   ->whereIN('id',$request->checkboxID )
                   ->restore();
         if($data)
         {
           return redirect()
             ->action( 'IncidentCaseController@index');
         }
         else
         {
           return redirect()
             ->action( 'IncidentCaseController@index');
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
       $data = IncidentCase::onlyTrashed()
                  ->where('id', $id);
       $data->forceDelete();
       return redirect()
             ->action( 'IncidentCaseController@index');
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
        $sql=  IncidentCase::whereIN('id',$request->checkboxID )
                  ->forceDelete();
        if($sql)
        {
          return redirect()
            ->action( 'IncidentCaseController@index');
        }
        else
        {
          return redirect()
            ->action( 'IncidentCaseController@index');
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
                            $data              =   IncidentCase::withTrashed()->where('id',$id)
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

      $myObj = IncidentCase::withTrashed()
                  ->where( 'id', $request->js_id )
                  ->update([
                    'status'  => $request->status ,
                  ]);

      if($myObj)
      {
      //  $newstatus="";
        $oldstatus =  IncidentCase::withTrashed()
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
