@extends('layouts.page')

@section('content')

<div class="content">
  <!-- Content Header (Page header) -->
<style >
  .imgs
  {
    width: 180px; height: auto;
  }
</style>
  <div class="row">
    <div class="col-lg-12 ">
        <div class="box">
          <div class="box-body">

            <div class="row">
              <div class="col-lg-2 col-md-2 col-xs-12 col-sm-12 text-center">
                <img src="images/img_logo.png" class="imgs" >
              </div>
              <div class="col-lg-10">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <h1 class="text-danger">ระบบบริหารความเสี่ยง<?=Session::get('b');?></h1>
                    <h2 class="text-primary">โรงพยาบาลทองแสนขัน</h2>
                    <p class="text-primary">
                      <?php
                      /*
                      foreach( Session::get('sesseion_division.division') as $a)
                      {
                        echo  'Session : '.$a.'<br>';
                      }
                      */

                      ?>
                      ยินดีต้อนรับสู่ ระบบบริหารความเสี่ยงโรงพยาบาล เพื่อลดโอกาสที่จะประสบกับความสูญเสีย หรือสิ่งไม่พึงประสงค์
                      โอกาสความน่าจะเป็นที่จะเกิดอุบัติการณ์. </p>
                  </div>

                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

                  </div>

                </div>

              </div>
            </div>

          </div>
        </div>
    </div>
  </div>






</div>

@endsection
