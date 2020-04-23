<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ViolenceLevel;
class ViolenceLevelController extends Controller
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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
      {
        $data               =   ViolenceLevel::withTrashed()->get();
      }
      else
      {
        $data               =   ViolenceLevel::get();
      }
      return view('violencelevel.index')
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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
      {
        return view('violencelevel.create');
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
         'code.required'                          => 'กรุณากรอกรหัสระดับความรุนแรง.',
         'name.required'                          => 'กรุณากรอกข้อมูลระดับความรุนแรง.',
         'color.required'                         => 'กรุณาเลือกสี.',
     ];
     $rules =
     [
         'code'                                    => 'required',
         'name'                                    => 'required',
         'color'                                   => 'required',
     ];
     $validator = Validator::make($request->all(), $rules,$messages );

     if( $validator->fails() )
     {
         return redirect()
                   ->action( 'ViolenceLevelController@create')
                   ->withErrors($validator)
                   ->withInput();
     }
     else
     {
         $myObj = new ViolenceLevel;
         $myObj->code                        = $request->input('code');
         $myObj->name                        = $request->input('name');
         $myObj->color                       = $request->input('color');
         $myObj->status                      = 'enable';
         $myObj->save();
         $id =   $myObj->id;

         if(  $myObj )
         {
             return redirect()->action( 'ViolenceLevelController@index' );
         }
         else
         {
             return redirect()->action( 'ViolenceLevelController@create');
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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
      {
        $data               =   ViolenceLevel::withTrashed()->findorfail($id);
        return view('violencelevel.show')
          ->with( 'data' , $data );
      }
      else
      {
        $data               =   ViolenceLevel::findorfail($id);
        return view('violencelevel.show')
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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
     {
        $data               =   ViolenceLevel::withTrashed()->where('id',$id)  ->first();
        return view('violencelevel.edit')
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
          'code.required'                          => 'กรุณากรอกรหัสระดับความรุนแรง.',
          'name.required'                          => 'กรุณากรอกข้อมูลระดับความรุนแรง.',
          'color.required'                         => 'กรุณาเลือกสี.',
      ];
      $rules =
      [
          'code'                                    => 'required',
          'name'                                    => 'required',
          'color'                                   => 'required',
      ];

       //dd($request);

       $validator = Validator::make($request->all(), $rules,$messages );

       if( $validator->fails() )
       {
           return redirect()
                     ->action( 'ViolenceLevelController@edit',array($id))
                     //->route('company.create')
                     ->withErrors($validator)
                     ->withInput();
       }
       else
       {
        $myObj = ViolenceLevel::withTrashed()->where('id', $id)
                    ->update([
                      'code'                    => $request->input('code') ,
                      'name'                    => $request->input('name') ,
                      'color'                   => $request->input('color') ,
                    ]);
              return redirect()
                      ->action('ViolenceLevelController@show',array($id) );

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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
      {
        $data = ViolenceLevel::find($id);
        $data->delete();
        return redirect()
            ->action( 'ViolenceLevelController@index');

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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
      {
            $sql= ViolenceLevel::whereIN('id',$request->checkboxID )
                      ->delete();
            if($sql)
            {
              return redirect()
                ->action( 'ViolenceLevelController@index');
            }
            else
            {
              return redirect()
                ->action( 'ViolenceLevelController@index');
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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
      {
        $data =  ViolenceLevel::where('id', $id)
          ->restore();
        return redirect()
            ->action( 'ViolenceLevelController@index');
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
     if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
     {
           $data =  ViolenceLevel::withTrashed()
                     ->whereIN('id',$request->checkboxID )
                     ->restore();
           if($data)
           {
             return redirect()
               ->action( 'ViolenceLevelController@index');
           }
           else
           {
             return redirect()
               ->action( 'ViolenceLevelController@index');
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
     if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
     {
         $data = ViolenceLevel::onlyTrashed()
                    ->where('id', $id);
         $data->forceDelete();
         return redirect()
               ->action( 'ViolenceLevelController@index');
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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
      {
          $sql=  ViolenceLevel::whereIN('id',$request->checkboxID )
                    ->forceDelete();
          if($sql)
          {
            return redirect()
              ->action( 'ViolenceLevelController@index');
          }
          else
          {
            return redirect()
              ->action( 'ViolenceLevelController@index');
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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
      {
                              $data              =   ViolenceLevel::withTrashed()->where('id',$id)
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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level) )
      {

        $myObj = ViolenceLevel::withTrashed()
                    ->where( 'id', $request->js_id )
                    ->update([
                      'status'  => $request->status ,
                    ]);

        if($myObj)
        {
        //  $newstatus="";
          $oldstatus =  ViolenceLevel::withTrashed()
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
