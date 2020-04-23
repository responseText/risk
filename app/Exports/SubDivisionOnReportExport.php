<?php

namespace App\Exports;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Incident;
use App\Division;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class SubDivisionOnReportExport implements FromView
{
    
    public function __construct($urlse_date)
    {
      list($sdate,$edate) =  explode("_" ,$urlse_date);


      $this->sdate          = $sdate;
      $this->edate          = $edate;

    }
    public function view() : View
    {
      $data =DB::select(
          "select
              o.id ,
              ( select d.name from division d where d.id = o.division_id) as 'Division_name',
              o.name
              ,
              ( select count(i.id) from incident i where i.headrm_sendto_headdivision_status='Y' and (i.sub_division_id = o.id)
                  and incident_date between '".$this->sdate."' and  '".$this->edate."' and headrm_sendto_headdivision_status='Y'
                  and headrm_delete=''
              ) as 'Count'
          from subdivision o order by Count  desc
          ");
        return view('reports.subdivisiononreport.export')->with('data',$data);

    }
}
