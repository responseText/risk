function unCheckboxAll()
{
  $('#myForm input[name="checkboxAll"').prop('checked',false).iCheck('update');
}
function CheckboxAll()
{
  $('#myForm input[name="checkboxAll"').prop('checked',true).iCheck('update');
}
function unCheckboxListAll()
{
  $('#myForm input[name="checkboxID[]"').prop('checked',false).iCheck('update');
}
function CheckboxListAll()
{
  $('#myForm input[name="checkboxID[]"').prop('checked',true).iCheck('update');
}
function countCheckbox(){
   return $('input[name="checkboxID[]"]:checked').length ;
}
//------------------------------------------------------------------------------
function showhideMainButtonAction(param){
  if(param == 'show')
  {
    $('#btnMainEdit').show();
    $('#btnMainTrash').show();
    $('#btnMainRestore').show();
    $('#btnMainDelete').show();
  }
  else {
    $('#btnMainEdit').hide();
    $('#btnMainTrash').hide();
    $('#btnMainRestore').hide();
    $('#btnMainDelete').hide();
  }
}













function clickShowHide()
{
  if( $('input[name="checkboxID[]"]:checked').length  >0 )
  {
    $('#btnMainEdit').show();
    $('#btnMainTrash').show();
      $('#btnMainRestore').show();
      $('#btnMainDelete').show();
  }
  else
  {
    $('#btnMainEdit').hide();
    $('#btnMainTrash').hide();
    $('#btnMainRestore').hide();
    $('#btnMainDelete').hide();
  }
}












function checkOne(param)
{
  //if()$('input[name="checkboxID[]"').prop('checked',false).iCheck('update');
  console.log(  'Param : '+param);
  $('#myForm #checkboxID'+param).prop('checked',true).iCheck('update');
/*
$('#myForm #checkboxID'+param).change(function(){
  $('input.cw2').not(this).prop('checked', false);
   }
})
*/
//$('#myForm #checkboxID'+param).prop('checked',true) .iCheck('update');
    if( $('#myForm #checkboxID'+param).prop('checked','checked') == true )
    {


      $('input[name="checkboxID[]"').prop('checked',false).iCheck('update');
    //  console.log(  'ww');
    //  $('#myForm input[name="checkboxID[]"').not(this).prop('checked',false).iCheck('update');
  }else {
    //console.log( 'NN');

        //$('input[name="checkboxID[]"').prop('checked',false).iCheck('update');

  }



}
//------------------------------------------------------------------------------
function clearIChkBox(){
  $('#myForm input[name^="checkboxID"]').prop('checked',false).iCheck('update');
}
//-----------------------------------------------------------------------------
function countChkboxForCheckAll()
{
    $('input[name="checkboxID[]"]').on('ifChanged', function(event) {
      if( event.target.checked == true)
      {
        if( $('input[name="checkboxID[]"]').length  == $('input[name="checkboxID[]"]:checked').length)
        {
          $('#myForm input[name="checkboxAll"]').prop('checked',true).iCheck('update');

        }
        else
        {
          $('#myForm input[name="checkboxAll"]').prop('checked',false).iCheck('update');

        }

      }
      else {
        $('#myForm input[name="checkboxAll"]').prop('checked',false).iCheck('update');

      }
    });

}
// ----------------------------------------------------------------------------
function chkAll(){
  $('.checkall').on('ifChanged', function(event) {
    if( event.target.checked == true)
    {
      $('#myForm input[name^="checkboxID"]').prop('checked',true).iCheck('update');
      $('#btnMainEdit').show();
      $('#btnMainTrash').show();
      $('#btnMainRestore').show();
      $('#btnMainDelete').show();
    }
    else {
          $('#myForm input[name^="checkboxID"]').prop('checked',false).iCheck('update');
          $('#btnMainEdit').hide();
          $('#btnMainTrash').hide();
          $('#btnMainRestore').hide();
          $('#btnMainDelete').hide();
    }
    //alert('checked = ' + event.target.checked);
    //alert('value = ' + event.target.value);
});
}
