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
class UsersIndepReportController extends Controller
{
  public function index(Request $request)
  {
    $arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
    if(count(Auth::user()->user_level) > 0 )
    {
      foreach( Auth::user()->user_level as $kk => $vv)
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
    // ----- Loop เก็บ หน่วยงาาน -------------------------------------------------
    $arr_division = array();

    $division = Division::select('id','name')->where([['status','=','enable']])->get();
    if( count(Auth::user()->user_level)>0 )
    {
      if(in_array('4',$arr_user_level) || in_array('7',$arr_user_level))
      {
        foreach(  Auth::user()->user_level as $k => $v)
        {
          if( $v->level_id =="4" || $v->level_id =="7" )
          {
            $arr_division[$k]=$v->division_id;
          }
        }
      }
      elseif(in_array('1',$arr_user_level) || in_array('2',$arr_user_level))
      {
        foreach($division as $k => $v)
        {
          $arr_division[$k]=$v->id;
        }
      }
    }
    // -------------------------------------------------------------------------

    $url_date='';
    $param_s = substr(Carbon::now(),1,10);
    $param_e = substr(Carbon::now(),1,10);

    //$data = Employee::where([['status','=','enable'],['division_id','=',Auth::user()->employee->division_id]])->get();
    $imp = join(",",$arr_division);
    //dd($imp);
    /*
    $data1 =DB::select(
            "
            select
(select pr.name from prefix pr where pr.id=e.prefix_id) as PrefixName,
u.name ,e.fname ,e.lname,
(select count(i.id) from incident i where i.by_user_id=u.id  )
from employee e

left join users u on e.id = u.employee_id

where e.division_id IN (".$imp.")

and e.status='enable'
and e.deleted_at is null
            "
        );
      dd($data1);
      */
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

          where e.division_id IN (".$imp.")
          and e.status='enable'
          and e.deleted_at is null

              "
          );
          $titlename1 = Division::select('name')->where([['status','=','enable']])->whereIn('id',$arr_division)->get();
          $ttname=array();
          foreach($titlename1 as $kname =>$vname)
          {
          $ttname[]=$vname->name;
          }
          $titlename=implode(" , ",$ttname);

      return view('usersindepreport.index')
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

  where e.division_id IN (".$imp.")

  and e.status='enable'
  and e.deleted_at is null
              "
          );

          $titlename1 = Division::select('name')->where([['status','=','enable']])->whereIn('id',$arr_division)->get();
          $ttname=array();
          foreach($titlename1 as $kname =>$vname)
          {
          $ttname[]=$vname->name;
          }
          $titlename=implode(" , ",$ttname);
      return view('usersindepreport.index')->with('data',$data)
              ->with('titlename',$titlename)
              ->with('url_date' , $url_date );

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
      return view('usersindepreport.list')
                  ->with('data' , $data )
                  ->with('byuser',$user)
                  ->with('id', $id)
                  ->with('daterage' , $daterage);

  }
  //-----------------------------------------------------------------------------
  public function review($id)
  {
    $data = Incident::find($id);
    return view('usersindepreport.review')
                ->with('data' , $data )
                ;
  }

}
