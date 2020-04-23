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
use App\Evaluation;
use App\IncidentGroup;
use App\IncidentList;
use App\Division;
use App\SubDivision;
use App\TypeRisk;
use App\IncidentCase;
use App\Employee;
use App\Prefix;
use App\Effect;
use App\Violence;
use App\ViolenceLevel;


class IncidentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  // ----------------------------------------------------------------------------------------------------------------------
  public function search(Request $request)
  {
/*

*/

      $data = Incident::orderBy( 'id', 'asc' );

      if( !empty($request->input('filter-division')))
      {
            foreach( $request->input('filter-division') as $k )
            {
                $arr_filter_division[] = $k;
            }

          $data->whereIn('division_id',$arr_filter_division)  ;
      }

      if( !empty($request->input('filter-daterage')))
      {
          list($param_d1,$param_d2) =  explode(" - " ,$request->input('filter-daterage'));
          $param_date1          = $param_d1;
          $param_date2          = $param_d2;
          $data->whereBetween("incident_date",[$param_date1 , $param_date2]);



      }
    $count = $data->count();
    $data =  $data->paginate( $count  );
    return $data;


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


    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    {
      $data               =   Incident::withTrashed()->get();
    }
    else
    {
      $data               =   Incident::get();
    }
    return view('incident.index')
      ->with( 'data' , $data );
  }
  //----------------------------------------------------------------------------
  public function list()
  {

    if( Auth()->user()->employee->division_id != '6')
    {
      $section = Auth()->user()->employee->division_id;
      $data               =   Incident::where('division_id','=',$section)->get();
    }
    else
    {
        $section=Auth()->user()->employee->division_id;
        $section1=Auth()->user()->employee->subdivision_id;
        $data               =   Incident::where([['division_id','=',$section],['sub_division_id','=',$section1]])->get();
    }

    return view('incident.list')
      ->with( 'data' , $data );

      //echo $section;


  }




  //--------------------------------------------------------------------------
  public function create()
  {


      $rs_incidentgroup       = IncidentGroup::where('status','=','enable')->get();
      $rs_division            = Division::where('status','=','enable')->get();
      $rs_subdivision         = SubDivision::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      $rs_employee            = Employee::where('status','=','enable')->get();
      $rs_effect              = Effect::where('status','=','enable')->get();
      return view('incident.create')
        ->with('rs_incidentgroup',$rs_incidentgroup)
        ->with('rs_division',$rs_division)
        ->with('rs_subdivision',$rs_subdivision)
        ->with('rs_typerisk',$rs_typerisk)
        ->with('rs_incidentcase',$rs_incidentcase)
        ->with('rs_employee',$rs_employee)
        ->with('rs_effect',$rs_effect);






  }
  // -------------------------------------------------------------------------
  public function store(Request $request)
  {

   $messages =
   [
       'incident_date.required'                 => 'กรุณากรอกข้อมูลวันที่เกิดเหตุ.',
       'incident_time.required'                 => 'กรุณากรอกข้อมูลเวลาเกิดเหตุ.',
       'division.required'                   => 'กรุณาเลือกกลุ่มงานที่รับผิดชอบ.',
       'subdivision.required'                => 'กรุณาเลือกหน่วยงานที่รับผิดชอบ.',
       'incident_group.required'                => 'กรุณาเลือกหมวดหมู่อุบัติการณ์.',
       'incident_list.required'                 => 'กรุณาเลือกรายการอุบัติการณ์.',
       'typerisk.required'                      => 'กรุณาเลือกประเภทความเสี่ยง.',
       'violence.required'                      => 'กรุณาเลือกระดับความรุนแรง.',
       'employee.required'                      => 'กรุณาเลือกผู้พบเห็น.',
       'incident_title.required'                => 'กรุณากรอกชื่อเหตุการณ์.',
       'incident_event.required'                => 'กรุณากรอกเหตุการณ์.',
       'incident_place.required'                => 'กรุณากรอกสถานที่เกิดเหตุการณ์.',
       'effect.required'                        => 'กรุณาเลือกเหตุการณ์เกิดขึ้นกับ.',
   ];
   $rules =
   [
     'incident_date'                     =>'required' ,
     'incident_time'                     =>'required' ,
     'division'                          =>'required' ,
     'subdivision'                       =>'required' ,
     'incident_group'                    =>'required' ,
     'incident_list'                     =>'required' ,
     'typerisk'                          =>'required' ,
     'violence'                          =>'required' ,
     'employee'                          =>'required' ,
     'incident_title'                    =>'required' ,
     'incident_place'                    =>'required' ,
     'incident_event'                    =>'required' ,
     'effect'                            =>'required' ,
   ];

   $validator = Validator::make($request->all(), $rules,$messages );

   if( $validator->fails() )
   {
       return redirect()
                 ->action( 'IncidentController@create')
                 ->withErrors($validator)
                 ->withInput();
   }
   else
   {

       $p_date = explode("/", $request->input('incident_date'));
       $pp_date = $p_date[2].'-'.$p_date[1].'-'.$p_date[0];


       $p_time = explode(":", $request->input('incident_time'));
       $pp_time = $p_time[0].':'.$p_time[1].':00';

       $checkMyParam ;
        if(isset($request->incidentcase) )
        {
          $checkMyParam =count($request->input('incidentcase'));
        }
        else
        {
          $checkMyParam=0;
        }

        $myParam;
        if($checkMyParam >  0 )
        {
          $myParam=implode(',',$request->input('incidentcase'));
        }
        else
        {
          $myParam = null;
        }

       $myObj = new Incident;
       $myObj->incident_date                                = $pp_date;
       $myObj->incident_time                                = $pp_time;
       $myObj->division_id                                  = $request->input('division');
       $myObj->sub_division_id                              = $request->input('subdivision');
       $myObj->effect_id                                    = $request->input('effect');
       $myObj->incident_group_id                            = $request->input('incident_group');
       $myObj->incident_list_id                             = $request->input('incident_list');
       $myObj->type_risk_id                                 = $request->input('typerisk');
       $myObj->violence_id                                  = $request->input('violence');
       $myObj->incident_case_id                             = $myParam;
       $myObj->incident_title                               = $request->input('incident_title');
       $myObj->incident_place                               = $request->input('incident_place');
       $myObj->incident_event                               = $request->input('incident_event');
       $myObj->incident_edit                                = $request->input('incident_edit');
       $myObj->incident_propersal                           = $request->input('incident_propersal');
       $myObj->discover_employee_id                         = $request->input('employee');
       $myObj->effect_id                                    = $request->input('effect');
       $myObj->by_user_id                                   = Auth::user()->id;
       $myObj->status                                       = 'enable';
       $myObj->save();
       $id =   $myObj->id;

       if(  $myObj )
       {
           return redirect()->action( 'IncidentController@index' );
       }
       else
       {
           return redirect()->action( 'IncidentController@create');
       }

   }

   //echo json_encode($request->input('incidentcase'));
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


    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )

    {
      $data               =   Incident::withTrashed()->findorfail($id);
      $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      return view('incident.show')
        ->with('rs_incidentcase',$rs_incidentcase)
        ->with( 'data' , $data );
    }
    else
    {
      $data               =   Incident::findorfail($id);
        $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      return view('incident.show')
      ->with('rs_incidentcase',$rs_incidentcase)
        ->with( 'data' , $data );
    }


  }
  //--------------------------------------------------------------------------
  public function listshow($id)
  {

      $data               =   Incident::findorfail($id);
        $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      return view('incident.listshow')
      ->with('rs_incidentcase',$rs_incidentcase)
        ->with( 'data' , $data );



  }
  //------------------------------------------------------------------------------
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


    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    //if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
      $data1               =   Incident::withTrashed()->where('id',$id)  ->first();

  // if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || Auth::user()->level_id == '3' || ( (Auth::user()->id == $data1->by_user_id) && ($data1->headrm_sendto_headdivision_status!='Y') ))
  if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) || ( (Auth::user()->id == $data1->by_user_id) && ($data1->headrm_sendto_headdivision_status!='Y') ))
   {

     $rs_incidentgroup       = IncidentGroup::where('status','=','enable')->get();
     $rs_division            = Division::where('status','=','enable')->get();
     $rs_subdivision         = SubDivision::where('status','=','enable')->get();
     $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
     $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
     $rs_employee            = Employee::where('status','=','enable')->get();
     $rs_effect              = Effect::where('status','=','enable')->get();

      $data               =   Incident::withTrashed()->where('id',$id)  ->first();
      return view('incident.edit')
        ->with( 'data' , $data )
        ->with('rs_incidentgroup',$rs_incidentgroup)
        ->with('rs_division',$rs_division)
        ->with('rs_subdivision',$rs_subdivision)
        ->with('rs_typerisk',$rs_typerisk)
        ->with('rs_incidentcase',$rs_incidentcase)
        ->with('rs_employee',$rs_employee)
        ->with('rs_effect',$rs_effect);

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
        'incident_date.required'                 => 'กรุณากรอกข้อมูลวันที่เกิดเหตุ.',
        'incident_time.required'                 => 'กรุณากรอกข้อมูลเวลาเกิดเหตุ.',
        'division.required'                   => 'กรุณาเลือกกลุ่มงานที่รับผิดชอบ.',
        'subdivision.required'                => 'กรุณาเลือกหน่วยงานที่รับผิดชอบ.',
        'incident_group.required'                => 'กรุณาเลือกหมวดหมู่อุบัติการณ์.',
        'incident_list.required'                 => 'กรุณาเลือกรายการอุบัติการณ์.',
        'typerisk.required'                      => 'กรุณาเลือกประเภทความเสี่ยง.',
        'violence.required'                      => 'กรุณาเลือกระดับความรุนแรง.',
        'employee.required'                      => 'กรุณาเลือกผู้พบเห็น.',
        'incident_title.required'                => 'กรุณากรอกชื่อเหตุการณ์.',
        'incident_event.required'                => 'กรุณากรอกเหตุการณ์.',
        'incident_place.required'                => 'กรุณากรอกสถานที่เกิดเหตุการณ์.',
        'effect.required'                        => 'กรุณาเลือกเหตุการณ์เกิดขึ้นกับ.',
    ];
    $rules =
    [
      'incident_date'                     =>'required' ,
      'incident_time'                     =>'required' ,
      'division'                          =>'required' ,
      'subdivision'                       =>'required' ,
      'incident_group'                    =>'required' ,
      'incident_list'                     =>'required' ,
      'typerisk'                          =>'required' ,
      'violence'                          =>'required' ,
      'employee'                          =>'required' ,
      'incident_title'                    =>'required' ,
      'incident_place'                    =>'required' ,
      'incident_event'                    =>'required' ,
      'effect'                            =>'required' ,
    ];
     //dd($request);

     $validator = Validator::make($request->all(), $rules,$messages );

     if( $validator->fails() )
     {
         return redirect()
                   ->action( 'IncidentController@edit',array($id))
                   //->route('company.create')
                   ->withErrors($validator)
                   ->withInput();
     }
     else
     {

       $p_date = explode("/", $request->input('incident_date'));
       $pp_date = $p_date[2].'-'.$p_date[1].'-'.$p_date[0];
       $p_time = explode(":", $request->input('incident_time'));
       $pp_time = $p_time[0].':'.$p_time[1].':00';
       $checkMyParam ;
        if(isset($request->incidentcase) )
        {
          $checkMyParam =count($request->input('incidentcase'));
        }
        else
        {
          $checkMyParam=0;
        }

        $myParam;
        if($checkMyParam >  0 )
        {
          $myParam=implode(',',$request->input('incidentcase'));
        }
        else
        {
          $myParam = null;
        }


      $myObj = Incident::withTrashed()->where('id', $id)
                  ->update([
                    'incident_date'                         => $pp_date ,
                    'incident_time'                         => $pp_time,
                    'division_id'                           => $request->input('division') ,
                    'sub_division_id'                       => $request->input('subdivision') ,

                    'incident_group_id'                     => $request->input('incident_group') ,
                    'incident_list_id'                      => $request->input('incident_list') ,
                    'type_risk_id'                          => $request->input('typerisk') ,

                    'violence_id'                           => $request->input('violence') ,
                    'incident_case_id'                      => $myParam ,
                    'incident_title'                        => $request->input('incident_title') ,
                    'incident_event'                        => $request->input('incident_event') ,
                    'incident_place'                        => $request->input('incident_place') ,
                    'incident_edit'                         => $request->input('incident_edit') ,
                    'incident_propersal'                    => $request->input('incident_propersal') ,
                    'discover_employee_id'                  => $request->input('employee') ,
                    'effect_id'                             => $request->input('effect') ,
                  ]);



            return redirect()
                    ->action('IncidentController@show',array($id) );

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


    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    //if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || Auth::user()->level_id == '3')
    {
      $data = Incident::find($id);
      $data->delete();
      return redirect()
          ->action( 'IncidentController@index');

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


    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    //if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || Auth::user()->level_id == '3')
    {
          $sql= Incident::whereIN('id',$request->checkboxID )
                    ->delete();
          if($sql)
          {
            return redirect()
              ->action( 'IncidentController@index');
          }
          else
          {
            return redirect()
              ->action( 'IncidentController@index');
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


    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    //if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || Auth::user()->level_id == '3')
    {
      $data =  Incident::where('id', $id)
        ->restore();
      return redirect()
          ->action( 'IncidentController@index');
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


   //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
   if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )

   //if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || Auth::user()->level_id == '3')
   {
         $data =  Incident::withTrashed()
                   ->whereIN('id',$request->checkboxID )
                   ->restore();
         if($data)
         {
           return redirect()
             ->action( 'IncidentController@index');
         }
         else
         {
           return redirect()
             ->action( 'IncidentController@index');
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


   //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
   if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
   //if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || Auth::user()->level_id == '3')
   {
       $data = Incident::onlyTrashed()
                  ->where('id', $id);
       $data->forceDelete();
       return redirect()
             ->action( 'IncidentController@index');
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


    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    //if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || Auth::user()->level_id == '3')
    {
        $sql=  Incident::whereIN('id',$request->checkboxID )
                  ->forceDelete();
        if($sql)
        {
          return redirect()
            ->action( 'IncidentController@index');
        }
        else
        {
          return redirect()
            ->action( 'IncidentController@index');
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


    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    //if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || Auth::user()->level_id == '3')
    {
                            $data              =   Incident::withTrashed()->where('id',$id)
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


    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )
    //if ( Auth::user()->level_id == '1' || Auth::user()->level_id == '2' || Auth::user()->level_id == '3')
    {

      $myObj = Incident::withTrashed()
                  ->where( 'id', $request->js_id )
                  ->update([
                    'status'  => $request->status ,
                  ]);

      if($myObj)
      {
      //  $newstatus="";
        $oldstatus =  Incident::withTrashed()
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
  //--------------------------------------------------------------------------
  public function getincidentlist($id)
  {
              $data   =   IncidentList::select('id','name')->where('incident_group_id','=',$id)
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
}
