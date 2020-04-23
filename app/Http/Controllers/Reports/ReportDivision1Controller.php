<?php

namespace App\Http\Controllers\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth ;
use PDF;
use Carbon\Carbon;
use App\Incident;
use App\Evaluation;
use App\IncidentGroup;
use App\IncidentList;
use App\Division;
use App\SubDivision;
use App\TypeRisk;
use App\IncidentCase;
use App\Employee;
use App\Prefix;
use App\Effect;
use App\Violence;
use App\ViolenceLevel;
class ReportDivision1Controller extends Controller
{

    public function selectPdf()
    {

          //echo  'Hello';
    }
}
