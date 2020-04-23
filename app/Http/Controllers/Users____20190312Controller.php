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
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {


    if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
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
  public function create()
  {


    if   ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'     )
    {
        $rs_levelaccess     =    LevelAccess::get();
        $rs_employee        =   Employee::where('status','=','enable')->get();
        $rs_division        =   Division::where('status','=','enable')->get();

      return view('users.create')
      ->with( 'rs_employee' , $rs_employee)
      ->with( 'rs_levelaccess' , $rs_levelaccess)
      ->with( 'rs_division' , $rs_division)
    ;
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
        'name.required'                           => 'กรุณากรอกชื่อผู้ใช้งาน.',
        'name.unique'                             => 'ชื่อผู้ใช้งานนี้มีอยู่ในระบบแล้ว.',
        'name.min'                                => 'ระบบอนุญาตให้มีตัวอักษรน้อยสุด 4 ตัวอักษร.',
        'employee.required'                       => 'กรุณากรอกชื่อบุคลากร.',
        'level_access.required'                   => 'กรุณาเลือกระดับผู้ใช้งาน.',
        'password.required'                       => 'กรุณากรอกรหัสผ่าน' ,
        'password.min'                            => 'รหัสผ่านไม่ควรน้อยกว่า 4 ตัวอักษร' ,
        'password.confirmed'                      => 'กรุณากรอกรหัสผ่านให้ตรงกัน',
        'division.required'                       => 'กรุณาเลือกกลุ่มงาน' ,
        'subdivision.required'                    => 'กรุณาเลือกหน่วยงาน' ,

    ];
    $rules =array();
    if($request->input('level_access') =='4')
    {
      $rules =
      [
          'name'                                  => 'required|min:4|unique:users,name',
          'employee'                              => 'required',
          'level_access'                          => 'required',
          'password'                              => 'required|min:4|confirmed',
          'division'                              => 'required',
      ];
    }
    else if ($request->input('level_access') =='5')
    {
      $rules =
      [
          'name'                                  => 'required|min:4|unique:users,name',
          'employee'                              => 'required',
          'level_access'                          => 'required',
          'password'                              => 'required|min:4|confirmed',
          'division'                              => 'required',
          'subdivision'                           => 'required',
      ];
    }
    else
    {
      $rules =
      [
          'name'                                  => 'required|min:4|unique:users,name',
          'employee'                              => 'required',
          'level_access'                          => 'required',
          'password'                              => 'required|min:4|confirmed',
      ];
    }



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
       $myObj->level_id                    = $request->input('level_access');
       if($request->input('level_access') =='4')
       {
         $myObj->division_id                 = $request->input('division');
       }
       else if($request->input('level_access') =='5')
       {
         $myObj->division_id                 = $request->input('division');
         $myObj->subdivision_id              = $request->input('subdivision');
       }
       $myObj->status                      = 'enable';
       $myObj->save();
       $id =   $myObj->id;



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
  //--------------------------------------------------------------------------
  public function show($id)
    {
    $data='';
    if(  (Auth::user()->level_id == 1 ) || (Auth::user()->level_id == 2)   )
    {
      $data               =    User::withTrashed()->findorfail($id);

      return view('users.show')
        ->with( 'data' , $data )
        ;
    }
    else
    {
      $data               =    User::findorfail($id);
      return view('users.show')
        ->with( 'data' , $data );
    }
  }

    //--------------------------------------------------------------------------
    public function show1($id)
      {
      $data='';
      $data1 ='';
      if(  (Auth::user()->level_id == 1 ) || (Auth::user()->level_id == 2)   )
      {
        $data               =    User::withTrashed()->findorfail($id);
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
          ->with('user_access' , $data1)
          ->with( 'data_img', $dataimg)
          ;
      }
      else
      {
        $data               =    User::findorfail($id);

        if( !empty($data->level_id))
        {
        $user_level        =   $data->level_id;
        //$user_access        =   LevelAccess::select('name')->where('id','=',$user_level)->first();
        $data2 =   LevelAccess::select('name')->where('id','=',$user_level)->first();
        $data1 =  $data2->name;
        }
        return view('users.show1')
          ->with( 'data' , $data )
          ->with('user_access' , $data1);
      }


  }
  public function edit($id)
  {
   if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'  )
   {
      $data               =    User::withTrashed()->where('id',$id)  ->first();
      $rs_employee        =    Employee::where('status','=','enable')->get();
      $rs_division        =    Division::where('status','=','enable')->get();
      $rs_levelaccess     =    LevelAccess::get();

    ;

      return view('users.edit')
        ->with( 'data' , $data )
        ->with( 'rs_employee' , $rs_employee)
        ->with( 'rs_division' , $rs_division)
        ->with( 'rs_levelaccess' , $rs_levelaccess)
        ;


    }
    else
    {
    abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }
  }


  public function edit1($id)
  {
   if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'  )
   {
      $data               =    User::withTrashed()->where('id',$id)  ->first();
      $user_level        =   $data->level_id;
      $user_access        =   LevelAccess::select('name')->where('id','=',$user_level)->first();

    ;

      return view('users.edit1')
        ->with( 'data' , $data )
        //->with( 'rs_employee' , $rs_employee)
        ->with( 'user_access' , $user_access->name)
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
      $user_level        =   $data->level_id;
      $user_access        =   LevelAccess::select('name')->where('id','=',$user_level)->first();

      return view('users.changepassword')
        ->with( 'data' , $data )
        //->with( 'rs_employee' , $rs_employee)
        ->with( 'user_access' , $user_access->name)
        ;

  }
  // -------------------------------------------------------------------------
  public function update(Request $request, $id)
  {


    $messages =
    [

        'employee.required'                       => 'กรุณากรอกชื่อบุคลากร.',
        'level_access.required'                   => 'กรุณาเลือกระดับผู้ใช้งาน.',
        'division.required'                       => 'กลุณาเลือกกลุ่มงาน',
        'subdivision.required'                    => 'กรุณาเลือกหน่วยงาน' ,
		    'password.required'                       => 'กรุณากรอกรหัสผ่าน' ,
        'password.min'                            => 'รหัสผ่านไม่ควรน้อยกว่า 4 ตัวอักษร' ,
        'password.confirmed'                      => 'กรุณากรอกรหัสผ่านให้ตรงกัน',
        'password_confirmation.required'          => 'กรุณากรอกยืนยันรหัสผ่าน' ,
        'password_confirmation.min'               => 'รหัสผ่านไม่ควรน้อยกว่า 4 ตัวอักษร' ,

    ];





    if( !empty($request->input('level_access')) )
    {
      if( $request->input('level_access') == '4')
      {
      		if($request->input('password')!='')
      		{
      			$rules =
      			[

      				'employee'                                => 'required',
      				'level_access'                            => 'required',
      				'division'                                => 'required',
      				'password'                                => 'required|min:4|confirmed|same:password_confirmation',
      				'password_confirmation'                   => 'required|min:4',

      			];
      		}
      		else
      		{
      			$rules =
      			[

      				'employee'                                => 'required',
      				'level_access'                            => 'required',
      				'division'                                => 'required',
      			];
      		}
      }
      else if( $request->input('level_access') == '5')
      {
        if($request->input('password')!='')
        {
          $rules =
          [

            'employee'                                => 'required',
            'level_access'                            => 'required',
            'division'                                => 'required',
            'subdivision'                             => 'required',
            'password'                                => 'required|min:4|confirmed|same:password_confirmation',
            'password_confirmation'                   => 'required|min:4',

          ];
        }
        else
        {
          $rules =
          [

            'employee'                                => 'required',
            'level_access'                            => 'required',
            'division'                                => 'required',
            'subdivision'                             => 'required',


          ];
        }

      }
      else
      {
      // -------------------------------------------------------------------------
      		if($request->input('password')!='')
      		{
      			$rules =
      			[

      				'employee'                                => 'required',
      				'level_access'                            => 'required',
      				'password'                                => 'required|min:4|confirmed|same:password_confirmation',
      				'password_confirmation'                   => 'required|min:4',

      			];
      		}
      		else
      		{
      			$rules =
      			[

      				'employee'                                => 'required',
      				'level_access'                            => 'required',
      			];
      		}

      }


    }
    else
    {
      $rules =
      [

          'employee'                                => 'required',
          'level_access'                            => 'required',
          //'password'                                => 'confirmed',
      ];
    }


     //dd($request);

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
       DB::beginTransaction();
       /*
      $myObj =  User::withTrashed()->where('id', $id)
                  ->update([
                    'employee_id'                   => $request->input('employee') ,
                    'level_id'                          => $request->input('level_access') ,
                  ]);
        */
        if( $request->input('level_access')=='4' )
        {
          $myObj =  User::withTrashed()->where('id', $id)
                      ->update([
                        'employee_id'                   => $request->input('employee') ,
                        'level_id'                          => $request->input('level_access') ,
                        'division_id'                          => $request->input('division') ,
                      ]);
        }
        else if($request->input('level_access')=='5')
        {
          $myObj =  User::withTrashed()->where('id', $id)
                      ->update([
                        'employee_id'                   => $request->input('employee') ,
                        'level_id'                      => $request->input('level_access') ,
                        'division_id'                   => $request->input('division') ,
                        'subdivision_id'                => $request->input('subdivision') ,
                      ]);
        }
        else
        {
          $myObj =  User::withTrashed()->where('id', $id)
                      ->update([
                        'employee_id'                   => $request->input('employee') ,
                        'level_id'                      => $request->input('level_access') ,
                        'division_id'                   =>Null,
                        'subdivision_id'                =>Null,
                      ]);
          // code...
        }
        if( $request->input('password')!='' ){
              User::where('id', $id)
                    ->update([
                      'password'                        => Hash::make($request->input('password')),
                    ]);
        }
/*
      $myObj2 =  UserLevel::where('user_id','=', $id)
                  ->update([
                    'level_id'                          => $request->input('level_access') ,
                  ]);
*/
      if($myObj || $myObj2 )
      {
        DB::commit();
        return redirect()
                ->action('UsersController@show',array($id) );
      }
      else
      {
        DB::rollBack();
        $request->session()->flash('msg_error', 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล!');
        return redirect()
                ->action('UsersController@edit',array($id) );

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
    if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'  )
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
    if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'  )
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
    if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'  )
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

   if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'  )
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
   if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'  )
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
    if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'  )
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
    if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'  )
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

    if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2'  )
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

  //--------------------------------------------------------------------------
  public function getsubdivision($id)
  {
              $data   =   SubDivision::select('id','name')->where('division_id','=',$id)
                          ->get();
                          return response()->json(  $data );
  }
  //----------------------------------------------------------------------------
  public function uploadimage(Request $request)
  {

      $dir = public_path().'/uploads/images/profile';

      //dir = '../../uploads/images/profile/';
      $id=$request->input('js_id');
      $dataImg = User::select('images_profile')->find($id);
      $file = $request->file('file');
      $destination              = $dir;
      //$images_filename =  $file->getClientOriginalName();
      //$image_Mine =  $file->getSize();
      $image_extension =  $file->getClientOriginalExtension();
      //$image_name  =   'image-profile-'.$id.'.'.$image_extension;
      $image_name  =   'image-profile-'.$id.'.jpg';


      if(empty($dataImg->images_profile))
      {
        $myObj=User::where('id', $id)
            ->update([
              'images_profile'                        => $image_name ,
            ]);
            $file->move( $destination ,   $image_name );
             return json_decode('success', 200);
      }
      else
      {
        $myObj=User::where('id', $id)
            ->update([
              'images_profile'                        => $image_name ,
            ]);

          if($myObj)
          {
             $file_path  = $dir.'/'.$image_name;
             if(file_exists($file_path))
             {
               unlink($file_path);
               $file->move( $destination ,   $image_name );
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
