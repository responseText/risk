@extends('layouts.page')

@section('content')
<!-- Morris.js charts -->
<script src="{{asset('/Highcharts-7.0.1/code/highcharts.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/series-label.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/exporting.js')}}"></script>
<script src="{{asset('/Highcharts-7.0.1/code/modules/export-data.js')}}"></script>

<div class="content">
<section class="content">


  <div class="box box-info">
    <div class="box-body">


      <form class="" action="{{route('index')}}" method="POST">
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">






            <label class="col-lg-1 col-md-1 col-sm-6 col-xs-12 control-label">ปีงบประมาณ</label>

            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
              <?php




              echo 'ปี '.$year1;
              ?>

              <select id="budget_year" name="budget_year" class="form-control  select2" >

                <option value="">ปีงบประมาณ</option>
                  <?php
                    $year = date('Y');
                    $min = $year - 25;
                    $max = $year;
                    for( $i=$max; $i>=$min; $i-- ) {
                    ?>
                    <option value="{{$i}}" > {{($i+543)}}</option>

                    <?php
                    }
                  ?>
                </select>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
              <button type="submit" name="button" class="btn btn-primary">OK</button>
            </div>
          </div>
        </div>
      </form>


    </div>
  </div>




</section>
</div>


<script type="text/javascript">
  $
</script>
@endsection
