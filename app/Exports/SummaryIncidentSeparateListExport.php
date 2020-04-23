<?php

namespace App\Exports;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Incident;
use App\Division;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SummaryIncidentSeparateListExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($urlse_date)
    {
      list($sdate,$edate) =  explode("_" ,$urlse_date);


      $this->sdate          = $sdate;
      $this->edate          = $edate;

    }
    public function view() : View
    {
      $data =DB::select(
        "
        select
          distinct(i.incident_list_id) ,
          (select name from incident_list il where il.id=i.incident_list_id  ) as 'Incident_List',
          (
            select count(ii.id) from incident ii where headrm_delete=''
                    and headrm_sendto_headdivision_status='Y'
                    and (incident_date BETWEEN '".$this->sdate."' and  '".$this->edate."')
                    and ii.incident_list_id =i.incident_list_id
          ) as Count
        from incident i
        where headrm_delete=''
        and headrm_sendto_headdivision_status='Y'
        and (incident_date BETWEEN '".$this->sdate."' and  '".$this->edate."' )
        ORDER BY Count desc
        "
          );
        return view('reports.summaryincidentseparatelist.export')->with('data',$data);

    }
}
