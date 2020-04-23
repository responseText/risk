<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Prefix;
use App\Positions;
use App\Division;
use App\SubDivision;

class EmployeeController extends Controller
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
    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {
      $data               =   Employee::withTrashed()->get();

    }
    else
    {
      $data               =   Employee::get();

    }
    return view('employee.index')
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

        $rs_prefix          =   Prefix::where('status','=','enable')->get();
        $rs_position        =   Positions::where('status','=','enable')->get();
        $rs_division        =   Division::where('status','=','enable')->get();
        $rs_subdivision     =   SubDivision::where('status','=','enable')->get();
      return view('employee.create')
      ->with( 'rs_prefix' , $rs_prefix)
      ->with( 'rs_position' , $rs_position)
      ->with( 'rs_division' , $rs_division)
      ->with( 'rs_subdivision' , $rs_subdivision);
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
        'prefix.required'                         => 'กรุณาเลือกคำนำหน้า.',
        'fname.required'                          => 'กรุณากรอกชื่อบุคลากน.',
        'lname.required'                          => 'กรุณากรอกนามสกุลบุคลากร.',
        'position.required'                       => 'กรุณาเลือกตำแหน่ง.',
        'division.required'                       => 'กรุณาเลือกกลุ่มงาน.',
        'subdivision.required'                    => 'กรุณาเลือกหน่วยงาน.',

    ];
    $rules =
    [
        'prefix'                                  => 'required',
        'fname'                                   => 'required',
        'lname'                                   => 'required',
        'position'                                => 'required',
        'division'                                => 'required',
        'subdivision'                             => 'required',
    ];

   $validator = Validator::make($request->all(), $rules,$messages );

   if( $validator->fails() )
   {
       return redirect()
                 ->action( 'EmployeeController@create')
                 ->withErrors($validator)
                 ->withInput();
   }
   else
   {
       $myObj = new Employee;

       $myObj->prefix_id                   = $request->input('prefix');
       $myObj->fname                       = $request->input('fname');
       $myObj->lname                       = $request->input('lname');
       $myObj->position_id                 = $request->input('position');
       $myObj->division_id                 = $request->input('division');
       $myObj->subdivision_id              = $request->input('subdivision');
       $myObj->status                      = 'enable';
       $myObj->save();
       $id =   $myObj->id;

       if(  $myObj )
       {
           return redirect()->action( 'EmployeeController@index' );
       }
       else
       {
           return redirect()->action( 'EmployeeController@create');
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
    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {
      $data               =   Employee::withTrashed()->findorfail($id);
      return view('employee.show')
        ->with( 'data' , $data );
    }
    else
    {
      $data               =   Employee::findorfail($id);
      return view('employee.show')
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
    if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
   {
      $data               =   Employee::withTrashed()->where('id',$id)  ->first();
      $rs_prefix          =   Prefix::where('status','=','enable')->get();
      $rs_position        =   Positions::where('status','=','enable')->get();
      $rs_division        =   Division::where('status','=','enable')->get();
      $rs_subdivision     =   SubDivision::where('status','=','enable')->get();

      return view('employee.edit')
        ->with( 'data' , $data )
        ->with( 'rs_prefix' , $rs_prefix)
        ->with( 'rs_position' , $rs_position)
        ->with( 'rs_division' , $rs_division)
        ->with( 'rs_subdivision' , $rs_subdivision)
        ;


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
        'prefix.required'                         => 'กรุณาเลือกคำนำหน้า.',
        'fname.required'                          => 'กรุณากรอกชื่อบุคลากน.',
        'lname.required'                          => 'กรุณากรอกนามสกุลบุคลากร.',
        'position.required'                       => 'กรุณาเลือกตำแหน่ง.',
        'division.required'                       => 'กรุณาเลือกกลุ่มงาน.',
        'subdivision.required'                    => 'กรุณาเลือกหน่วยงาน.',

    ];
    $rules =
    [
        'prefix'                                  => 'required',
        'fname'                                   => 'required',
        'lname'                                   => 'required',
        'position'                                => 'required',
        'division'                                => 'required',
        'subdivision'                             => 'required',
    ];

     //dd($request);

     $validator = Validator::make($request->all(), $rules,$messages );

     if( $validator->fails() )
     {
         return redirect()
                   ->action( 'EmployeeController@edit',array($id))
                   //->route('company.create')
                   ->withErrors($validator)
                   ->withInput();
     }
     else
     {
      $myObj = Employee::withTrashed()->where('id', $id)
                  ->update([
                    'prefix_id'                     => $request->input('prefix') ,
                    'fname'                         => $request->input('fname') ,
                    'lname'                         => $request->input('lname') ,
                    'position_id'                   => $request->input('position') ,
                    'division_id'                   => $request->input('division') ,
                    'subdivision_id'                => $request->input('subdivision') ,
                  ]);
            return redirect()
                    ->action('EmployeeController@show',array($id) );

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
      $data = Employee::find($id);
      $data->delete();
      return redirect()
          ->action( 'EmployeeController@index');

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
          $sql= Employee::whereIN('id',$request->checkboxID )
                    ->delete();
          if($sql)
          {
            return redirect()
              ->action( 'EmployeeController@index');
          }
          else
          {
            return redirect()
              ->action( 'EmployeeController@index');
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
      $data =  Employee::where('id', $id)
        ->restore();
      return redirect()
          ->action( 'EmployeeController@index');
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
         $data =  Employee::withTrashed()
                   ->whereIN('id',$request->checkboxID )
                   ->restore();
         if($data)
         {
           return redirect()
             ->action( 'EmployeeController@index');
         }
         else
         {
           return redirect()
             ->action( 'EmployeeController@index');
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
       $data = Employee::onlyTrashed()
                  ->where('id', $id);
       $data->forceDelete();
       return redirect()
             ->action( 'EmployeeController@index');
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
        $sql=  Employee::whereIN('id',$request->checkboxID )
                  ->forceDelete();
        if($sql)
        {
          return redirect()
            ->action( 'EmployeeController@index');
        }
        else
        {
          return redirect()
            ->action( 'EmployeeController@index');
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
                            $data              =   Employee::withTrashed()->where('id',$id)
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

      $myObj = Employee::withTrashed()
                  ->where( 'id', $request->js_id )
                  ->update([
                    'status'  => $request->status ,
                  ]);

      if($myObj)
      {
      //  $newstatus="";
        $oldstatus =  Employee::withTrashed()
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

  //--------------------------------------------------------------------------
  public function getsubdivision($id)
  {
              $data   =   SubDivision::select('id','name')->where('division_id','=',$id)
                          ->get();
                          return response()->json(  $data );
  }
}
