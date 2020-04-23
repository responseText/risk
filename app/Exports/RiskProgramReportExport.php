<?php

namespace App\Exports;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Incident;
use App\Division;
use App\TypeRisk;
use App\IncidentGroup;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class RiskProgramReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $riskprogram_id;
    protected $urlse_date;
    public function __construct( $riskprogram_id , $urlse_date )
    {
      list($sdate,$edate) =  explode("_" ,$urlse_date);
      $this->riskprogram_id = $riskprogram_id;

      $this->sdate          = $sdate;
      $this->edate          = $edate;

    }
    public function view() : View
    {

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



        return view('reports.riskprogram.export')->with('data',$data);

    }
}
