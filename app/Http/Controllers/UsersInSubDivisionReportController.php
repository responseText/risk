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
use App\User;
class UsersInSubDivisionReportController extends Controller
{
  public function index(Request $request)
  {

    $subdivision        = SubDivision::select('id','name')->where([['status','=','enable'],['is_division','=','Y']])->get();
    $division          = Division::select('id','name')->where([['status','=','enable']])->get();
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
    $arr_division = array();
    if( count(Auth::user()->user_level)>0 )
    {
      if(in_array('5',$arr_user_level) || in_array('8',$arr_user_level))
      {
        foreach(  Auth::user()->user_level as $k => $v)
        {

          if( $v->level_id =="5" ||  $v->level_id =="8" )
          {
          $arr_division[$k]   = $v->division_id;
          $arr_subdivision[$k]= $v->subdivision_id;
          }

        }
      }
      elseif( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
      {
        foreach($division as $kd => $vd)
        {
          $arr_division[$kd]=$vd->id;
        }
        foreach($subdivision as $k => $v)
        {
          $arr_subdivision[$k]=$v->id;
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
    /*
    var_dump($arr_division);
    echo '<br>';
    var_dump($arr_subdivision);
*/


    //dd($arr_division);

    $url_date='';
    $param_s = substr(Carbon::now(),1,10);
    $param_e = substr(Carbon::now(),1,10);
    $imp = join(",",$arr_division);
    $imp1 = join(",",$arr_subdivision);
    //dd($arr_subdivision);
    //$data = Employee::where([['status','=','enable'],['division_id','=',Auth::user()->employee->division_id]])->get();



    if(in_array('5',$arr_user_level) || in_array('8',$arr_user_level))
    {
      if(isset($request->filterdaterage))
      {
        $originaldate =  $request->filterdaterage;
        if(  $originaldate !='')
        {
          $url_date =  str_replace(" - ","_",$request->filterdaterage);
          $url_date =  str_replace("/","-",$url_date);
        }
        if( $request->filterdaterage != '0' || !empty($request->filterdaterage) )
        {
            $olddaterage =$request->filterdaterage;
            list($param_d1,$param_d2) =  explode(" - " ,$request->filterdaterage);
            $param_dd1 = explode("/" ,$param_d1 );
            $param_dd2 = explode("/" ,$param_d2 );
            $param_s = $param_dd1[2].'-'.$param_dd1[1].'-'.$param_dd1[0];
            $param_e = $param_dd2[2].'-'.$param_dd2[1].'-'.$param_dd2[0];
        $data =DB::select(
                "
                select
            (select pr.name from prefix pr where pr.id=e.prefix_id) as PrefixName,
            u.name ,e.fname ,e.lname,
            u.id as uid,
            (select count(i.id) from incident i where i.by_user_id=u.id and i.incident_date between '".$param_s."' and  '".$param_e."') Count
            from employee e

            left join users u on e.id = u.employee_id

            where e.division_id in (".implode(",",$arr_division).")
            and e.subdivision_id in (".implode(",",$arr_subdivision).")
            and e.status='enable'
            and e.deleted_at is null

                "
            );

        return view('usersinsubdivisionreport.index')
                    ->with('arr_subdivision',$arr_subdivision)
                    ->with('data',$data)
                    ->with('titlename',$titlename)
                    ->with('url_date' , $url_date );
        }
      }
      else
      {
        $data =DB::select(
                "
                select
                  (select pr.name from prefix pr where pr.id=e.prefix_id) as PrefixName,
                u.name ,e.fname ,e.lname,
                (select count(i.id) from incident i where i.by_user_id=u.id  )
                from employee e

                left join users u on e.id = u.employee_id

                  where e.division_id in (".implode(",",$arr_division).")
                   and e.subdivision_id in (".implode(",",$arr_subdivision).")
                  and e.status='enable'
                  and e.deleted_at is null
                "
            );


        return view('usersinsubdivisionreport.index')
                    ->with('arr_subdivision',$arr_subdivision)
                    ->with('data',$data)
                    ->with('titlename',$titlename)
                    ->with('url_date' , $url_date );
        //where e.division_id='".Auth::user()->employee->division_id."'
         //and e.subdivision_id='".Auth::user()->employee->subdivision_id."'
      }

    }
    elseif( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level))
    {

      if(isset($request->filterdaterage))
      {
        $originaldate =  $request->filterdaterage;
        if(  $originaldate !='')
        {
          $url_date =  str_replace(" - ","_",$request->filterdaterage);
          $url_date =  str_replace("/","-",$url_date);
        }
        if( $request->filterdaterage != '0' || !empty($request->filterdaterage) )
        {
            $olddaterage =$request->filterdaterage;
            list($param_d1,$param_d2) =  explode(" - " ,$request->filterdaterage);
            $param_dd1 = explode("/" ,$param_d1 );
            $param_dd2 = explode("/" ,$param_d2 );
            $param_s = $param_dd1[2].'-'.$param_dd1[1].'-'.$param_dd1[0];
            $param_e = $param_dd2[2].'-'.$param_dd2[1].'-'.$param_dd2[0];
        $data =DB::select(
                "
                select
            (select pr.name from prefix pr where pr.id=e.prefix_id) as PrefixName,
            u.name ,e.fname ,e.lname,
            u.id as uid,
            (select count(i.id) from incident i where i.by_user_id=u.id and i.incident_date between '".$param_s."' and  '".$param_e."') Count
            from employee e

            left join users u on e.id = u.employee_id
            and e.status='enable'
            and e.deleted_at is null

                "
            );

        return view('usersinsubdivisionreport.index')
                    ->with('data',$data)
                    ->with('titlename',$titlename)
                    ->with('arr_subdivision',$arr_subdivision)
                    ->with('url_date' , $url_date );;
        }
      }
      else
      {
        $data =DB::select(
                "
                select
                    (select pr.name from prefix pr where pr.id=e.prefix_id) as PrefixName,
                  u.name ,e.fname ,e.lname,
                  (select count(i.id) from incident i where i.by_user_id=u.id  )
                  from employee e

                  left join users u on e.id = u.employee_id

                    and e.status='enable'
                    and e.deleted_at is null
                                "
                );


        return view('usersinsubdivisionreport.index')
                  ->with('data',$data)
                  ->with('titlename',$titlename)
                  ->with('arr_subdivision',$arr_subdivision)
                  ->with('url_date' , $url_date );
      }

    }







  }
  //----------------------------------------------------------------------------
  public function list($id,$daterage)
  {

    list($param_d1,$param_d2) =  explode("_" ,$daterage);
    $param_dd1 = explode("-" ,$param_d1 );
    $param_dd2 = explode("-" ,$param_d2 );
    $param_s = $param_dd1[2].'-'.$param_dd1[1].'-'.$param_dd1[0];
    $param_e = $param_dd2[2].'-'.$param_dd2[1].'-'.$param_dd2[0];
    $user = User::where('id','=',$id)->get();

    $data = Incident::where([
                              ['status','=','enable'] ,['by_user_id','=',$id]
                            ])
                      ->whereBetween('incident_date',[$param_s,$param_e])
                      ->get();

    //  dd($data[1]->by_user_id);
      return view('usersinsubdivisionreport.list')
                  ->with('data' , $data )
                  ->with('byuser',$user)
                  ->with('id', $id)

                  ->with('daterage' , $daterage);


  }
  //----------------------------------------------------------------------------
  public function review($id)
  {
    $data = Incident::find($id);
    return view('usersinsubdivisionreport.review')
                ->with('data' , $data )
                ;
  }
}
