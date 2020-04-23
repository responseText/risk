function ajaxExport(js_type)
{
  if(js_type == 'xls')
  {
     $('#myFormExport #type_file').val('xls');
  }
 $('#myFormExport input[name="_method"]').val('POST');
 $('#myFormExport').attr("action", 'divisiondetail/export');

 $('#myFormExport').submit();

}
