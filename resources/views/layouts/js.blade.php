<!-- jQuery 3 -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('/AdminLTE-2.4.5/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('/AdminLTE-2.4.5/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('/AdminLTE-2.4.5/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('/AdminLTE-2.4.5/bower_components/moment/locale/th.js')}}"></script>

<script src="{{asset('/AdminLTE-2.4.5/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('/AdminLTE-2.4.5/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.th.min.js')}}"></script>

<!-- bootstrap color picker -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- bootstrap time picker -->
<script src="{{asset('/AdminLTE-2.4.5/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset('/AdminLTE-2.4.5/plugins/iCheck/icheck.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- DataTables -->

<script src="{{asset('/AdminLTE-2.4.5/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/AdminLTE-2.4.5/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<script type="text/javascript" src="{{asset('/AdminLTE-2.4.5/bower_components/datatables.net/js/dataTables.colReorder.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/AdminLTE-2.4.5/bower_components/datatables.net/js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/AdminLTE-2.4.5/bower_components/datatables.net/js/jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/AdminLTE-2.4.5/bower_components/datatables.net/js/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/AdminLTE-2.4.5/bower_components/datatables.net/js/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('/AdminLTE-2.4.5/bower_components/datatables.net/js/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/AdminLTE-2.4.5/bower_components/datatables.net/js/buttons.print.min.js')}}"></script>


<!-- AdminLTE App -->
<script src="{{asset('/AdminLTE-2.4.5/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/AdminLTE-2.4.5/dist/js/demo.js')}}"></script>
<script src="{{asset('/js/js-api.js')}}"></script>


<!-- jvectormap  -->
<script src="{{asset('/AdminLTE-2.4.5/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('/AdminLTE-2.4.5/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('/AdminLTE-2.4.5/bower_components/chart.js/Chart.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{asset('/AdminLTE-2.4.5/dist/js/pages/dashboard2.js')}}"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/AdminLTE-2.4.5/dist/js/demo.js')}}"></script>
<!-- page script -->

<script type="text/javascript">
  $(document).ready(function(){
    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
    	 return this.href == url;
    }).parent().addClass('active');

    // for treeview
    $('ul.treeview-menu a').filter(function() {
    	 return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

  });
</script>
