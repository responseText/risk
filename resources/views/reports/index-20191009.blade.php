@extends('layouts.page')

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="box">
    <div class="box-header">
      <h3 class="box-title">รายการรายงานระบบ</h3>


    </div>
    <!-- /.box-header -->
    <div class="box-body table-hover table-responsive no-padding">
      <table class="table table-hover  table-responsive">
        <!--
        <tr>

          <th class="text-center">รายงาน</th>
          <th width="10%" class="text-center">#</th>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.divisiondetail')}}">ความเสี่ยงที่เกิดขึ้นแยกกลุ่มงาน( ละเอียด )</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
      -->
        <tr>
          <td>
            <a href="{{route('reports.divisionfordetail.index')}}">ความเสี่ยงที่เกิดขึ้นแยกกลุ่มงาน( ละเอียด )</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.subdivisiondetail')}}">ความเสี่ยงที่เกิดขึ้นแยกหน่วยงาน( ละเอียด )</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.divisiononreport')}}">รายงานกลุ่มงานที่ได้รับการรายงานอุบัติการณ์สูงสุด</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.subdivisiononreport')}}">รายงานหน่วยงานที่ได้รับการรายงานอุบัติการณ์สูงสุด</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.usersreport')}}">รายงานเจ้าหน้าที่ที่มีการรายงานอุบัติการณ์สูงสุด</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.divisionsendreport')}}">รายงานหน่วยงานที่รายงานอุบัติการณ์สูงสุด</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.summaryincidentseparatelist')}}">รายงานสรุปจำนวนอุบัติการณ์แยกตามอุบัติการณ์</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.violencealldivision')}}">รายงานสรุปจำนวนอุบัติการณ์ แยกตามความรุนแรง (รวมทุกหน่วย)</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.usersreportall')}}">รายงาน เจ้าหน้าที่ที่มีการรายงานสูงสุด แบบกลุ่มตามหน่วยงาน (รวมทุกหน่วย)</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
		 <tr>
          <td>
            <a href="{{route('reports.typerisk')}}">รายงาน ความเสี่ยงแบ่งตามประเภทความเสี่ยง</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.general')}}">รายงานความเสี่ยงอุบัติการณ์ ทั่วไป &nbsp; <b class="text-red">( *** ไม่ใช่ Near Miss และ Sentinel Event *** )<b/></a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.nearmiss')}}">รายงานความเสี่ยงอุบัติการณ์ Near Miss</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.sentinelevent')}}">รายงานความเสี่ยงอุบัติการณ์ Sentinel Event</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.violencesummary')}}">รายงานจำนวนความเสี่ยงแบ่งตามระดับความรุนแรง (แยกตามกลุ่มมงาน-หน่วยงาน)</a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.rca')}}">รายงาน อุบัติการณ์ที่ต้องมีการทำ RCA </a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.incidentlist')}}">รายงาน สรุปจำนวนอุบัติการณ์ แยกตามอุบัติการณ์  </a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>
        <tr>
          <td>
            <a href="{{route('reports.witness')}}">รายงาน สรุปจำนวนอุบัติการณ์ตามผู้พบเห็นอุบัติการณ์ </a>

          </td>
          <td class="text-center">
            <i class="fa fa-pie-chart"></i>
          </td>
        </tr>



      </table>
    </div><!-- /.box-body -->
    </div><!-- /.box -->

  </div>
</div>




@endsection
