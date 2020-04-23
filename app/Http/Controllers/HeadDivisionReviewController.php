<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth ;
use Session;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Incident;
use App\Division;
use App\SubDivision;
use App\TypeRisk;
use App\Violence;
use App\Evaluation;
use App\IncidentCase;
class HeadDivisionReviewController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  //----------------------------------------------------------------------------
  public function search(Request $request)
  {

    //$arr_division = array();

    if( count(Auth::user()->user_level)>0 )
    {
      foreach(  Auth::user()->user_level as $k => $v)
      {

        if( $v->level_id =="4")
        {

        $arr_division[$k]=$v->division_id;
        }

      }
    }
    // -------------------------------------------------------------------------
    //  dd($arr_division);

    $user_login_id = Auth::user()->user_level[0]->user_id; //รหัส User ที่ทำการ login
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    $session_division  = Session::get('user.session_division') ; // เก็บหน่วยงาน

// dd(Session::get('user.session_division'));

    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    //--------------------------------------------------------------------------
    $division           = Division::select('id','name')->where([['status','=','enable']])->get();
    $evaluation           = Evaluation::select('id','name')->where([['status','=','enable']])->get();

    $data =Incident::where([
                              ['headrm_sendto_headdivision_status','=','Y'],

                            ])
                            ->whereNull('headdivision_receive_status');
    if( in_array('4',$arr_user_level) )
    {
      if( !empty($request->input('filter-division')))
      {
            foreach( $request->input('filter-division') as $k )
            {
                $arr_filter_division[] = $k;
                echo $k;
            }


          $data->whereIn('division_id',$arr_filter_division)  ;
          $titlename1 = Division::select('name')->where([['status','=','enable']])->whereIn('id',$arr_filter_division)->get();
          $ttname=array();
          foreach($titlename1 as $kname =>$vname)
          {
          $ttname[]=$vname->name;
          }
          $titlename=implode(" , ",$ttname);
          //$data->whereIn('division_id',$arr_division)  ;
      }
      else
      {
          $data->whereIn('division_id',$arr_division)  ;
          $titlename1 = Division::select('name')->where([['status','=','enable']])->whereIn('id',$arr_division)->get();
          $ttname=array();
          foreach($titlename1 as $kname =>$vname)
          {
          $ttname[]=$vname->name;
          }
          $titlename=implode(" , ",$ttname);

      }





    }
    elseif(in_array('1',$arr_user_level)  || in_array('2',$arr_user_level))
    {
      if( !empty($request->input('filter-division')))
      {
            foreach( $request->input('filter-division') as $k )
            {
                $arr_filter_division[] = $k;
                echo $k;
            }


          $data->whereIn('division_id',$arr_filter_division)  ;

          //$data->whereIn('division_id',$arr_division)  ;
          $titlename1 = Division::select('name')->where([['status','=','enable']])->whereIn('id',$arr_filter_division)->get();
          $ttname=array();
          foreach($titlename1 as $kname =>$vname)
          {
          $ttname[]=$vname->name;
          }
          $titlename=implode(" , ",$ttname);
      }
      else
      {
        $titlename = 'กลุ่มงานทั้งหมด';
      }




    }

    if(!empty($request->input('filter-daterage')))
    {
      list($param_d1,$param_d2) =  explode(" - " ,$request->input('filter-daterage'));
      $param_date1          = $param_d1;
      $param_date2          = $param_d2;
      $data->whereBetween("incident_date",[$param_date1 , $param_date2]);
    }





   $data->orderBy('incident_date', 'desc');
   $count = $data->count();
   $data =  $data->paginate( $count  );
   if( in_array('4',$arr_user_level) )
   {
     return view('headdivisionreview.index')
       ->with( 'data' , $data )
       ->with('division',$division)
       ->with('request_division', $request->input('filter-division') )
       ->with('arr_division',$arr_division)
       ->with('titlename',$titlename);

    }
    elseif( in_array('1',$arr_user_level)  || in_array('2',$arr_user_level) )
    {
      $arr_division=array();
      return view('headdivisionreview.index')
        ->with( 'data' , $data )
        ->with('division',$division)
        ->with('request_division',$request->input('filter-division'))
        ->with('arr_division',$arr_division)
        ->with('titlename',$titlename);
          // ->with('arr_division',$arr_division);
    }



  }
  //----------------------------------------------------------------------------
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
    // ----- Loop เก็บ หน่วยงาาน --------------------------------------------------
    $arr_division = array();
    if( count(Auth::user()->user_level)>0 )
    {
      foreach(  Auth::user()->user_level as $k => $v)
      {

        if( $v->level_id =="4" )
        {
        $arr_division[$k]=$v->division_id;
        }
      }
    }
    // -------------------------------------------------------------------------
  //  dd(Session::get('user.session_division'));
//dd($arr_division);
    $user_login_id = Auth::user()->user_level[0]->user_id; //รหัส User ที่ทำการ login

    $session_division  = Session::get('user.session_division') ; // เก็บหน่วยงาน



    //--------------------------------------------------------------------------


    $division           = Division::select('id','name')->where([['status','=','enable']])->get();
    $evaluation           = Evaluation::select('id','name')->where([['status','=','enable']])->get();
    if( in_array('4',$arr_user_level)  )
    {
        $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y']
                                ])
                                ->whereNull('headdivision_receive_status')
                                ->whereIn('division_id',$arr_division);


        $data->orderBy('incident_date', 'desc');
        $count = $data->count();
        $data = $data->get();
        $titlename1 = Division::select('name')->where([['status','=','enable']])->whereIn('id',$arr_division)->get();
        $ttname=array();
        foreach($titlename1 as $kname =>$vname)
        {
        $ttname[]=$vname->name;
        }
        $titlename=implode(" , ",$ttname);


        //$data =  $data->paginate( $count  );
        return view('headdivisionreview.index')
                    ->with( 'data' , $data )
                    ->with('division',$division)
                    ->with('evaluation',$evaluation)
                    ->with('request_division',$arr_division)
                    ->with('arr_division',$arr_division)
                    ->with('titlename',$titlename);
        //dd($arr_user_level);


    }
    elseif( in_array('1',$arr_user_level) || in_array('2',$arr_user_level))
    {
      $data               =   Incident::where([
                                ['headrm_sendto_headdivision_status','=','Y']
                              ])
                              ->whereNull('headdivision_receive_status');
                              //->whereIn('division_id',$arr_division);


      $data->orderBy('incident_date', 'desc');
      $count = $data->count();
      $data = $data->get();
      $titlename='กลุ่มงานทั้งหมด';
      //$data =  $data->paginate( $count  );
      return view('headdivisionreview.index')
                  ->with( 'data' , $data )
                  ->with('division',$division)
                  ->with('evaluation',$evaluation)
                  ->with('request_division',$arr_division)
                  ->with('arr_division',$arr_division)
                  ->with('titlename',$titlename);

    }
    else
    {
      echo 'ไม่มีสิทธิ์';
    }




  //dd($session_division);
/*
    return view('headdivisionreview.index')
      ->with( 'data' , $data )
      ->with('division',$division)
      ->with('evaluation',$evaluation);
      */

                            //echo Auth::user()->user_level->user_id;


  }


  public function list(Request $request)
  {
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    // ----- Loop เก็บ หน่วยงาาน --------------------------------------------------
    $arr_division = array();
    if( count(Auth::user()->user_level)>0 )
    {
      foreach(  Auth::user()->user_level as $k => $v)
      {

        if( $v->level_id =="4" )
        {
        $arr_division[$k]=$v->division_id;
        }
      }
    }



    //--------------------------------------------------------------------------


      // $records=\DB::table('products')->Where('category_id', $category_id);
    $evaluation           = Evaluation::select('id','name')->where([['status','=','enable']])->get();
    $division           = Division::select('id','name')->where([['status','=','enable']])->get();

    $data               =   Incident::where([
                              ['headrm_sendto_headdivision_status','=','Y'],
                              ['headdivision_receive_status','=','Y']
                          ]);
    if( in_array('4',$arr_user_level) )
    {
      if( !empty($request->input('filter-division')))
      {
            foreach( $request->input('filter-division') as $k )
            {
                $arr_filter_division[] = $k;
                echo $k;
            }


          $data->whereIn('division_id',$arr_filter_division)  ;
          $titlename1 = Division::select('name')->where([['status','=','enable']])->whereIn('id',$arr_filter_division)->get();
          $ttname=array();
          foreach($titlename1 as $kname =>$vname)
          {
          $ttname[]=$vname->name;
          }
          $titlename=implode(" , ",$ttname);
          //$data->whereIn('division_id',$arr_division)  ;
      }
      else
      {
          $data->whereIn('division_id',$arr_division)  ;
          $titlename1 = Division::select('name')->where([['status','=','enable']])->whereIn('id',$arr_division)->get();
          $ttname=array();
          foreach($titlename1 as $kname =>$vname)
          {
          $ttname[]=$vname->name;
          }
          $titlename=implode(" , ",$ttname);

      }





    }
    elseif(in_array('1',$arr_user_level)  || in_array('2',$arr_user_level))
    {
      if( !empty($request->input('filter-division')))
      {
            foreach( $request->input('filter-division') as $k )
            {
                $arr_filter_division[] = $k;
                echo $k;
            }


          $data->whereIn('division_id',$arr_filter_division)  ;

          //$data->whereIn('division_id',$arr_division)  ;
          $titlename1 = Division::select('name')->where([['status','=','enable']])->whereIn('id',$arr_filter_division)->get();
          $ttname=array();
          foreach($titlename1 as $kname =>$vname)
          {
          $ttname[]=$vname->name;
          }
          $titlename=implode(" , ",$ttname);
      }
      else
      {
        $titlename = 'กลุ่มงานทั้งหมด';
      }




    }



    if(!empty($request->input('filter-daterage')))
    {
      list($param_d1,$param_d2) =  explode(" - " ,$request->input('filter-daterage'));
      $param_date1          = $param_d1;
      $param_date2          = $param_d2;
      $data->whereBetween("incident_date",[$param_date1 , $param_date2]);
    }
    if( !empty($request->input('evaluation')))
    {
        if( $request->input('evaluation') !="")
        {
            if($request->input('evaluation')=='99')
            {
              $data->whereNull('incident_status_id')  ;
            }
            else
            {
              $data->where('incident_status_id','=',$request->input('evaluation'))  ;
            }
        }
    }


    $data->orderBy('incident_date', 'desc');
    $count = $data->count();

    //dd($count);
    $data =  $data->get();

    if( in_array('4',$arr_user_level) )
    {
      return view('headdivisionreview.index1')
        ->with( 'data' , $data )
        ->with('division',$division)
        ->with('request_division', $request->input('filter-division') )
        ->with('arr_division',$arr_division)
        ->with('evaluation',$evaluation)
        ->with('titlename',$titlename);

     }
     elseif( in_array('1',$arr_user_level)  || in_array('2',$arr_user_level) )
     {
       $arr_division=array();
       return view('headdivisionreview.index1')
         ->with( 'data' , $data )
         ->with('division',$division)
         ->with('evaluation',$evaluation)
         ->with('request_division',$request->input('filter-division'))
         ->with('arr_division',$arr_division)
         ->with('titlename',$titlename);
           // ->with('arr_division',$arr_division);
     }




    /*
    if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 4 )   )
    {
    $division           = Division::select('id','name')->where([['status','=','enable']])->get();
    $data               =   Incident::where([
                              ['headrm_sendto_headdivision_status','=','Y'],
                              ['headdivision_receive_status','=','Y']
                          ]);

                          if(!empty($request->input('filter-daterage')))
                          {
                            list($param_d1,$param_d2) =  explode(" - " ,$request->input('filter-daterage'));
                            $param_date1          = $param_d1;
                            $param_date2          = $param_d2;
                            $data->whereBetween("incident_date",[$param_date1 , $param_date2]);
                          }
                          if( !empty($request->input('evaluation')))
                          {
                            if($request->input('evaluation')=='99')
                            {
                              $data->where('incident_status_id','=',null)  ;
                            }
                            else
                            {
                                $data->where('incident_status_id','=',$request->input('evaluation'))  ;
                            }


                          }

                         $data->orderBy('incident_date', 'desc');
                         $count = $data->count();
                         $data =  $data->paginate( $count  );
                         return view('headdivisionreview.index1')
                          ->with('evaluation',$evaluation)
                           ->with( 'data' , $data )->with('division',$division);


    }
    else
    {
    abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }
    */



  }
  // -------------------------------------------------------------------------------------------------------------------------
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
    // ----- Loop เก็บ กลุ่มงาาน --------------------------------------------------
    $arr_division = array();
    if( count(Auth::user()->user_level)>0 )
    {
      foreach(  Auth::user()->user_level as $k => $v)
      {

        if( $v->level_id =="4" )
        {
        $arr_division[$k]=$v->division_id;
        }
      }
    }
      $subdivision_all        = SubDivision::select('id','name')->where([['status','=','enable'],['is_division','=','Y']])->get();
      $arr_subdivision =array();
      foreach($subdivision_all as $s  )
      {
        $arr_subdivision[] = $s->id;
      }


      $rs_division            = Division::where('status','=','enable')->get();
      $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'] ,
                                //  ['headdivision_receive_status','=',null]
                                ])
                                ->whereNull('headdivision_receive_status')
                                ->findorfail($id);
        $titlename = '';
        if(  $data->division_id !='' ||  !is_null($data->division_id)  )
        {
          $titlename =$data->division->name ;
        }
        else
        {
          $titlename ='';
        }

      return view('headdivisionreview.show')
        ->with( 'data' , $data )
        ->with('arr_division',$arr_division)
        ->with('rs_division',$rs_division)
        ->with('arr_subdivision',$arr_subdivision)
        ->with('rs_incidentcase',$rs_incidentcase)
        ->with('titlename',$titlename)
        ->with('rs_typerisk',$rs_typerisk);
  }

  // -------------------------------------------------------------------------------------------------------------------------
  public function show1($id)
  {
      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();

      $subdivision_all        = SubDivision::select('id','name')->where([['status','=','enable'],['is_division','=','Y']])->get();
      $arr_subdivision =array();
      foreach($subdivision_all as $s  )
      {
        $arr_subdivision[] = $s->id;
      }
      $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'] ,
                                  ['headdivision_receive_status','=','Y']
                                ])->findorfail($id);
      return view('headdivisionreview.show1')
        ->with( 'data' , $data )
        ->with('rs_incidentcase',$rs_incidentcase)
        ->with('arr_subdivision',$arr_subdivision)
        ->with('rs_division',$rs_division)
        ->with('rs_typerisk',$rs_typerisk);
  }
  //---------------------------------------------------------------------------
  public function show2($id)
  {
      $rs_division            = Division::where('status','=','enable')->get();
      $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();

      $subdivision_all        = SubDivision::select('id','name')->where([['status','=','enable'],['is_division','=','Y']])->get();
      $arr_subdivision =array();
      foreach($subdivision_all as $s  )
      {
        $arr_subdivision[] = $s->id;
      }

      $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'] ,
                                  ['headdivision_receive_status','=','Y']
                                ])->findorfail($id);
      $titlename = '';
      if(  $data->division_id !='' ||  !is_null($data->division_id)  )
      {
        $titlename =$data->division->name ;
      }
      else
      {
        $titlename ='';
      }
      return view('headdivisionreview.show2')
        ->with( 'data' , $data )
        ->with('titlename' , $titlename)
        ->with('rs_incidentcase',$rs_incidentcase)
        ->with('arr_subdivision',$arr_subdivision)
        ->with('rs_division',$rs_division)
        ->with('rs_typerisk',$rs_typerisk);
  }
  // -------------------------------------------------------------------------
  // -------------------------------------------------------------------------------------------------------------------------
  public function showtorm($id)
  {
      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'] ,
                                  ['headdivision_receive_status','=',null]
                                ])->findorfail($id);
      return view('headdivisionreview.showtorm')
        ->with( 'data' , $data )
        ->with('rs_division',$rs_division)
        ->with('rs_typerisk',$rs_typerisk);
  }
  //----------------------------------------------------------------------------
  public function sendbackrm(Request $request)
  {
    //echo $request->js_id;
    $myObj = Incident::where('id', $request->js_id)
    ->update([
      'headrm_sendto_headdivision_status'     => 'sendback' ,
      'headrm_sendto_headdivision_date'       => null,
      'headrm_sendto_headdivision_by_id'      => Auth::user()->id
      ]);
      return redirect()
              ->action('HeadDivisionReviewController@index' );
  }
  //---------------------------------------------------------------------------

  public function update(Request $request, $id)
  {

      $myObj = Incident::where('id', $id)
                  ->update([

                    'headdivision_receive_status'     => 'Y' ,
                    'headdivision_receive_date'       => Carbon::now(),
                    'headdivision_edit'               => $request->input('txt_edit'),
                    'headdivision_propersal'          => $request->input('txt_propersal'),
                    'headdivision_receive_by_id'      => Auth::user()->id,

                  ]);
            return redirect()
                    ->action('HeadDivisionReviewController@show2',$id )
                    ->with('message','ระบบได้ทำการเพิ่มความคิดเห็นของหัวหน้ากลุ่มงานเรียบร้อยแล้ว')
                    ;


  }
}
