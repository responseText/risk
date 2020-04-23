<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SubDivision;
use App\Division;
class SubDivisionController extends Controller
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
    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))

    {
      $data               =   SubDivision::withTrashed()->get();
    }
    else
    {
      $data               =   SubDivision::get();
    }
    return view('subdivision.index')
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


    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {
        $rs_divsion        =   Division::where('status','=','enable')->get();

      return view('subdivision.create')->with('rs_divsion',$rs_divsion);
    }
    else
    {
     abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }





  }
  // -------------------------------------------------------------------------
  public function store(Request $request)
  {
/*
    if( isset($request->is_division))
    {
    echo 'value : '.$request->is_division;
  }else {
    echo 'MO';
  }
  */

   $messages =
   [
       'name.required'                          => 'กรุณากรอกข้อมูลหน่วยงาน.',
       'division.required'                      => 'กรุณาเลือกกลุ่มงาน.',
   ];
   $rules =
   [
       'name'                                    => 'required',
       'division'                                => 'required',
   ];
   $validator = Validator::make($request->all(), $rules,$messages );

   if( $validator->fails() )
   {
       return redirect()
                 ->action( 'SubDivisionController@create')
                 ->withErrors($validator)
                 ->withInput();
   }
   else
   {
       $myObj = new SubDivision;
       $myObj->name                        = $request->input('name');
       $myObj->division_id                 = $request->input('division');
       if( isset($request->is_division))
       {
        $myObj->is_division                 =  $request->is_division;
       }

       $myObj->status                      = 'enable';
       $myObj->save();
       $id =   $myObj->id;

       if(  $myObj )
       {
           return redirect()->action( 'SubDivisionController@index' );
       }
       else
       {
           return redirect()->action( 'SubDivisionController@create');
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
    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {
      $data               =   SubDivision::withTrashed()->findorfail($id);
      return view('subdivision.show')
        ->with( 'data' , $data );
    }
    else
    {
      $data               =   SubDivision::findorfail($id);
      return view('subdivision.show')
        ->with( 'data' , $data );
    }


  }
  //-----------------------------------------------------------------------------
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
   if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
   {
      $data               =   SubDivision::withTrashed()->where('id',$id)  ->first();
      $rs_divsion        =   Division::where('status','=','enable')->get();
      return view('subdivision.edit')
        ->with( 'data' , $data )->with('rs_divsion',$rs_divsion);
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
        'name.required'                          => 'กรุณากรอกข้อมูลหน่วยงาน.',
        'division.required'                      => 'กรุณาเลือกกลุ่มงาน.',
    ];
    $rules =
    [
        'name'                                    => 'required',
        'division'                                => 'required',
    ];
     $validator = Validator::make($request->all(), $rules,$messages );

     if( $validator->fails() )
     {
         return redirect()
                   ->action( 'SubDivisionController@edit',array($id))
                   //->route('company.create')
                   ->withErrors($validator)
                   ->withInput();
     }
     else
     {
       $value_division = null;
       if( isset($request->is_division))
       {
         $value_division  = $request->is_division;
       }
       else
       {
         $value_division = null;
       }
       $myObj = SubDivision::withTrashed()->where('id', $id)
                  ->update([
                    'name'                    => $request->input('name') ,
                    'division_id'             => $request->input('division') ,
                    'is_division'             => $value_division ,
                  ]);
            return redirect()
                    ->action('SubDivisionController@show',array($id) );

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
  if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {
      $data = SubDivision::find($id);
      $data->delete();
      return redirect()
          ->action( 'SubDivisionController@index');

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
    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {
          $sql= SubDivision::whereIN('id',$request->checkboxID )
                    ->delete();
          if($sql)
          {
            return redirect()
              ->action( 'SubDivisionController@index');
          }
          else
          {
            return redirect()
              ->action( 'SubDivisionController@index');
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
    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {
      $data =  SubDivision::where('id', $id)
        ->restore();
      return redirect()
          ->action( 'SubDivisionController@index');
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
   if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
   {
         $data =  SubDivision::withTrashed()
                   ->whereIN('id',$request->checkboxID )
                   ->restore();
         if($data)
         {
           return redirect()
             ->action( 'SubDivisionController@index');
         }
         else
         {
           return redirect()
             ->action( 'SubDivisionController@index');
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
   if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
   {
       $data = SubDivision::onlyTrashed()
                  ->where('id', $id);
       $data->forceDelete();
       return redirect()
             ->action( 'SubDivisionController@index');
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
    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {
        $sql=  SubDivision::whereIN('id',$request->checkboxID )
                  ->forceDelete();
        if($sql)
        {
          return redirect()
            ->action( 'SubDivisionController@index');
        }
        else
        {
          return redirect()
            ->action( 'SubDivisionController@index');
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
    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {
                            $data              =   SubDivision::withTrashed()->where('id',$id)
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
    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {

      $myObj = SubDivision::withTrashed()
                  ->where( 'id', $request->js_id )
                  ->update([
                    'status'  => $request->status ,
                  ]);

      if($myObj)
      {
      //  $newstatus="";
        $oldstatus =  SubDivision::withTrashed()
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
