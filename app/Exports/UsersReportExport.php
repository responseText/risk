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


class UsersReportExport implements FromView
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
            u.name,
            (select p.name from employee ee INNER JOIN prefix p ON ee.prefix_id=p.id where u.employee_id=ee.id ) as prefix_name,
            (select ee.fname from employee ee where u.employee_id=ee.id ) as fname,
            (select ee.lname from employee ee where u.employee_id=ee.id ) as lname,

            (
              select count(i.id) from incident i
              where (i.by_user_id = u.id) and headrm_delete='' and (i.incident_date between '".$this->sdate."' and  '".$this->edate."')
            ) as Count
            from users u
          Order by Count desc"
          );
        return view('reports.usersreport.export')->with('data',$data);

    }
}
