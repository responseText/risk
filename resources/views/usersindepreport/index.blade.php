@extends('layouts.page')
@section('title','ความเสี่ยงที่รายงานโดยเจ้าหน้าที่ในกลุ่มงาน ' )
@section('content')
@include('layouts/function')
<?php
//------------------------------------------------------------------------------
$arr_user_level = array();  // สิทธิ์การใช้งานของผู้ใช้งานระบบ
if(count(Auth::user()->user_level) > 0 )
{
  foreach( Auth::user()->user_level as $kk => $vv)
  {
    $arr_user_level[]=$vv->level_id;
  }
}
//------------------------------------------------------------------------------


$old_daterage='';
$data_date = '';

if( !empty( $_POST['filterdaterage']))
{
  $data_date=$_POST['filterdaterage'];
}
else
{
  $data_date ='';
}
//echo Auth::user()->employee->division_id;
?>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
    <div class="alert alert-info alert-dismissible">

        <h4><i class="icon fa fa-info"></i> การแจ้งเตือน !</h4>
        กรุณาเลือกช่วงเวลา วันเดือนปี ที่ต้องการแสดง.
    </div>
  </div>
</div>
<div class="box box-success">
  <div class="box-header">
    <h3 class="box-title">ความเสี่ยงที่รายงานโดยเจ้าหน้าที่ในกลุ่มงาน  :  <?=$titlename?>   </h3>

  </div>
  <!-- /.box-header -->

  <div class="box-body">

    <form id="myFormSearch" class="" action="{{route('usersindepreport.index')}}" method="post">
    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right "  name="filterdaterage" id="filterdaterage" value=""
          placeholder="กรุณาเลือกช่วงวันที่ เพื่อทำการค้นหา">

        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 ">
        <button type="submit" name="button" class="btn btn-primary btn-block">ค้นหา</button>
      </div>


    </div>
    </form>
    <hr>




    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-hover">
          <thead>
            <tr>
              <td width="70%" class="text-center">เจ้าหน้าที่</td>
              <td width="20%" class="text-center">ชื่อเข้าใช้งาน</td>
              <?php
              if($data_date != '')
              {
              ?>
              <td width="10%" class="text-center">จำนวน(ครั้ง)</td>
              <?php
              }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
            if(count($data) > 0  )
            {
              foreach( $data as $rs)
              {
            ?>

            <tr>
              <td>
              <?php
              if($data_date != '')
              {
              ?>
              <a href="{{route('usersindepreport.list',array($rs->uid,$url_date))}}">
              <?php
              echo $rs->PrefixName.$rs->fname.'  '.$rs->lname;
              //echo count($data);
              ?>
              <?php
              }
              else
              {
              ?>
              <?php echo $rs->PrefixName.$rs->fname.'  '.$rs->lname;?>
              <?php
              }
              ?>

              </a>
              </td>
              <td class="text-center">

              <?php
              if( $rs->name =='')
              {
                echo '<p class="text-red">ยังไม่มีชื่อเข้าใช้งาน</p>';
              }
              else
              {
              echo $rs->name;
              }
              ?>
              </td>
              <?php
              if($data_date == '')
              {
              ?>
              <td class="text-center">

              </td>
              <?php
              }
              else
              {
              ?>
              <td class="text-center">
                <?=$rs->Count?>
              </td>
              <?php
              }
              ?>
            </tr>
            <?php
              }
            }
            else
            {
            ?>
            <tr>
              <td colspan='2' class="text-center bg-danger">
                <?=trans('system.not_found')?>
              </td>
            </tr>
            <?php
            }
            ?>
          </tbody>

        </table>
      </div>
    </div>



  </div>
</div>
<script type="text/javascript">
  $(function(){
    $('#filterdaterage').daterangepicker({
       locale:{
           cancelLabel: 'ลบ' ,
           applyLabel: 'ตกตง',
           locale: 'th',

       }
    }).val("<?=$data_date?>");
  });
</script>
@endsection
