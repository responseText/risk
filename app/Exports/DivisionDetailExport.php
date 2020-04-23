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
class DivisionDetailExport implements FromView
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
    public function __construct($division_id)
    {

            $this->division_id = $division_id;
    }
    public function view() : View
    {
      if($this->division_id=='')
      {
        $rs =Incident::where([

                                ['headrm_sendto_headdivision_status','=','Y'],
                              ])
                        ->get();
      }
      else
      {
        $rs =Incident::where([
                                ['division_id','=',$this->division_id],
                                ['headrm_sendto_headdivision_status','=','Y'],
                              ])
                        ->get();
      }


        return view('reports.divisiondetail.export', [
            'data' => $rs ,


        ]);
    }

}
