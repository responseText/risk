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


class WitnessReportExport implements FromView
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
        "select u.id,
            (select p.name from employee ee INNER JOIN prefix p ON ee.prefix_id=p.id where u.id=ee.id ) as prefix_name,
           fname as fname,
            lname as lname,
            (
              select count(i.id) from incident i
              where (i.discover_employee_id = u.id) and headrm_delete='' and (i.incident_date between '".$param_s."' and  '".$param_e."')
            ) as Count
            from employee u
          Order by Count desc"
          );
        return view('reports.witness.export')->with('data',$data);

    }
}
