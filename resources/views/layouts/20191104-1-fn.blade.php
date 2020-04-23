<?php
function get_count_AllRisk() /// ความเสี่ยงทั้งหมด
{

  $count = DB::table('incident')->count();

  return $count;
}

function get_count_newriskForHeadRM($param)
{
  if( ($param->level_id == 1) || ($param->level_id == 2) || ($param->level_id == 3) )
  {
  $count = DB::table('incident')->where([['headrm_sendto_headdivision_status','=',null],['headrm_delete','=',''],['deleted_at','=',null]])->orWhere('headrm_sendto_headdivision_status','=','N')->count();
  }
  else {
    $count=0;
  }
  //Incident::where([['headrm_sendto_headdivision_status','=',null]])->get();
  //return $users;
  return $count;
}

//------------------------------------------------------------------------------
function get_count_newriskForHeadDivision($param)
{
 //$count = $param->employee->division_id;

 if( ($param->level_id == '1') || ( $param->level_id == '2') )
 {

  $count = DB::table('incident')->where([
                            ['headrm_sendto_headdivision_status','=','Y'],
                            ['headdivision_receive_status','=',null],
                            ['headrm_delete','=',''],
                            ['deleted_at','=',null],

                          ])
                          //->orWhere('headdivision_receive_status','=','')

                          ->count();
}
else if($param->level_id == '4')
{
  $count = DB::table('incident')->where([
                            ['headrm_sendto_headdivision_status','=','Y'],
                            ['headdivision_receive_status','=',null],
                            ['deleted_at','=',null],
                            ['headrm_delete','=',''],
                            ['division_id','=',$param->division_id]
                          ])
                          //->orWhere('headdivision_receive_status','=','')

                          ->count();
}
else
{
  $count =0;
}
  return $count;
}

//------------------------------------------------------------------------------
function get_count_newriskForHeadSubDivision($param)
{
 //$count = $param->employee->division_id;
   if( ($param->level_id == 1) || ( $param->level_id == 2) )
   {
     $count = DB::table('incident')->where([
                               ['headrm_sendto_headdivision_status','=','Y'],
                               ['headdivision_receive_status','=',null],
                               ['headrm_delete','=',''],
                               ['deleted_at','=',null],

                             ])->count();



  }
  else if($param->level_id == 5)
  {
    $count = DB::table('incident')->where([
                              ['headrm_sendto_headdivision_status','=','Y'],
                              ['headdivision_receive_status','=',null],
                              ['headrm_delete','=',''],
                              ['deleted_at','=',null],
                              ['division_id','=',$param->division_id],
                              ['sub_division_id','=',$param->subdivision_id]
                            ])->count();
  }
  else
  {
    $count=0;
  }
  return $count;
}

function get_ForUserHeadDivisionAlert($param)
{
 //$count = $param->employee->division_id;
 if( ($param->level_id == 1) || ( $param->level_id == 2) || ($param->level_id == 4 ) )
 {
  $count = DB::table('incident')->where([
                            ['headrm_sendto_headdivision_status','=','Y'],
                            ['headdivision_receive_status','=',null],
                            ['headrm_delete','=',''],
                            ['deleted_at','=',null],
                            ['division_id','=',$param->division_id]
                          ])->count();
  }
  else
  {
    $count=0;
  }

  return $count;
}

function get_AlereRMstep2($param) ///------ ฟังค์ชันตือน เวลา หัวหน้างาน ส่งกลับมา ยัง คณะกรรมการ
{
 //$count = $param->employee->division_id;
 if( ($param->level_id == 1) || ( $param->level_id == 2) || ($param->level_id == 3) || ($param->level_id == 4 ) )
 {
  $count = DB::table('incident')->where([
                            ['headrm_sendto_headdivision_status','=','Y'],
                            ['headdivision_receive_status','=','Y'],
                            ['headrm_delete','=',''],
                            ['deleted_at','=',null],
                            ['headrm_review_status','=',null]
                          ])

                          ->count();
  }
  else
  {
    $count=0;
  }

  return $count;
}


function getDivision3333()
{
  /*
  $getParm = DB::select('
  select
    ( select count(id) from incident where division_id="1")
  ');
  return  $getParm;
*/
return 33;
}







?>
