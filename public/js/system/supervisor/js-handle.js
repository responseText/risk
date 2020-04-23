/* --- Edit dialog  Status   -------------------------------------------*/
function ajaxEdit(id)
{
  unCheckboxAll();
  unCheckboxListAll();
  $('#myForm #checkboxID'+id).prop('checked',true).iCheck('update');
    clickShowHide();
  //$('#myForm #checkboxID'+id).prop('checked',true).iCheck('update');
  //$('#checkboxID'+id).prop('checked',true).iCheck('update');
  if(confirm( txt['edit-confirm']  ))
  {
    $('#myForm #js_id').val(id);
    $('#myForm #js_action').val('edit');
    $('#myForm input[name="_method"]').val('get');
    $('#myForm').attr("action", 'supervisor/'+id+'/edit');
    $('#myForm').submit();

  }
  else
  {
      clickShowHide();
    $('#checkboxID'+id).prop('checked',false).iCheck('update');
  }

}
/* --- show dialog    -------------------------------------------*/
function ajaxShow(id)
{
  unCheckboxAll();
  unCheckboxListAll();

  $('#myForm #checkboxID'+id).prop('checked',true).iCheck('update');
    clickShowHide();
  //$('#myForm #checkboxID'+id).prop('checked',true).iCheck('update');
  //$('#checkboxID'+id).prop('checked',true).iCheck('update');
  if(confirm( txt['show-confirm']  ))
  {

    $('#myForm #js_id').val(id);
    $('#myForm #js_action').val('show');
    $('#myForm input[name="_method"]').val('get');
    $('#myForm').attr("action", 'supervisor/'+id);
    $('#myForm').submit();

  }
  else
  {
    $('#checkboxID'+id).prop('checked',false).iCheck('update');
    clickShowHide();
  }

}

/* --- show dialog    -------------------------------------------*/
function ajaxSoftDelete(id)
{
  unCheckboxAll();
  unCheckboxListAll();
  $('#myForm #checkboxID'+id).prop('checked',true).iCheck('update');
    clickShowHide();
  //$('#myForm #checkboxID'+id).prop('checked',true).iCheck('update');
  //$('#checkboxID'+id).prop('checked',true).iCheck('update');
  if(confirm( txt['softdelete-confirm']  ))
  {
    $('#myForm #js_id').val(id);
    $('#myForm #js_action').val('softdelete');
    $('#myForm input[name="_method"]').val('delete');
    $('#myForm').attr("action", 'supervisor/'+id);
    $('#myForm').submit();

  }
  else
  {
    $('#checkboxID'+id).prop('checked',false).iCheck('update');
      clickShowHide();
  }

}

/* --- Restore dialog    -------------------------------------------*/
function ajaxRestore(id)
{

  unCheckboxAll();
  unCheckboxListAll();
  $('#myForm #checkboxID'+id).prop('checked',true).iCheck('update');
    clickShowHide();
  //$('#myForm #checkboxID'+id).prop('checked',true).iCheck('update');
  //$('#checkboxID'+id).prop('checked',true).iCheck('update');
  if(confirm( txt['restore-confirm']  ))
  {
    $('#myForm #js_id').val(id);
    $('#myForm #js_action').val('restore');
    $('#myForm input[name="_method"]').val('delete');
    $('#myForm').attr("action", 'supervisor/restore/'+id);
    $('#myForm').submit();
  }
  else
  {
    $('#checkboxID'+id).prop('checked',false).iCheck('update');
      clickShowHide();
  }
}
//------ Restore All -----------------------------------------------------------
function ajaxMainRestoreAll()
{
       if( countCheckbox() <1 )
       {
           alert( txt['restore-more'] );
       }
       else
       {
         if( confirm( txt['restore-confirm'] ))
         {
           var id_name = [];

           $.each( $('input[name="checkboxID[]"]:checked') , function( i,l){
                 id_name[i] = $(l).val();
           });

           $('#myForm #js_vars').val( id_name );
           $('#myForm').attr('action','supervisor/restoreall');
           $('#myForm').attr('_method','POST');
           $('#myForm').submit();
           //return true;
         }
         else
         {
          // $('input[name="checkboxID[]"]').prop('checked',false).iCheck('update');
          // clickShowHide();
         }
        // return false;
     }
    // return false;
}




/* --- Restore dialog    -------------------------------------------*/
function ajaxDelete(id)
{
  unCheckboxAll();
  unCheckboxListAll();
  $('#myForm #checkboxID'+id).prop('checked',true).iCheck('update');
    clickShowHide();
  //$('#myForm #checkboxID'+id).prop('checked',true).iCheck('update');
  //$('#checkboxID'+id).prop('checked',true).iCheck('update');
  if(confirm( txt['delete-confirm']  ))
  {
    $('#myForm #js_id').val(id);
    $('#myForm #js_action').val('delete');
    $('#myForm input[name="_method"]').val('delete');
    $('#myForm').attr("action", 'supervisor/trash/'+id);
    $('#myForm').submit();
  }
  else
  {
    $('#checkboxID'+id).prop('checked',false).iCheck('update');
      clickShowHide();
  }
}
//------ Delete All -----------------------------------------------------------
function ajaxMainDeleteAll()
{
       if( countCheckbox() <1 )
       {
           alert( txt['delete-more'] );
       }
       else
       {
         if( confirm( txt['delete-confirm'] ))
         {
           var id_name = [];

           $.each( $('input[name="checkboxID[]"]:checked') , function( i,l){
                 id_name[i] = $(l).val();
           });

           $('#myForm #js_vars').val( id_name );
            $('#myForm').attr('action','supervisor/trashall');
            $('#myForm').attr('_method','DELETE');
            $('#myForm').submit();
           //return true;
         }
         else
         {
          // $('input[name="checkboxID[]"]').prop('checked',false).iCheck('update');
          // clickShowHide();
         }
        // return false;
     }
    // return false;
}



/* --- show dialog change Status   -------------------------------------------*/
function show_status_modal()
{
  $('#myModal').on('show.bs.modal', function (event) {
    //alert('www');
     var button = $(event.relatedTarget); // Button that triggered the modal
     var s_id = button.data('itemid'); // Extract info from data-* attributes
     var s_value = button.data('itemvalue'); // Extract info from data-* attributes
     checkOne(s_id);
     //$('#checkboxID'+s_id).prop('checked',true).iCheck('update');
     //alert(button);
     $('#myStatusForm #js_id').val(s_id);

     $('#myStatusForm #js_vars').val(s_value);
     //alert(s_id);

     $.get('supervisor/getstatus/'+s_id,'', function(responseText) {
        // console.log(responseText);
         //console.log(responseText.status)

         if( responseText.status =='enable')
         {
           //$('#myStatusForm #status_enable').prop('checked' , 'checked');
           $('#myStatusForm #status_enable').prop('checked', 'checked').iCheck('update');
           $('#myStatusForm #status_disable').prop('checked', '').iCheck('update');
         }
         else {
           $('#myStatusForm #status_enable').prop('checked', '').iCheck('update');
           $('#myStatusForm #status_disable').prop('checked', 'checked').iCheck('update');
           //$('#myStatusForm #status_disable').prop('checked' , 'checked');
         }

    });
  })
  .on('hidden.bs.modal', function (event) {

    clearIChkBox();
  });
}

//-----------------------------------------------------------------------------------------------
function save_status_modal()
{

  $('#btnstatus').click(function(event) {

    var js_vars   = $('#myStatusForm').serialize();

    $.post('supervisor/changestatus',js_vars, function(responseText) {
        //console.log(js_vars);
        console.log(responseText)

        if(responseText.state=='true')
        {
            if(responseText.status=='enable')
            {
                $('#btnstatus'+responseText.js_id).removeClass('text-danger').addClass('text-success');
                  //$('#btnstatus'+responseText.js_id).removeClass('text-success').addClass('text-danger');
            }
            else
            {
              $('#btnstatus'+responseText.js_id).removeClass('text-success').addClass('text-danger');
            }
            $('#btnstatus'+responseText.js_id)
            .html('<i class="fa '+responseText.icon+'"></i>&nbsp;'+responseText.txt);
        }

    $('#myModal').modal('hide');


  });
});


}
function loaddatable()
{

var rows_selected = [];
var table =$('#example2').DataTable({

'columnDefs':
[
  {
   'targets': 0,
   'searchable':false,
   'orderable':false,
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
    'searchable':false,
    'orderable':true,
    'className': 'text-left'
  }
  ,
  {
    'targets': 3,
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
  "order": [[ 1, "desc" ]],

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
         var url           = 'supervisor/'+data_id+'/edit';
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
          $('#myForm').attr('action','supervisor/softdeleteall');
          $('#myForm').attr('_method','POST');
          $('#myForm').submit();
          return true;
    }
    return false;
  }


}
