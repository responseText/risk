<?php

namespace App\Exports;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ViolenceAllDivisionExport implements FromView
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
              v.id ,
              v.code ,
              v.name ,
              (
              select count(i.id)
              from
              incident i
                where headrm_delete=''
                and headrm_sendto_headdivision_status='Y'
                and i.violence_id=v.id
                and (incident_date  between '".$this->sdate ."' and  '".$this->edate."')
              ) as Count

              from
              violence v
          ");
        return view('reports.violencealldivision.export')->with('data',$data);

    }
}
