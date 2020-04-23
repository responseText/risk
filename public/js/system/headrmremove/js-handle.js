function ajaxRmDelete(id)
{
 var myid = id;

  if(confirm( 'คุณต้องการลบความเสี่ยงนี้' ))
  {

    //window.location = 'headrmremove/'+myid+'/promptremove';
  window.location.replace(myid+'/promptremove');
    return true;

  }
  else
  {
    return false;
  }

}
// -----------------------------------------------------------------------------
function ajaxHeadRmConfirmDelete()
{


  if(confirm( 'คุณต้องการลบความเสี่ยงนี้' ))
  {

    $('#FormHeadRmDelete').submit();
    return true;

  }
  else
  {
    return false;
  }

}
//------------------------------------------------------------------------------
function ajaxHeadRmConfirmRestore()
{
  if(confirm( 'คุณต้องการกุ้คืนข้อมูลความเสี่ยงนี้เข้าสู่ระบบ.'  ))
  {

    $('#myForm').attr("action", 'rmrestore');
    $('#myForm').submit();
  }
  else
  {
    return false;
  }
}


// -----------------------------------------------------------------------------
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
    'targets': 5,
    'searchable':true,
    'orderable':true,
    'className': 'text-left'
  }
  ,
  {
    'targets': 6,
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
            /*"url": 'lang/th.json'*/
            "url": 'js/lang/th.json'
        }


 });


}



/* --- Edit dialog  Status   -------------------------------------------*/
function ajaxMainEdit()
{
  if(countCheckbox() == 1)
  {
    if(confirm( txt['edit-confirm']  ))
    {
        var data_id     =  $('input[name="checkboxID[]"]:checked').val();
         var url           = 'incident/'+data_id+'/edit';
         $('#myForm').attr('action' , url);
         $('#myForm input[name="_method"]').val('get');
         $('#myForm').submit();

    }
  }
  else if (countCheckbox() > 1)
  {
    alert(txt['edit-1'] );

  }
  else
  {

  }


}
function ajaxMainSoftDelete()
{
  if(countCheckbox() < 0 )
  {
    alert(txt['softdelete-more']);
  }
  else
  {
    if(confirm( txt['softdelete-confirm']  ))
    {

         var id_name = [];

          $.each( $('input[name="checkboxID[]"]:checked') , function( i,l){
                id_name[i] = $(l).val();
          });

          $('#myForm #js_vars').val( id_name );
          $('#myForm').attr('action','incident/softdeleteall');
          $('#myForm').attr('_method','POST');
          $('#myForm').submit();
          return true;
    }
    return false;
  }


}
