@extends('layouts.page')
@section('title','ความเสี่ยงที่รายงานโดยเจ้าหน้าที่ในหน่วยงาน ' )
@section('content')
@include('layouts/function')

<?php
//print_r($data);
?>
<div class="box box-success">
  <div class="box-header">
    <h3 class="box-title">ความเสี่ยงที่รายงานโดยเจ้าหน้าที่  :
      <?php echo $byuser[0]->employee->prefix->name;?>
      <?php echo $byuser[0]->employee->fname;?>
      &nbsp;&nbsp;
      <?php echo $byuser[0]->employee->lname;?>

    </h3>
  </div>
  <!-- /.box-header -->

  <div class="box-body">

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table table-hover">
            <thead>
              <tr>
                <td>ว/ด/ป ที่เกิด</td>
                <td>ชื่อเหตุการณ์</td>
                <td>รายการอุบัติการณ์</td>
                <td>พบเห็น</td>
              </tr>
            </thead>
            <tbody>
              <??>
              <?php
              if(count($data) > 0)
              {
                foreach( $data as $rs )
                {
              ?>
              <tr>
                <td><?php echo $rs->incident_date?>&nbsp;<?php echo $rs->incident_time?></td>
                <td>
                  <a href="{{route('usersinsubdivisionreport.review',array($rs->id) )}}">
                  <?php echo $rs->incident_title?>
                  </a>
                </td>
                <td>
                  <?php
                if( $rs->incident_list_id=='' )
                {
                  echo '-';
                }
                else
                {
                  if( $rs->incident_list_id== '' )
                  {
                    echo '-';
                  }
                  else
                  {
                    if(empty($rs->incident_list->id))
                    {
                      echo '<strong class="bg-red">*** รายการนี้ถูกลบออกจากระบบ ***</strong>' ;
                    }
                    else
                    {
                      echo $rs->incident_list->name;
                    }
                  }
                }
                ?>
              </td>
                <td><?php echo $rs->employee->prefix->name.$rs->employee->fname.'   '.$rs->employee->lname;?></td>
              </tr>
              <?php
                }
              }
              else
              {
              ?>
              <td colspan="4" class="bg-red  text-center"> {{trans('system.not_found')}} </td>
              <?php
              }
              ?>
            </tbody>
        </table>

      </div>

    </div>
  </div>
  <div class="box-footer">
    <form id="myFormSearch" class="" action="{{route('usersinsubdivisionreport.index')}}" method="post">
    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <?php
    $url_date =  str_replace("-","/",$daterage);
    //echo $url_date;
     $url_date =  str_replace("_"," - ",$url_date);
    // echo '<br>'.$url_date;

    ?>
    <input type="hidden" name="filterdaterage" value="<?=$url_date?>">

    <button type="submit" name="button" class="btn btn-default btn-block"><i class="fa fa-btn fa-reply"></i>{{trans('buttons.back')}}</button>

  </form>

  </div>
</div>
@endsection
