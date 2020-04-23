<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth ;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Incident;
use App\Division;
use App\SubDivision;
use App\TypeRisk;
use App\Violence;
use App\Evaluation;

class HeadRMReviewController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  /*
  public function index(Request $request)
  {


    if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    {
      $division           = Division::select('id','name')->where([['status','=','enable']])->get();
      $data               =   Incident::where([
                                ['headrm_sendto_headdivision_status','=','Y'],
                                ['headdivision_receive_status','=','Y']
                              ])->get();
    }
    else
    {
    abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }
    return view('headrmreview.index')
      ->with( 'data' , $data )
      ->with('division',$division);
  }
  */
  public function index(Request $request)
  {


    if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    {
      $division           = Division::select('id','name')->where([['status','=','enable']])->get();
      $evaluation           = Evaluation::select('id','name')->where([['status','=','enable']])->get();
      //$data = Incident::orderBy( 'id', 'asc' );

      $data               =   Incident::where([
                                ['headrm_sendto_headdivision_status','=','Y'],
                                ['headdivision_receive_status','=','Y'],
                                ['headrm_review_status','=',null]
                              ]);


    }
    else
    {
    abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }


    if( !empty($request->input('filter-division')))
    {
          foreach( $request->input('filter-division') as $k )
          {
              $arr_filter_division[] = $k;
          }

        $data->whereIn('division_id',$arr_filter_division)  ;
    }

    if( !empty($request->input('evaluation')))
    {

        $data->where('incident_status_id',$request->input('evaluation'))  ;
    }

    if( !empty($request->input('filter-daterage')))
    {
        list($param_d1,$param_d2) =  explode(" - " ,$request->input('filter-daterage'));
        $param_date1          = $param_d1;
        $param_date2          = $param_d2;
        $data->whereBetween("incident_date",[$param_date1 , $param_date2]);



    }
  $count = $data->count();
  $data =  $data->paginate( $count  );
  //return $count;

    return view('headrmreview.index')
      ->with( 'data' , $data )
      ->with('division',$division)
      ->with('evaluation',$evaluation);
  }


  // ----------------------------



  // ---------------------------------------------------------------------------
  public function list()
  {


      // $records=\DB::table('products')->Where('category_id', $category_id);
    if(   ( Auth::user()->level_id == 1 ) ||  ( Auth::user()->level_id == 2 ) ||  ( Auth::user()->level_id == 3 )   )
    {
      //$data               =   Incident::get();
    //}
    $data               =   Incident::where([
                              ['headrm_sendto_headdivision_status','=','Y'],
                              ['headdivision_receive_status','=','Y']
                            ])->get();
    }
    else
    {
    abort(404, 'คุณไม่มีสิทธิเข้าใช้งาน.');
    }
    return view('headrmreview.index1')
      ->with( 'data' , $data );
  }

  public function create()
  {

  }

  // -------------------------------------------------------------------------------------------------------------------------

  public function show($id)
  {
      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'] ,
                                  ['headdivision_receive_status','=',null],
                                ])->findorfail($id);
      return view('headrmreview.show')
        ->with( 'data' , $data )
        ->with('rs_division',$rs_division)
        ->with('rs_typerisk',$rs_typerisk);
  }
  // -------------------------------------------------------------------------------------------------------------------------
  public function show1($id)
  {
      $rs_division            = Division::where('status','=','enable')->get();
      $rs_typerisk            = TypeRisk::where('status','=','enable')->get();
      $rs_invaluation         = Evaluation::where('status','=','enable')->get();
      $data               =   Incident::where([
                                  ['headrm_sendto_headdivision_status','=','Y'] ,
                                  ['headdivision_receive_status','=','Y']
                                ])->findorfail($id);
      return view('headrmreview.show1')
        ->with( 'data' , $data )
        ->with('rs_division',$rs_division)
        ->with('rs_invaluation',$rs_invaluation)
        ->with('rs_typerisk',$rs_typerisk);
  }
  // -------------------------------------------------------------------------
  public function update(Request $request, $id)
  {
    $messages =
    [
        'evaluation.required'                               => 'กรุณาเลือกผลการประเมิน.',


    ];
    $rules =
    [
        'evaluation'                                       => 'required',

    ];
      //dd($request);

      $validator = Validator::make($request->all(), $rules,$messages );

      if( $validator->fails() )
      {
          return redirect()
                    ->action( 'HeadRMReviewController@show1',array($id))
                    //->route('company.create')
                    ->withErrors($validator)
                    ->withInput();
      }
      else
      {

      $myObj = Incident::where('id', $id)
                  ->update([

                    'headrm_review_status'     => 'Y' ,
                    'headrm_review_date'       => Carbon::now(),
                    'headrm_review_edit'        => $request->input('txt_edit'),
                    'headrm_review_propersal'   => $request->input('txt_propersal'),
                    'headrm_review_by_id'      => Auth::user()->id,
                    'incident_status_id'          => $request->input('evaluation'),

                  ]);
            return redirect()
                    ->action('HeadRMReviewController@show1',$id )
                    ->with('message','ระบบได้ทำการเพิ่มความคิดเห็นของหัวหน้ากลุ่มงานเรียบร้อยแล้ว')
                    ;

      }

  }
}
