<?php
function get_count_AllRisk() /// ความเสี่ยงทั้งหมด
{

  $count = DB::table('incident')->count();

  return $count;
}

//------------------------------------------------------------------------------
function get_count_riskSendbackFromHeadDivision($param)
{
  if(count($param->user_level) > 0 )
  {
    foreach($param->user_level as $kk => $vv)
    {
      $arr_user_level[]=$vv->level_id;
    }
  }

  //if( ($param->level_id == 1) || ($param->level_id == 2) || ($param->level_id == 3) )
  if( in_array('1',$arr_user_level) ||  in_array('2',$arr_user_level) || in_array('3',$arr_user_level)  )

  {
  $count = DB::table('incident')->where([['headrm_sendto_headdivision_status','=','sendback'],['headrm_delete','=',''],['deleted_at','=',null]])->count();
  }
  else {
    $count=0;
  }
  //Incident::where([['headrm_sendto_headdivision_status','=',null]])->get();
  //return $users;
  return $count;
}
//------------------------------------------------------------------------------

function get_count_newriskForHeadRM($param)
{
  $arr_user_level =array();
  if(count($param->user_level) > 0 )
  {
    foreach($param->user_level as $kk => $vv)
    {
      if($vv->level_id =='1' || $vv->level_id =='2'|| $vv->level_id =='3' )
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
  }
  //if( ($param->level_id == 1) || ($param->level_id == 2) || ($param->level_id == 3) )
  if( in_array('1',$arr_user_level)|| in_array('2',$arr_user_level) || in_array('3',$arr_user_level) )

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
    $arr_user_level = array();
  if(count($param->user_level) > 0 )
  {
    foreach($param->user_level as $kk => $vv)
    {
      if($vv->level_id =='4' || $vv->level_id =='7')
      {
        $arr_user_level[]=$vv->level_id;
        $arr_division[]=$vv->division_id;
      }
      else{
        if($vv->level_id =='1' || $vv->level_id =='2')
        {
          $arr_user_level[]=$vv->level_id;

        }
      }
    }

  }

  //var_dump( $arr_division);

 //$count = $param->employee->division_id;


      if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )

      {

      $count = DB::table('incident')->where([
                              ['headrm_sendto_headdivision_status','=','Y'],

                              ['headrm_delete','=',''],


                            ])
                            ->whereNull('headdivision_receive_status')
                            ->whereNull('deleted_at')


                            ->count();
      }
      else if( in_array('4',$arr_user_level) || in_array('7',$arr_user_level) )
      {
      $count = DB::table('incident')->where([
                              ['headrm_sendto_headdivision_status','=','Y'],
                              ['headrm_delete','=','']

                            ])
                            ->whereIn('division_id',$arr_division)
                            ->whereNull('headdivision_receive_status')
                            ->whereNull('deleted_at')

                            ->count();
      }
      else
      {
      $count =0;
      }

 return $count;

}


//------------------------------------------------------------------------------
function get_count_newriskForHeadSubDivision2222($param)
{
  $arr_user_level = array();
  if(count($param->user_level) > 0 )
  {
    foreach($param->user_level as $kk => $vv)
    {
      $arr_user_level[]=$vv->level_id;
    }
  }

  $arr_subdivision = array();
  if( count($param->user_level)>0 )
  {
    foreach(  $param->user_level as $k => $v)
    {

      if( $v->level_id =="5" || $v->level_id =="8" )
      {
      $arr_subdivision[$k]=$v->subdivision_id;
      }
      elseif( $v->level_id =="1" || $v->level_id =="2")
      {
        $system_is_division = DB::table('subdivision')->select('id')->where([['is_division','=','Y']]) ->get();;

        //$all_subdivision=array();
        foreach($system_is_division as $kk => $vv)
        {
          $arr_subdivision[]=$vv->id;
        }
      }
    }
  }

 if(in_array('5',$arr_user_level)  || in_array('8',$arr_user_level) )
 {
   $count = DB::table('incident')->where([
                             ['headrm_sendto_headdivision_status','=','Y'],
                             ['headrm_delete','=','']
                           ])
                           //->whereIn('sub_division_id', $arr_subdivision)
                           ->whereIn('sub_division_id', $arr_subdivision)

                           ->whereNull('headdivision_receive_status')
                           ->whereNull('deleted_at')
                           ->count();
 }
 elseif( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
 {
   $count = DB::table('incident')->where([
                             ['headrm_sendto_headdivision_status','=','Y'],
                             ['headrm_delete','=','']
                           ])
                           //->whereIn('sub_division_id', $arr_subdivision)
                           ->whereIn('sub_division_id', $arr_subdivision)

                           ->whereNull('headdivision_receive_status')
                           ->whereNull('deleted_at')
                           ->count();
 }

  echo  $count;

}
//------------------------------------------------------------------------------
function get_count_newriskForHeadSubDivision($param)
{
  $arr_user_level = array();
  if(count($param->user_level) > 0 )
  {
    foreach($param->user_level as $kk => $vv)
    {
      if( $vv->level_id =="1" || $vv->level_id =="2" || $vv->level_id =="5"  || $vv->level_id =="8" )
      {
        $arr_user_level[]=$vv->level_id;
      }
    }
  }

$arr_subdivision = array();
if( count($param->user_level)>0 )
{
  foreach(  $param->user_level as $k => $v)
  {

    if( $v->level_id =="5"  || $v->level_id =="8" )
    {
    $arr_subdivision[$k]=$v->subdivision_id;
    }
    elseif( $v->level_id =="1" || $v->level_id =="2")
    {
      $system_is_division = DB::table('subdivision')->select('id')->where([['is_division','=','Y']]) ->get();;

      //$all_subdivision=array();
      foreach($system_is_division as $kk => $vv)
      {
        $arr_subdivision[]=$vv->id;
      }
    }
  }
}

if(in_array('5',$arr_user_level) || in_array('8',$arr_user_level))
{
 $count = DB::table('incident')->where([
                           ['headrm_sendto_headdivision_status','=','Y'],
                           ['headrm_delete','=','']
                         ])
                         //->whereIn('sub_division_id', $arr_subdivision)
                         ->whereIn('sub_division_id', $arr_subdivision)

                         ->whereNull('headdivision_receive_status')
                         ->whereNull('deleted_at')
                         ->count();
  return  $count;
}
else if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) )
{
 $count = DB::table('incident')->where([
                           ['headrm_sendto_headdivision_status','=','Y'],
                           ['headrm_delete','=','']
                         ])
                         //->whereIn('sub_division_id', $arr_subdivision)
                         ->whereIn('sub_division_id', $arr_subdivision)

                         ->whereNull('headdivision_receive_status')
                         ->whereNull('deleted_at')
                         ->count();
  return  $count;
}



}





function get_ForUserHeadDivisionAlert($param)
{
  if(count($param->user_level) > 0 )
  {
    foreach($param->user_level as $kk => $vv)
    {
      $arr_user_level[]=$vv->level_id;
    }
  }
  // ----- Loop เก็บ หน่วยงาาน --------------------------------------------------
    $arr_division = array();
    if( count($param->user_level)>0 )
    {
      foreach(  $param->user_level as $k => $v)
      {

        if( $v->level_id =="4" || $v->level_id =="7" )
        {
        $arr_division[$k]=$v->division_id;
        }
      }
    }
 //$count = $param->employee->division_id;
 //if( ($param->level_id == 1) || ( $param->level_id == 2) || ($param->level_id == 4 ) )
 if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) || in_array('4',$arr_user_level) || in_array('7',$arr_user_level) )

 {
  $count = DB::table('incident')->where([
                            ['headrm_sendto_headdivision_status','=','Y'],
                            ['headrm_delete','=',''],
                          //  ['division_id','=',$param->division_id]
                          ])
                          ->whereIn('division_id',$arr_division)
                          ->whereNull('headdivision_receive_status')
                          ->whereNull('deleted_at')


                          ->count();
  }
  else
  {
    $count=0;
  }

  return $count;
}

function get_AlereRMstep2($param) ///------ ฟังค์ชันตือน เวลา หัวหน้างาน ส่งกลับมา ยัง คณะกรรมการ
{
  if(count($param->user_level) > 0 )
  {
    foreach($param->user_level as $kk => $vv)
    {
      $arr_user_level[]=$vv->level_id;
    }
  }
 //$count = $param->employee->division_id;
 //if( ($param->level_id == 1) || ( $param->level_id == 2) || ($param->level_id == 3) || ($param->level_id == 4 ) )
 if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) ||  in_array('3',$arr_user_level) || in_array('4',$arr_user_level) )
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

function get_AlereRMNoAnswer($param)///------ ฟังค์ชันตือน กรรมการส่งความเสี่ยงให้หัวหน้างานแล้วหัวหน้างานยังไม่ได้ตอบ
{
  if(count($param->user_level) > 0 )
  {
    foreach($param->user_level as $kk => $vv)
    {
      $arr_user_level[]=$vv->level_id;
    }
  }
 //$count = $param->employee->division_id;

  if( in_array('1',$arr_user_level) || in_array('2',$arr_user_level) ||  in_array('3',$arr_user_level)  )
  //if( ($param->level_id == 1) || ( $param->level_id == 2) || ($param->level_id == 3) )
  {
   $count = DB::table('incident')->where([
                             ['headrm_sendto_headdivision_status','=','Y'],
                             ['headrm_delete','=','']
                           ])
                           ->whereNull('headdivision_receive_status')
                           ->whereNull('deleted_at')
                           ->whereNull('headrm_review_status')

                           ->count();
   }
   else
   {
     $count=0;
   }

   return $count;

}




//------------------------------------------------------------------------------









?>
