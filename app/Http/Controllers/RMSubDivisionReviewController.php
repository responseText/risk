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
use App\Division;
use App\SubDivision;
use App\TypeRisk;
use App\Violence;
use App\Evaluation;
use App\IncidentCase;

class RMSubDivisionReviewController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');


  }
  //----------------------------------------------------------------------------
  public function search(Request $request)
  {

    //$subdivision        = SubDivision::select('id','name')->where([['status','=','enable'],['is_division','=','Y']])->get();
    $subdivision        = SubDivision::select('id','name')->where([['status','=','enable']])->get();
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    //--------------------------------------------------------------------------
    // ----- Loop เก็บ หน่วยงาาน --------------------------------------------------
    $arr_subdivision = array();
    if( count(Auth::user()->user_level)>0 )
    {
      if(in_array('8',$arr_user_level))
      {
        foreach(  Auth::user()->user_level as $k => $v)
        {

          if( $v->level_id =="8" )
          {
            $arr_subdivision[$k]=$v->subdivision_id;
          }
        }
      }
      elseif( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
      {
        foreach($subdivision as $k => $v)
        {
          $arr_subdivision[$k]=$v->id;
        }
      }
    }
    /*
    $titlename1 = SubDivision::select('name')->where([['status','=','enable']])->whereIn('id',$arr_subdivision)->get();
    $ttname=array();
    foreach($titlename1 as $kname =>$vname)
    {
    $ttname[]=$vname->name;
    }
    $titlename=implode(" , ",$ttname);
    */
    if( in_array('8',$arr_user_level) )
    {
      //$division           = Division::select('id','name')->where([['status','=','enable']])->get();
      $evaluation         = Evaluation::select('id','name')->where([['status','=','enable']])->get();
      $data               =   Incident::where([
                                ['headrm_sendto_headdivision_status','=','Y'],
                                ['headrm_delete','=','']
                              ])

                              ->whereNull('headdivision_receive_status')
                              ->whereNull('deleted_at');

                              if( !empty($request->input('filter-subdivision')))
                              {
                                    foreach( $request->input('filter-subdivision') as $k )
                                    {
                                        $arr_filter_subdivision[] = $k;
                                        echo $k;
                                    }


                                  $data->whereIn('sub_division_id',$arr_filter_subdivision)  ;
                                  $titlename1 = SubDivision::select('name')->where([['status','=','enable']])->whereIn('id',$arr_filter_subdivision)->get();
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
                                  $data->whereIn('sub_division_id',$arr_subdivision)  ;
                                  $titlename1 = SubDivision::select('name')->where([['status','=','enable']])->whereIn('id',$arr_subdivision)->get();
                                  $ttname=array();
                                  foreach($titlename1 as $kname =>$vname)
                                  {
                                  $ttname[]=$vname->name;
                                  }
                                  $titlename=implode(" , ",$ttname);

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
                            // $data =  $data->paginate( $count  );
                            $data =  $data->get();

                             return view('rmsubdivisionreview.index')
                               ->with('evaluation',$evaluation)
                               ->with( 'data' , $data )
                               ->with('titlename',$titlename)
                               //->with('division',$division)
                               ->with('subdivision',$subdivision)
                                ->with('arr_subdivision',$arr_subdivision)
                               ->with('request_subdivision',$request->input('filter-subdivision') );
    }
    elseif(in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
    {
      $all_subdivision_id=array();
      foreach($subdivision as $kk => $vv)
      {
        $all_subdivision_id[]=$vv->id;
      }
      $evaluation         = Evaluation::select('id','name')->where([['status','=','enable']])->get();
      $data               =   Incident::where([
                                ['headrm_sendto_headdivision_status','=','Y']
                                ,
                                ['headrm_delete','=','']
                              ])
                              ->whereNull('headdivision_receive_status');

                              //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ))

                              if( !empty($request->input('filter-subdivision')))
                              {
                                    foreach( $request->input('filter-subdivision') as $k )
                                    {
                                        $arr_filter_subdivision[] = $k;
                                        echo $k;
                                    }


                                  $data->whereIn('sub_division_id',$arr_filter_subdivision)  ;
                                  $titlename1 = SubDivision::select('name')->where([['status','=','enable']])->whereIn('id',$arr_filter_subdivision)->get();
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
                                  $data->whereIn('sub_division_id',$arr_subdivision)  ;
                                  $titlename1 = SubDivision::select('name')->where([['status','=','enable']])->whereIn('id',$arr_subdivision)->get();
                                  $ttname=array();
                                  foreach($titlename1 as $kname =>$vname)
                                  {
                                  $ttname[]=$vname->name;
                                  }
                                  $titlename=implode(" , ",$ttname);

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

                             return view('rmsubdivisionreview.index')
                             ->with('evaluation',$evaluation)
                             ->with( 'data' , $data )
                             ->with('titlename',$titlename)
                             //->with('division',$division)
                             ->with('subdivision',$subdivision)
                              ->with('arr_subdivision',$arr_subdivision)
                             ->with('request_subdivision',$request->input('filter-subdivision') );


    }


  }
  //-----------------------------------------------------------------------------
  public function index(Request $request)
  {

  //  $division           = Division::select('id','name')->where([['status','=','enable']])->get();
    //$subdivision        = SubDivision::select('id','name')->where([['status','=','enable'],['is_division','=','Y']])->get();
    $subdivision        = SubDivision::select('id','name')->where([['status','=','enable']])->get();
    $user_login_id = Auth::user()->user_level[0]->user_id; //รหัส User ที่ทำการ login
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }

    //--------------------------------------------------------------------------
    // ----- Loop เก็บ หน่วยงาาน --------------------------------------------------
    $arr_subdivision = array();
    if( count(Auth::user()->user_level)>0 )
    {

      foreach(  Auth::user()->user_level as $k => $v)
      {

        if(in_array('8',$arr_user_level))
        {
          foreach(  Auth::user()->user_level as $k => $v)
          {

            if( $v->level_id =="8" )
            {
            $arr_subdivision[$k]=$v->subdivision_id;
            }

          }
        }
        elseif( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
        {
          foreach($subdivision as $k => $v)
          {
            $arr_subdivision[$k]=$v->id;
          }
        }
      }
    }

    $titlename1 = SubDivision::select('name')->where([['status','=','enable']])->whereIn('id',$arr_subdivision)->get();
    $ttname=array();
    foreach($titlename1 as $kname =>$vname)
    {
    $ttname[]=$vname->name;
    }
    $titlename=implode(" , ",$ttname);








    //if(    Auth::user()->level_id == '1'  ||  ( Auth::user()->level_id == '2' ) ||  ( Auth::user()->level_id == 5 )  )
    if( in_array('8',$arr_user_level) )
    {
      //$division           = Division::select('id','name')->where([['status','=','enable']])->get();
      $evaluation         = Evaluation::select('id','name')->where([['status','=','enable']])->get();
      $data               =   Incident::where([
                                ['headrm_sendto_headdivision_status','=','Y'],
                                ['headrm_delete','=','']
                              ])

                              ->whereNull('headdivision_receive_status')
                              ->whereNull('deleted_at')
                              ->whereIn('sub_division_id', $arr_subdivision);

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
                            // $data =  $data->paginate( $count  );
                            $data =  $data->get();

                             return view('rmsubdivisionreview.index')
                               ->with('evaluation',$evaluation)
                               ->with( 'data' , $data )
                               ->with('titlename',$titlename)
                               //->with('division',$division)
                               ->with('arr_subdivision',$arr_subdivision)
                                ->with('request_subdivision',$request->input('filter-subdivision') )
                               ->with('subdivision',$subdivision);



    }
    else if(in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  )
    {
      $all_subdivision_id=array();
      foreach($subdivision as $kk => $vv)
      {
        $all_subdivision_id[]=$vv->id;
      }
      $evaluation         = Evaluation::select('id','name')->where([['status','=','enable']])->get();
      $data               =   Incident::where([
                                ['headrm_sendto_headdivision_status','=','Y']
                              ])
                              ->whereNull('headdivision_receive_status');

                              //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ))
                              if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
                              {
                                if( !empty($request->input('filter-division')))
                                {
                                      foreach( $request->input('filter-division') as $k )
                                      {
                                          $arr_filter_division[] = $k;
                                      }

                                    $data->whereIn('sub_division_id',$arr_filter_division)  ;
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

                             return view('rmsubdivisionreview.index')
                               ->with('evaluation',$evaluation)
                               ->with( 'data' , $data )
                               ->with('titlename',$titlename)
                               ->with('arr_subdivision',$arr_subdivision)
                               ->with('request_subdivision',$request->input('filter-subdivision') )
                               ->with('subdivision',$subdivision);
    }


  }
  //public function list(Request $request)
  public function list(Request $request)
  {


      //$subdivision        = SubDivision::select('id','name')->where([['status','=','enable'],['is_division','=','Y']])->get();
      $subdivision        = SubDivision::select('id','name')->where([['status','=','enable']])->get();
      $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
      // --------   เก็บ สิทธิ์ผู้ใช้งานเป็น array  --------------------------------------
      if(count(Auth::user()->user_level) > 0 )
      {
        foreach( Auth::user()->user_level as $kk => $vv)
        {
          $arr_user_level[]=$vv->level_id;
        }
      }

      $arr_subdivision = array();
      if( count(Auth::user()->user_level)>0 )
      {

        foreach(  Auth::user()->user_level as $k => $v)
        {

          if(in_array('8',$arr_user_level))
          {
            foreach(  Auth::user()->user_level as $k => $v)
            {

              if( $v->level_id =="8" )
              {
              $arr_subdivision[$k]=$v->subdivision_id;
              }

            }
          }
          elseif( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
          {
            foreach($subdivision as $k => $v)
            {
              $arr_subdivision[$k]=$v->id;
            }
          }
        }
      }
  //dd($arr_subdivision);
      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level)  || in_array('8',$arr_user_level)  )
      {
        $evaluation           = Evaluation::select('id','name')->where([['status','=','enable']])->get();

        //$data               =   Incident::get();
        $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'],
                                 ['headdivision_receive_status','=','Y']
                                ]);

                                if( !empty($request->input('filter-subdivision')))
                                {
                                      foreach( $request->input('filter-subdivision') as $k )
                                      {
                                          $arr_filter_subdivision[] = $k;
                                          echo $k;
                                      }
                                    $data->whereIn('sub_division_id',$arr_filter_subdivision)  ;

                                }
                                else
                                {
                                    $data->whereIn('sub_division_id',$arr_subdivision)  ;
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
                                  if($request->input('evaluation')=='99')
                                  {
                                    //$data->where('incident_status_id','=',null)  ;
                                    $data->whereNull('incident_status_id')  ;
                                  }
                                  else
                                  {
                                      $data->where('incident_status_id','=',$request->input('evaluation'))  ;
                                  }


                                }

                                $data->orderBy('incident_date', 'desc');
                                $count = $data->count();
                                $data =  $data->get();

                    $titlename1 = SubDivision::select('name')->where([['status','=','enable']])->whereIn('id',$arr_subdivision)->get();
                    $ttname=array();
                    foreach($titlename1 as $kname =>$vname)
                    {
                    $ttname[]=$vname->name;
                    }
                    $titlename=implode(" , ",$ttname);

                    //echo $count;
                  //  dd($data);

                  return view('rmsubdivisionreview.list')
                    ->with('evaluation',$evaluation)
                    ->with('data' , $data )
                    ->with('titlename',$titlename)
                    ->with('arr_subdivision',$arr_subdivision)
                    ->with('subdivision',$subdivision)
                    ->with('request_subdivision',$request->input('filter-subdivision') )
                    ;

      }


  }


  //---------------------------------------------------------------------------------------------------------------------
  public function create($id)
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
    // ----- Loop เก็บ หน่วยงาาน -------------------------------------------------
    //$subdivision        = SubDivision::select('id','name')->where([['status','=','enable'],['is_division','=','Y']])->get();
    $subdivision        = SubDivision::select('id','name')->where([['status','=','enable']])->get();
    $arr_subdivision = array();
    if( count(Auth::user()->user_level)>0 )
    {

      foreach(  Auth::user()->user_level as $k => $v)
      {

        if(in_array('8',$arr_user_level))
        {
          foreach(  Auth::user()->user_level as $k => $v)
          {

            if( $v->level_id =="8" )
            {
            $arr_subdivision[$k]=$v->subdivision_id;
            }

          }
        }
        elseif( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
        {
          foreach($subdivision as $k => $v)
          {
            $arr_subdivision[$k]=$v->id;
          }
        }
      }
    }
  //  if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 5 )  )
    if(in_array('1',$arr_user_level) ||   in_array('2',$arr_user_level)  || in_array('8',$arr_user_level) )
    {
      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'] ,
                                  ['headdivision_receive_status','=',null]
                                ])->findorfail($id);
        //if($data->sub_division_id == Auth::user()->subdivision_id)
        if( in_array('8',$arr_user_level))
        {
          if(in_array($data->sub_division_id ,$arr_subdivision ) )
          {

          return view('rmsubdivisionreview.create')
            ->with( 'data' , $data )
            ->with('rs_incidentcase',$rs_incidentcase)
            ->with('rs_division',$rs_division)
            ->with('rs_typerisk',$rs_typerisk);
          }
        }
        else
        {
          return view('rmsubdivisionreview.create')
            ->with( 'data' , $data )
            ->with('rs_division',$rs_division)
            ->with('rs_incidentcase',$rs_incidentcase)
            ->with('rs_typerisk',$rs_typerisk);
        }


    }
    else
    {
      abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }
  }
  //---------------------------------------------------------------------------------------------------------------------
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
    // ----- Loop เก็บ หน่วยงาาน -------------------------------------------------
    //$subdivision        = SubDivision::select('id','name')->where([['status','=','enable'],['is_division','=','Y']])->get();
    $subdivision        = SubDivision::select('id','name')->where([['status','=','enable']])->get();
    $arr_subdivision = array();
    if( count(Auth::user()->user_level)>0 )
    {

      foreach(  Auth::user()->user_level as $k => $v)
      {

        if(in_array('8',$arr_user_level))
        {
          foreach(  Auth::user()->user_level as $k => $v)
          {

            if( $v->level_id =="8" )
            {
            $arr_subdivision[$k]=$v->subdivision_id;
            }

          }
        }
        elseif( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
        {
          foreach($subdivision as $k => $v)
          {
            $arr_subdivision[$k]=$v->id;
          }
        }
      }
    }
  //  if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 5 )  )
    if(in_array('1',$arr_user_level) ||   in_array('2',$arr_user_level)  || in_array('8',$arr_user_level) )
    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 5 )  )
    {
      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'] ,
                                  ['headdivision_receive_status','=','Y']
                                ])->findorfail($id);
        //if($data->sub_division_id == Auth::user()->subdivision_id)
        //if( in_array('5',$arr_user_level))
        //{
          if(in_array($data->sub_division_id ,$arr_subdivision ) )
          {
          return view('rmsubdivisionreview.edit')
            ->with( 'data' , $data )
            ->with('rs_division',$rs_division)
            ->with('rs_incidentcase',$rs_incidentcase)
            ->with('rs_typerisk',$rs_typerisk);
          }
        //}
        /*
        else if(  Auth::user()->level_id == 1  ||   Auth::user()->level_id == 2   )
        {
          return view('headsubdivisionreview.edit')
            ->with( 'data' , $data )
            ->with('rs_division',$rs_division)
            ->with('rs_incidentcase',$rs_incidentcase)
            ->with('rs_typerisk',$rs_typerisk);

        }
        else
        {
          abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
        }
        */

    }
    else
    {
      abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }
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
    //dd($arr_user_level);
    // ----- Loop เก็บ หน่วยงาาน -------------------------------------------------
    //$subdivision        = SubDivision::select('id','name')->where([['status','=','enable'],['is_division','=','Y']])->get();
    $subdivision        = SubDivision::select('id','name')->where([['status','=','enable']])->get();
    $arr_subdivision = array();
    if( count(Auth::user()->user_level)>0 )
    {

      foreach(  Auth::user()->user_level as $k => $v)
      {

        if(in_array('8',$arr_user_level))
        {
          foreach(  Auth::user()->user_level as $k => $v)
          {

            if( $v->level_id =="8" )
            {
            $arr_subdivision[$k]=$v->subdivision_id;
            }

          }
        }
        elseif( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
        {
          foreach($subdivision as $k => $v)
          {
            $arr_subdivision[$k]=$v->id;
          }
        }
      }
    }
    //--------------------------------------------------------------------------

    //if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 5 )  )
    if(in_array('1',$arr_user_level) ||   in_array('2',$arr_user_level)  || in_array('8',$arr_user_level) )
    {
      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $rs_incidentcase        = IncidentCase::where('status','=','enable')->get();
      $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'] ,
                                  ['headdivision_receive_status','=','Y']
                                ])
                                ->findorfail($id);
                                //->find($id);


      if(in_array($data->sub_division_id ,$arr_subdivision ) )
      {
        return view('rmsubdivisionreview.show')
          ->with( 'data' , $data )
          ->with('rs_division',$rs_division)
          ->with('rs_incidentcase',$rs_incidentcase)
          ->with('rs_typerisk',$rs_typerisk);
      }
        /*
        if($data->sub_division_id == Auth::user()->subdivision_id)
        {
          return view('headsubdivisionreview.show')
            ->with( 'data' , $data )
            ->with('rs_division',$rs_division)
            ->with('rs_incidentcase',$rs_incidentcase)
            ->with('rs_typerisk',$rs_typerisk);
        }
        else if(  Auth::user()->level_id == 1  ||   Auth::user()->level_id == 2   )
        {
          return view('headsubdivisionreview.show')
            ->with( 'data' , $data )
            ->with('rs_division',$rs_division)
            ->with('rs_incidentcase',$rs_incidentcase)
            ->with('rs_typerisk',$rs_typerisk);

        }

        else
        {
          abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
        }
        */

    }

  }

  // -------------------------------------------------------------------------
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
                    ->action('RMSubDivisionReviewController@show',$id )
                    ->with('message','ระบบได้ทำการเพิ่มความคิดเห็นของหัวหน้ากลุ่มงานเรียบร้อยแล้ว')
                    ;


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
              ->action('RMSubDivisionReviewController@index' );
  }


}
