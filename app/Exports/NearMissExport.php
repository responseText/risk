<?php

namespace App\Exports;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Incident;
use App\Division;
use App\SubDivision;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class NearMissExport implements FromView
{
  protected $division_id;
  protected $subdivision_id;

    public function __construct($division_id,$subdivision_id,$urlse_date)
    {
      list($sdate,$edate) =  explode("_" ,$urlse_date);

      $this->division_id = $division_id;
      $this->subdivision_id = explode('-' , $subdivision_id);
      $this->sdate          = $sdate;
      $this->edate          = $edate;

    }
    public function view() : View
    {

      //$data = DB::table('incident')->where('headrm_sendto_headdivision_status','=','Y');
$data = Incident::where([['headrm_sendto_headdivision_status','Y'],['headrm_delete','=',''],['incident_case_id','=','["1"]']]);

      if($this->division_id !='0')
      {
          $data->where('division_id','=',$this->division_id) ;
      }

      if(count($this->subdivision_id) > 1 )
      {
        $data->whereIn('sub_division_id',$this->subdivision_id) ;
      }
      else
      {

      }
      $data->whereBetween('incident_date', [ $this->sdate ,  $this->edate ] ) ;

      $count          = $data->count();

      $data->orderBy( 'incident_date','desc'  );
      $data           =  $data->paginate( $count  );
      return view('reports.nearmiss.export')->with('data',$data);

    }
}
