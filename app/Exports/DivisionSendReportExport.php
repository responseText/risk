<?php

namespace App\Exports;
use DB;
use App\Incident;
use App\Division;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class DivisionSendReportExport implements FromView
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
        "select
          	d.id,
          	d.name,
          	(
          	select
          	count(i.id)

          	from
          	incident i
          	where (i.headrm_delete='') and (headrm_sendto_headdivision_status='Y')
          			and (	(select e.division_id from users u INNER JOIN employee e on u.employee_id=e.id where u.id=i.by_user_id )= d.id )
          			and  (incident_date BETWEEN '".$this->sdate."' and  '".$this->edate."')

          	) as 'Count'
          from
          division d
          ORDER BY Count desc"
          );
        return view('reports.divisionsendreport.export')->with('data',$data);

    }
}
