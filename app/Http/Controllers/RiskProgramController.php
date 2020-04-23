<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RiskProgram;
class RiskProgramController extends Controller
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
      $data               =   RiskProgram::withTrashed()->get();
    }
    else
    {
      $data               =   RiskProgram::get();
    }
    return view('riskprogram.index')
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
      return view('riskprogram.create');
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
       'name.required'                          => 'กรุณากรอกชื่อโปรแกรมความเสี่ยง.',
   ];
   $rules =
   [
       'name'                                    => 'required',
   ];
   $validator = Validator::make($request->all(), $rules,$messages );

   if( $validator->fails() )
   {
       return redirect()
                 ->action( 'RiskProgramController@create')
                 ->withErrors($validator)
                 ->withInput();
   }
   else
   {
       $myObj = new RiskProgram;
       $myObj->name                        = $request->input('name');
       $myObj->status                      = 'enable';
       $myObj->save();
       $id =   $myObj->id;

       if(  $myObj )
       {
           return redirect()->action( 'RiskProgramController@index' );
       }
       else
       {
           return redirect()->action( 'RiskProgramController@create');
       }
   }
  }
  //--------------------------------------------------------------------------
  public function show($id)
    {
    $data='';
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
      $data               =   RiskProgram::withTrashed()->findorfail($id);
      return view('riskprogram.show')
        ->with( 'data' , $data );
    }
    else
    {
      $data               =   RiskProgram::findorfail($id);
      return view('riskprogram.show')
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
      $data               =   RiskProgram::withTrashed()->where('id',$id)  ->first();
      return view('riskprogram.edit')
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
       'name.required'                               => 'กรุณากรอกชื่อโปรแกรมความเสี่ยง.',


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
                   ->action( 'RiskProgramController@edit',array($id))
                   //->route('company.create')
                   ->withErrors($validator)
                   ->withInput();
     }
     else
     {
      $myObj = RiskProgram::withTrashed()->where('id', $id)
                  ->update([
                    'name'                    => $request->input('name') ,
                  ]);
            return redirect()
                    ->action('RiskProgramController@show',array($id) );

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
      $data = RiskProgram::find($id);
      $data->delete();
      return redirect()
          ->action( 'RiskProgramController@index');

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
          $sql= RiskProgram::whereIN('id',$request->checkboxID )
                    ->delete();
          if($sql)
          {
            return redirect()
              ->action( 'RiskProgramController@index');
          }
          else
          {
            return redirect()
              ->action( 'RiskProgramController@index');
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
      $data =  RiskProgram::where('id', $id)
        ->restore();
      return redirect()
          ->action( 'RiskProgramController@index');
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
         $data =  RiskProgram::withTrashed()
                   ->whereIN('id',$request->checkboxID )
                   ->restore();
         if($data)
         {
           return redirect()
             ->action( 'RiskProgramController@index');
         }
         else
         {
           return redirect()
             ->action( 'RiskProgramController@index');
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
       $data = RiskProgram::onlyTrashed()
                  ->where('id', $id);
       $data->forceDelete();
       return redirect()
             ->action( 'RiskProgramController@index');
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
        $sql=  RiskProgram::whereIN('id',$request->checkboxID )
                  ->forceDelete();
        if($sql)
        {
          return redirect()
            ->action( 'RiskProgramController@index');
        }
        else
        {
          return redirect()
            ->action( 'RiskProgramController@index');
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
                            $data              =   RiskProgram::withTrashed()->where('id',$id)
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

      $myObj = RiskProgram::withTrashed()
                  ->where( 'id', $request->js_id )
                  ->update([
                    'status'  => $request->status ,
                  ]);

      if($myObj)
      {
      //  $newstatus="";
        $oldstatus =  RiskProgram::withTrashed()
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
