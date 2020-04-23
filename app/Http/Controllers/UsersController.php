<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
//use Illuminate\Support\Facades\Storage;
use Storage;
use DB;
use Validator;
use File;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Employee;
use App\LevelAccess;
use App\UserLevel;
use App\Division;
use App\SubDivision;
class UsersController extends Controller
{
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('3',$arr_user_level)  )
    {
      $data               =    User::withTrashed()->get();
    }
    else
    {
      $data               =    User::get();

    }
    return view('users.index')
      ->with( 'data' , $data );

  }
  //--------------------------------------------------------------------------
  public function getlevel()
  {
              $data   =   DB::table('level_access')->get();
                        return  json_decode($data) ;

  }

  public function getdivision()
  {
              $data   =   DB::table('division')->where('status','=','enable')->get();
                        return  json_decode($data) ;

  }
  public function getsubdivision(Request $request)
  {

              $data   =   DB::table('subdivision')->where([['status','=','enable'] , ['division_id','=',$request->js_division_id]])->get();
                        return  json_decode($data) ;

  }


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
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
      {
          $rs_levelaccess     =    LevelAccess::get();
          $rs_employee        =   Employee::where('status','=','enable')->get();
          $rs_division        =   Division::where('status','=','enable')->get();

        return view('users.create')
        ->with( 'rs_employee' , $rs_employee)
        ->with( 'rs_levelaccess' , $rs_levelaccess)
        ->with( 'rs_division' , $rs_division);

      }
    }
    public function store(Request $request)
    {
      $rules =
      [
          'name'                                  => 'required|min:4|unique:users,name',
          'employee'                              => 'required',
          'password'                              => 'required|min:4|confirmed',
      ];
      $messages =
      [
          'name.required'                           => 'กรุณากรอกชื่อผู้ใช้งาน.',
          'name.unique'                             => 'ชื่อผู้ใช้งานนี้มีอยู่ในระบบแล้ว.',
          'name.min'                                => 'ระบบอนุญาตให้มีตัวอักษรน้อยสุด 4 ตัวอักษร.',
          'employee.required'                       => 'กรุณากรอกชื่อบุคลากร.',
          'password.required'                       => 'กรุณากรอกรหัสผ่าน' ,
          'password.min'                            => 'รหัสผ่านไม่ควรน้อยกว่า 4 ตัวอักษร' ,
          'password.confirmed'                      => 'กรุณากรอกรหัสผ่านให้ตรงกัน',
      ];


        $validator = Validator::make($request->all(), $rules,$messages );

        if( $validator->fails() )
        {
            return redirect()
                      ->action( 'UsersController@create')
                      ->withErrors($validator)
                      ->withInput();
        }
        else
        {

           DB::beginTransaction();
           $myObj = new User;

           $myObj->name                        = $request->input('name');
           $myObj->password                    = Hash::make($request->input('password'));
           $myObj->employee_id                 = $request->input('employee');

           $myObj->status                      = 'enable';
           $myObj->save();
           $id =   $myObj->id;

           if(isset($request->checkid))
           {
               if(count($request->checkid) > 0 )
               {





                 foreach(  $request->checkid as $k =>$v )
                 {
                   //echo $k.' - '.$v.'<br>';
                   $txtid='level_access'.$v;
                   $level_id = $request->$txtid;
                   //echo $level_id.'<br>';
                   if($level_id != '6')
                   {
                     if( ($level_id == '1') || ($level_id == '2') || ($level_id == '3') )
                     {


                       $myObjLevel = new UserLevel;

                       $myObjLevel->user_id                        =  $id;
                       $myObjLevel->level_id                       = $level_id;
                       $myObjLevel->save();




                     //  echo $level_id.' not '."NO User  U is ADmin or HeadRM <br>";
                     }
                     else if( ($level_id == '4')  || ($level_id == '7'))
                     {
                       $txt_division_id='division'.$v;
                       $item_division_id = $request->$txt_division_id;
                       $myObjLevel = new UserLevel;
                       $myObjLevel->user_id                        =  $id;
                       $myObjLevel->level_id                       = $level_id;
                       $myObjLevel->division_id                    = $item_division_id;
                       $myObjLevel->save();


                     //echo $level_id.' not '."NO User  U is HeadDivision or RMDivision <br>";
                     }
                     else if( ($level_id == '5')  || ($level_id == '8'))
                     {
                       $txt_division_id='division'.$v;
                       $txt_subdivision_id='subdivision'.$v;
                       $item_division_id = $request->$txt_division_id;
                       $item_subdivision_id = $request->$txt_subdivision_id;
                       $myObjLevel = new UserLevel;
                       $myObjLevel->user_id                        =  $id;
                       $myObjLevel->level_id                       = $level_id;
                       $myObjLevel->division_id                    = $item_division_id;
                       $myObjLevel->subdivision_id                 = $item_subdivision_id;
                       $myObjLevel->save();
                     }
                 }
               } // end foreach

               if(  $myObj )
               {
                  DB::commit();
                   return redirect()->action( 'UsersController@index' );
               }
               else
               {
                 DB::rollBack();
                   return redirect()->action( 'UsersController@create');
               }





           }
           else //--- ไม่มีการ click เพิ่ม สิทธืการใช้งาน ให้ทำการบันทึกเป็น user ทั่วไปเลย
           {
                 if(  $myObj  )
                 {
                    DB::commit();
                     return redirect()->action( 'UsersController@index' );
                 }
                 else
                 {
                   DB::rollBack();
                     return redirect()->action( 'UsersController@create');
                 }
           }

        }
        else
        {
          if(  $myObj  )
          {
             DB::commit();
              return redirect()->action( 'UsersController@index' );
          }
          else
          {
            DB::rollBack();
              return redirect()->action( 'UsersController@create');
          }

        }
      }
  }
  //----------------------------------------------------------------------------
  public function show($id)
    {
    $data='';
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        //echo' is - ' .$vv;
        $arr_user_level[]=$vv->level_id;
      }
    }

    //var_dump($arr_user_level);

    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
    {
      $data               = User::withTrashed()->findorfail($id);

      $dataLevel          = UserLevel::where('user_id', $data->id)->get();



      return view('users.show')
        ->with( 'data' , $data )
        ->with( 'dataLevel' , $dataLevel )
        ;

    }
    else
    {
      $data               =    User::findorfail($id);
      $dataLevel          = UserLevel::where('user_id', $data->id)->get();
      return view('users.show')
      ->with( 'dataLevel' , $dataLevel )
       ->with( 'data' , $data );

    }

  }
  //--------------------------------------------------------------------------
  public function show1($id)
    {
    $data='';
    $data1 ='';
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
    {
      $data               =    User::withTrashed()->findorfail($id);
      $dataLevel          = UserLevel::where('user_id', $data->id)->get();
      $dataimg = Storage::url('public/profile/'.$data->images_profile);
      if( !empty($data->level_id))
      {
      $user_level        =   $data->level_id;
      //$user_access        =   LevelAccess::select('name')->where('id','=',$user_level)->first();
      $data2 =   LevelAccess::select('name')->where('id','=',$user_level)->first();
      $data1 =  $data2->name;
      }
      else{
          $user_access ='';

      }

      //$user_level        =   $data->level_id;
    //  $user_access        =   LevelAccess::select('name')->where('id','=',$user_level)->first();
      return view('users.show1')
        ->with( 'data' , $data )

        ->with('dataLevel' , $dataLevel)
        ->with('user_access' , $data1)
        ->with( 'data_img', $dataimg)
        ;
    }
    else
    {
      $data               =    User::findorfail($id);
        $dataLevel          = UserLevel::where('user_id', $data->id)->get();

      if( !empty($data->level_id))
      {
      $user_level        =   $data->level_id;
      //$user_access        =   LevelAccess::select('name')->where('id','=',$user_level)->first();
      $data2 =   LevelAccess::select('name')->where('id','=',$user_level)->first();
      $data1 =  $data2->name;
      }
      return view('users.show1')
        ->with( 'data' , $data )
        ->with('dataLevel' , $dataLevel)
        ->with('user_access' , $data1);
    }


}
  //--------------------------------------------------------------------------
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
   if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
   {
      $data               =    User::withTrashed()->where('id',$id)  ->first();
      $dataLevel          =   UserLevel::where('user_id', $data->id)->get();
      $rs_employee        =    Employee::where('status','=','enable')->get();
      $rs_division        =    Division::where('status','=','enable')->get();
      $rs_subdivision     =    SubDivision::where('status','=','enable')->get();
      $rs_levelaccess     =    LevelAccess::get();

    ;

      return view('users.edit')
        ->with( 'data' , $data )
        ->with( 'dataLevel' , $dataLevel )
        ->with( 'rs_employee' , $rs_employee)
        ->with( 'rs_division' , $rs_division)
        ->with( 'rs_subdivision' , $rs_subdivision)
        ->with( 'rs_levelaccess' , $rs_levelaccess)
        ;


    }
    else
    {
    abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }
  }
  //----------------------------------------------------------------------------

  public function changepassword($id)
  {

      $data               =    User::withTrashed()->where('id',$id)  ->first();
      //$user_level        =   $data->level_id;
      //$user_access        =   LevelAccess::select('name')->where('id','=',$user_level)->first();
      $arr_position =array();
      for($i=0;$i< count(Auth::user()->user_level) ;$i++)
      {
        $arr_position[]=Auth::user()->user_level[$i]->get_level_access[0]->name;
      }
      $user_access = array_unique($arr_position);
      //$user_access= implode(" , ",$result);

      return view('users.changepassword')
        ->with( 'data' , $data )
        //->with( 'rs_employee' , $rs_employee)
        ->with( 'user_access' , $user_access)
        ;

  }
  // -------------------------------------------------------------------------
  public function update(Request $request, $id)
  {


    $messages =
    [

        'employee.required'                       => 'กรุณากรอกชื่อบุคลากร.',
        'password.required'                       => 'กรุณากรอกรหัสผ่าน' ,
        'password.min'                            => 'รหัสผ่านไม่ควรน้อยกว่า 4 ตัวอักษร' ,
        'password.confirmed'                      => 'กรุณากรอกรหัสผ่านให้ตรงกัน',
        'password_confirmation.required'          => 'กรุณากรอกยืนยันรหัสผ่าน' ,
        'password_confirmation.min'               => 'รหัสผ่านไม่ควรน้อยกว่า 4 ตัวอักษร' ,

    ];
    $rules =
    [

      'employee'                                => 'required',
      'level_access'                            => 'required',
      'division'                                => 'required',
      'subdivision'                             => 'required',


    ];
    if($request->input('password')!='')
    {
      $rules =
      [

        'employee'                                => 'required',
        'password'                                => 'required|min:4|confirmed|same:password_confirmation',
        'password_confirmation'                   => 'required|min:4',

      ];
    }
    else
    {
      $rules =
      [
        'employee'                                => 'required',
      ];
    }
    //$data =  UserLevel::where('user_id',$id)->delete();  ลบสิทธ์การใช้งานเก่า
    $validator = Validator::make($request->all(), $rules,$messages );

    if( $validator->fails() )
    {
        return redirect()
                  ->action( 'UsersController@edit',array($id))
                  //->route('company.create')
                  ->withErrors($validator)
                  ->withInput();
    }
    else
    {
      $myObj =  User::withTrashed()->where('id', $id)
                  ->update([
                    'employee_id'                   => $request->input('employee') ,
                  ]);
      if( $request->input('password')!='' )
      {
          User::where('id', $id)
                ->update([
                  'password'                        => Hash::make($request->input('password')),
                ]);
      }
      $data =  UserLevel::where('user_id',$id)->delete();  // ลบสิทธ์การใช้งานเก่า
      if(isset($request->checkid))
      {
          if(count($request->checkid) > 0 )
          {
              foreach(  $request->checkid as $k =>$v )
              {
                //echo $k.' - '.$v.'<br>';
                $txtid='level_access'.$v;
                $level_id = $request->$txtid;
                //echo $level_id.'<br>';
                if($level_id != '6')
                {
                  if( ($level_id == '1') || ($level_id == '2') || ($level_id == '3') )
                  {
                    $myObjLevel = new UserLevel;
                    $myObjLevel->user_id                        =  $id;
                    $myObjLevel->level_id                       = $level_id;
                    $myObjLevel->save();
                  }
                  else if( ($level_id == '4')  || ($level_id == '7'))
                  {
                    $txt_division_id='division'.$v;
                    $item_division_id = $request->$txt_division_id;
                    $myObjLevel = new UserLevel;
                    $myObjLevel->user_id                        =  $id;
                    $myObjLevel->level_id                       = $level_id;
                    $myObjLevel->division_id                    = $item_division_id;
                    $myObjLevel->save();
                  }
                  else if( ($level_id == '5')  || ($level_id == '8'))
                  {
                    $txt_division_id='division'.$v;
                    $txt_subdivision_id='subdivision'.$v;
                    $item_division_id = $request->$txt_division_id;
                    $item_subdivision_id = $request->$txt_subdivision_id;
                    $myObjLevel = new UserLevel;
                    $myObjLevel->user_id                        =  $id;
                    $myObjLevel->level_id                       = $level_id;
                    $myObjLevel->division_id                    = $item_division_id;
                    $myObjLevel->subdivision_id                 = $item_subdivision_id;
                    $myObjLevel->save();
                  }
              }
            } // end foreach

            if(  $myObj )
            {
               DB::commit();
                return redirect()->action( 'UsersController@index' );
            }
            else
            {
              DB::rollBack();
                return redirect()->action( 'UsersController@create');
            }
          }
          else
          {
            if(  $myObj  )
            {
               DB::commit();
                return redirect()->action( 'UsersController@index' );
            }
            else
            {
              DB::rollBack();
                return redirect()->action( 'UsersController@create');
            }

          }
      }
      else
      {
        if(  $myObj  )
        {
           DB::commit();
            return redirect()->action( 'UsersController@index' );
        }
        else
        {
          DB::rollBack();
            return redirect()->action( 'UsersController@create');
        }

      }
    }
  }

  // -------------------------------------------------------------------------
  public function updatepassword(Request $request)
  {
    $messages =
    [

        'password.required'                       => 'กรุณากรอกรหัสผ่าน' ,
        'password.min'                            => 'รหัสผ่านไม่ควรน้อยกว่า 4 ตัวอักษร' ,
        'password.confirmed'                      => 'กรุณากรอกรหัสผ่านให้ตรงกัน',
        'password_confirmation.required'                       => 'กรุณากรอกยืนยันรหัสผ่าน' ,
        'password_confirmation.min'                            => 'รหัสผ่านไม่ควรน้อยกว่า 4 ตัวอักษร' ,


    ];
    $rules =
    [
        'password'                              => 'required|min:4|confirmed|same:password_confirmation',
        'password_confirmation'                 => 'required|min:4',
    ];

     //dd($request);

     $validator = Validator::make($request->all(), $rules,$messages );

     if( $validator->fails() )
     {
         //return redirect()
         return redirect()->back()
                   //->action( 'UsersController@show1',array($id))
                   //->route('company.create')
                   ->withErrors($validator)
                   ->withInput();
     }
     else
     {



                $myObj=User::where('id', Auth::user()->id)
                    ->update([
                      'password'                        => Hash::make($request->input('password')),
                    ]);

                    return redirect()
                            ->action('UsersController@show1', Auth::user()->id);



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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
    {
      $data =  User::find($id);
      $data->delete();


      return redirect()
          ->action( 'UsersController@index');

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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
    {
          $sql=  User::whereIN('id',$request->checkboxID )
                    ->delete();
          if($sql)
          {
            return redirect()
              ->action( 'UsersController@index');
          }
          else
          {
            return redirect()
              ->action( 'UsersController@index');
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
    {
      $data =   User::where('id', $id)
        ->restore();
      return redirect()
          ->action( 'UsersController@index');
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
   if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)    )
   {
         $data =   User::withTrashed()
                   ->whereIN('id',$request->checkboxID )
                   ->restore();
         if($data)
         {
           return redirect()
             ->action( 'UsersController@index');
         }
         else
         {
           return redirect()
             ->action( 'UsersController@index');
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
   if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
   {
       $data =  User::onlyTrashed()
                  ->where('id', $id);
       $data->forceDelete();
       $data1 =  UserLevel::where('user_id','=',$id)->delete();


       return redirect()
             ->action( 'UsersController@index');
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
    {
        $sql=   User::whereIN('id',$request->checkboxID )
                  ->forceDelete();
        $sql2 =  UserLevel::where('user_id','=',$id)->delete();

        if($sql || $sql2 )
        {
          return redirect()
            ->action( 'UsersController@index');
        }
        else
        {
          return redirect()
            ->action( 'UsersController@index');
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
    {
                            $data              =    User::withTrashed()->where('id',$id)
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
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
    {

      $myObj =  User::withTrashed()
                  ->where( 'id', $request->js_id )
                  ->update([
                    'status'  => $request->status ,
                  ]);

      if($myObj)
      {
      //  $newstatus="";
        $oldstatus =   User::withTrashed()
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
  //----------------------------------------------------------------------------
  public function uploadimage(Request $request)
  {
    $maxDim = 400;
    $uploaddir = public_path().'/uploads/images/profile/';
    $id=$request->input('js_id');
    $dataImg = User::select('images_profile')->find($id);

    $file = $request->file('file');
    //-- Start ------------------------------
    $file_tmp   = $_FILES['file']['tmp_name'];
    $file_name  = $_FILES['file']['name'];
    $ext = pathinfo($file_name);
    list($width, $height, $type, $attr) = getimagesize( $file_tmp );
    //--- End  -----------------------------
    $ddate =date('YmdHis');
    $image_name  =   'image-profile-'.$id.'-'.$ddate.'.'.$ext['extension']; // .$file->getClientOriginalExtension();
    if(empty($dataImg->images_profile) || $dataImg->images_profile == '')
    {
      $file_path  = $uploaddir.$image_name;
      $myObj=User::where('id', $id)
          ->update([
            'images_profile'                        => $image_name ,
          ]);

          if ( $width > $maxDim || $height > $maxDim ) {

                $ratio = $width/$height;
                if( $ratio > 1) {
                    $new_width = $maxDim;
                    $new_height = $maxDim/$ratio;
                } else {
                    $new_width = $maxDim*$ratio;
                    $new_height = $maxDim;
                }
            	switch($type){
            		case '1' : $src = imagecreatefromgif($file_tmp);break;
            		case '2' : $src = imagecreatefromjpeg($file_tmp);break;
            		default:  $src = imagecreatefrompng($file_tmp);break;
            	}
            	$tmp	= imagecreatetruecolor($new_width,$new_height);
                imagecopyresampled( $tmp, $src, 0,0,0,0, $new_width, $new_height, $width, $height );

              	imagejpeg($tmp,$file_path);
                return json_decode('success', 200);
            }
            else
            {
            	move_uploaded_file($_FILES['file']['tmp_name'],$file_path);
              return json_decode('success', 200);
            }


    }
    else
    {
        $myObj=User::where('id', $id)
            ->update([
              'images_profile'                        => $image_name ,
            ]);
          if($myObj)
          {
            $new_images = $_FILES["file"]["name"];
            $size_info1 = getimagesize($_FILES["file"]["tmp_name"]);
             $file_path  = $uploaddir.$image_name;
              @unlink($uploaddir.'/'.$dataImg->images_profile);
              if ( $width > $maxDim || $height > $maxDim )
              {

                    $ratio = $width/$height;
                    if( $ratio > 1) {
                        $new_width = $maxDim;
                        $new_height = $maxDim/$ratio;
                    } else {
                        $new_width = $maxDim*$ratio;
                        $new_height = $maxDim;
                    }
                	switch($type){
                		case '1' : $src = imagecreatefromgif($file_tmp);break;
                		case '2' : $src = imagecreatefromjpeg($file_tmp);break;
                		default:  $src = imagecreatefrompng($file_tmp);break;
                	}
                	if($type=='1'){

                	}
                	$tmp	= imagecreatetruecolor($new_width,$new_height);
                    imagecopyresampled( $tmp, $src, 0,0,0,0, $new_width, $new_height, $width, $height );
                  	imagejpeg($tmp,$file_path);
                    return json_decode('success', 200);
                }
                else
                {
                	//$filename = "uploadimg/".'profile-img.'.$ext['extension'];
                	move_uploaded_file($_FILES['file']['tmp_name'],$file_path);
                  return json_decode('success', 200);

                }
          }
      }
  }

  public function uploadimageprompt($id)
  {

    return view('users.uploadimageprompt')->with('id',$id);
  }

}
