function ajaxConfirmSave()
{
  if(confirm( 'คุณต้องการบันทึก การแก้ไข&&ข้อเสนอแนะ ของความเสี่ยงนี้.'  ))
  {

    //var id=$('#myForm input[name="js_id"]').val();
    //$('#myForm input[name="_method"]').val('PATCH');
    //$('#myForm').attr("action", '../../headrmreview/'+id);
    //alert('WWW');
    $('#myForm').submit();
    return true;
  }
  else
  {
    return false;
  }
}
function loaddatable()
{

var rows_selected = [];
var table =$('#example2').DataTable({

'columnDefs':
[
  {
   'targets': 0,
   'searchable':true,
   'orderable':true,
   //'className': 'dt-body-center'
     'className': 'text-center'
  }
  ,

  {
    'targets': 1,
    'searchable':true,
    'orderable':true,
    'className': 'text-left'
  }
  ,
  {
    'targets': 2,
    'searchable':true,
    'orderable':true,
    'className': 'text-left'
  }
  ,
  {
    'targets': 3,
    'searchable':true,
    'orderable':true,
    'className': 'text-left'
  }

  ,
  {
    'targets': 4,
    'searchable':true,
    'orderable':true,
    'className': 'text-left'
  }
  ,
  {
    'targets': 4,
    'searchable':false,
    'orderable':true,
    'className': 'text-left'
  }
  ,
  {
    'targets': 5,
    'searchable':false,
    'orderable':false,
    'className': 'text-left'
  }







],

'rowCallback': function(row, data, dataIndex){
     // Get row ID
     var rowId = data[0];

     // If row ID is in the list of selected row IDs
     if($.inArray(rowId, rows_selected) !== -1){
        $(row).find('input[type="checkbox"]').prop('checked', true);
        $(row).addClass('selected');
     }
  },
  "order": [[ 0, "desc" ]],

  'lengthMenu': [[10, 25, 50,100,150,200,300,-1], [10, 25, 50,100,150,200,300, "All" ]],
  'responsive': true ,
  //paging: false,
  //searching: false,
  /*
  "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
    }
    */
    "language": {
            //"url": 'lang/th.json'
            //"url": '../../js/lang/th.json'
            "url": 'js/lang/th.json'

        }


 });


}
