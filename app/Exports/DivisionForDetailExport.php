<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Incident;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

//class DivisionDetailExport implements FromCollection
class DivisionForDetailExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

/*
    public function collection()
    {
        return Incident::where('division_id','=','2')->get();
    }
  */

    protected $division_id;

    public function __construct($division_id,$urlse_date)
    {
      list($sdate,$edate) =  explode("_" ,$urlse_date);

      $this->division_id = $division_id;
      $this->sdate          = $sdate;
      $this->edate          = $edate;

    }

    public function view() : View
    {

        if($this->division_id=='0')
        {
          $rs =Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'],
                                  ['headrm_delete','=','']
                              ])
                          ->whereBetween("incident_date",[$this->sdate , $this->edate])
                          ->get();
        }

        else
        {
          $rs =Incident::where([
                                  ['division_id','=',$this->division_id],
                                  ['headrm_sendto_headdivision_status','=','Y'],
                                ])
                          ->whereBetween("incident_date",[$this->sdate , $this->edate])
                          ->get();
        }
        return view('reports.divisionfordetail.export', [
            'data' => $rs ]);

    }



}
