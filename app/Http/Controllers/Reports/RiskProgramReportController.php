<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use PDF;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
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
use App\RiskProgram;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RiskProgramReportExport;
class RiskProgramReportController extends Controller
{
  public function index(Request $request)
  {
      $url_date='';
      $param_s = substr(Carbon::now(),1,10);
      $param_e = substr(Carbon::now(),1,10);
      $riskprogram_id ='';
      $rs_data='';
      $rs_data_riskprogram= array();
      $rs_riskprogram    = RiskProgram::select('id','name')
                                  ->where('status','=','enable')
                                  ->get();

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
          }
          else
          {
              $param_s = substr(Carbon::now(),1,10);
              $param_e = substr(Carbon::now(),1,10);
          }

          if(isset($request->riskprogram))
          {
            if( $request->filterdaterage != '' || !empty($request->filterdaterage) )
            {
                $riskprogram_id = $request->riskprogram;
            }
            else
            {
                $riskprogram_id = '';
            }
          }

          if( $riskprogram_id !='')
          {
            //if($riskprogram_id  )
            //{
              /*
              $rs_data_riskprogram  = DB::table('incident_group')->select('id', 'name','risk_program_id')
                                     ->where([
                                       ['status', '=', 'enable']
                                       ,
                                       ['risk_program_id', '=', $riskprogram_id]
                                       ])->get();

            */
            $rs_data_riskprogram =DB::select("
                                    select
                                      id,name,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and (incident_date between '".$param_s."' and  '".$param_e."')) as AA_total,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='1' and (incident_date between '".$param_s."' and  '".$param_e."')) as AA ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='2' and (incident_date between '".$param_s."' and  '".$param_e."')) as AB ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='13' and (incident_date between '".$param_s."' and  '".$param_e."')) as Aก ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='3' and (incident_date between '".$param_s."' and  '".$param_e."')) as AC ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='4' and (incident_date between '".$param_s."' and  '".$param_e."')) as AD ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='10' and (incident_date between '".$param_s."' and  '".$param_e."')) as Aน ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='5' and (incident_date between '".$param_s."' and  '".$param_e."')) as AE ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='6' and (incident_date between '".$param_s."' and  '".$param_e."')) as AF ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='11' and (incident_date between '".$param_s."' and  '".$param_e."')) as Aป ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='7' and (incident_date between '".$param_s."' and  '".$param_e."')) as AG ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='8' and (incident_date between '".$param_s."' and  '".$param_e."')) as AH ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='9' and (incident_date between '".$param_s."' and  '".$param_e."')) as AI ,
                                      (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='12' and (incident_date between '".$param_s."' and  '".$param_e."')) as Aม


                                     from incident_group ig where ig.status='enable' and ig.risk_program_id='".$riskprogram_id."'

                                  ");


              $rs_data1              =DB::select(
                            "
                            select
                              (select count(*) from incident where violence_id='1') as 'ก'

                            from incident

                              ");

            //}
          }


          return view('reports.riskprogram.index')
          ->with('riskprogram'    , $rs_riskprogram )
          ->with('riskprogram_id' , $riskprogram_id )
          ->with('rs_data_riskprogram' , $rs_data_riskprogram )
          //->with('rs_data1' , $rs_data1 )

          ->with('url_date'       , $url_date );

      }
      else
      {
          return view('reports.riskprogram.index')
          ->with('riskprogram'    , $rs_riskprogram )
          ->with('riskprogram_id' , $riskprogram_id )
          ->with('rs_data_riskprogram' , $rs_data_riskprogram )
          ->with('url_date'       , $url_date );
      }





  }


  public function listmain(Request $request)
  {
    $UrlSEDate='';
    $groupID="";
    if(isset($request->inputUrlSEDate))
    {
      $UrlSEDate = $request->inputUrlSEDate;
    }
    else
    {
        $UrlSEDate="";
    }
    if(isset($request->inputGroupID))
    {
      $groupID = $request->inputGroupID;
    }
    else
    {
        $groupID="";
    }
    list($param_s,$param_e) = explode("_" ,$request->inputUrlSEDate);
    $data_title =DB::select("
                            select ig.name as IncidentGroupName ,rp.name as RiskProgramName   from incident_group  ig
                              left JOIN risk_program rp on ig.risk_program_id=rp.id
                              where ig.id='".$groupID."'
                              ");
/*
    $data  =DB::select("
                            select
                            *
                             from incident i where i.status='enable'
                             and (i.incident_date between '".$param_s."' and  '".$param_e."')
                             and i.headrm_delete!='Y'
                             and i.incident_group_id='".$groupID."'
                      ");

*/

    $data  =Incident::where([
                      ['status','=','enable'] ,
                      ['headrm_delete','<>','Y'] ,
                      ['incident_group_id','=',$groupID]

                      ])
                      ->whereBetween('incident_date', [$param_s, $param_e])
                      ->get();



    return view('reports.riskprogram.list-main')
    ->with('UrlSEDate'    , $UrlSEDate )
    ->with('groupID'      , $groupID )
    ->with('data'         , $data )
    ->with('data_title'   , $data_title )
    ;

  }


  public function listsub(Request $request)
  {
    $UrlSEDate='';
    $groupID="";
    $violenceID="";
    if(isset($request->inputUrlSEDate))
    {
      $UrlSEDate = $request->inputUrlSEDate;
    }
    else
    {
        $UrlSEDate="";
    }
    if(isset($request->inputGroupID))
    {
      $groupID = $request->inputGroupID;
    }
    else
    {
        $groupID="";
    }
    if(isset($request->inputViolenceID))
    {
      $violenceID = $request->inputViolenceID;
    }
    else
    {
      $violenceID="";
    }
    list($param_s,$param_e) = explode("_" ,$request->inputUrlSEDate);
    $data_title =DB::select("
                            select ig.name as IncidentGroupName ,rp.name as RiskProgramName   from incident_group  ig
                              left JOIN risk_program rp on ig.risk_program_id=rp.id
                              where ig.id='".$groupID."'
                              ");

    $data_violence  = Violence::where([
                        ['status','=','enable'] ,
                        ['id','=',$violenceID]
                      ])
                      ->first();

    $data  =Incident::where([
                        ['status','=','enable'] ,
                        ['headrm_delete','<>','Y'] ,
                        ['incident_group_id','=',$groupID] ,
                        ['violence_id','=',$violenceID]
                      ])
                      ->whereBetween('incident_date', [$param_s, $param_e])
                      ->get();



    return view('reports.riskprogram.list-sub')
    ->with('UrlSEDate'        , $UrlSEDate )
    ->with('groupID'          , $groupID )
    ->with('violenceID'       , $violenceID )
    ->with('data'             , $data )
    ->with('data_violence'    , $data_violence )
    ->with('data_title'       , $data_title )
    ;

  }

  public function detail($id)
  {

    $data               =   Incident::findorfail($id);


    return view('reports.riskprogram.detail')->with( 'data' , $data );

  }
  public function exportExcel($riskprogram , $originaldate)
  {
    //return $riskprogram;
/*
    $data =DB::select("
                            select
                              id,name,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as AA_total,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='1' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as AA ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='2' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as AB ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='13' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as Aก ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='3' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as AC ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='4' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as AD ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='10' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as Aน ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y' and violence_id='5' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as AE ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='6' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as AF ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='11' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as Aป ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='7' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as AG ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='8' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as AH ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='9' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as AI ,
                              (select count(*) from incident  where incident_group_id=ig.id and headrm_delete !='Y'  and violence_id='12' and (incident_date between '".$this->sdate."' and  '".$this->edate."')) as Aม


                             from incident_group ig where ig.status='enable' and ig.risk_program_id='".$this->riskprogram_id."'

                          ");
*/
            //return $data;

    return Excel::download(new RiskProgramReportExport( $riskprogram , $originaldate), 'report.xlsx' );

  }
}
