<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
  if(  !Auth::guest()  )
   {
     return view('welcome');
   }
   else{
     //return view('auth.login');
      $ppp ='hello world';
      $getParm = DB::select('
      select
        ( select count(id) from incident where division_id="1") as "1",
        ( select count(id) from incident where division_id="1") as "2"
      ');

     return view('index')->with('ppp',$ppp)->with('param',$getParm);
   }
})->name('index');
*/


//Route::get('/', 'FontEndController@index')->name('index');
//Route::get('/', 'FontEndController@index')->name('index');
//Route::get('/', 'FontEndController@index')->name('index');
//Route::post('/', 'FontEndController@index')->name('index');
//Route::match(['get', 'post'],'/', 'FontEndController@index')->name('index');
//Route::match(array('GET', 'POST'), '/', 'FontEndController@index')->name('index');
Route::get('users/abc1', function () {
  $data   =  DB::table('level_access')->get();
              return response()->json(  $data );
});
Route::get('/', 'FontEndController@index')->name('index');
Route::post('fontend/indexsearch','FontEndController@indexsearch')->name('indexsearch');
Auth::routes();
Route::get('fontend/chart','FontEndController@chart');
Route::get('fontend/chart2','FontEndController@chart2')->name('chart2');
Route::get('fontend/test2','FontEndController@test2')->name('test2');
Route::get('fontend/line111','FontEndController@line111');


Route::get('/home', 'HomeController@index')->name('home');


Route::resource('typerisk','TypeRiskController');
Route::delete('/typerisk/trash/{id}'	                          ,'TypeRiskController@trash')->name('typerisk.trash');
Route::post('/typerisk/trashall'	                              ,'TypeRiskController@trashall')->name('typerisk.trashall');
Route::post('/typerisk/changestatus'	                          ,'TypeRiskController@changestatus')->name('typerisk.changestatus');
Route::get('/typerisk/getstatus/{id}'	                          ,'TypeRiskController@getstatus')->name('typerisk.getstatus');
Route::delete('/typerisk/restore/{id}'	                        ,'TypeRiskController@restore')->name('typerisk.restore');
Route::POST('/typerisk/restoreall'	                            ,'TypeRiskController@restoreall')->name('typerisk.restoreall');
Route::post('/typerisk/softdeleteall'		                        ,'TypeRiskController@softdeleteall')->name('typerisk.softdeleteall');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('violencelevel','ViolenceLevelController');
Route::delete('/violencelevel/trash/{id}'	                    ,'ViolenceLevelController@trash')->name('violencelevel.trash');
Route::post('/violencelevel/trashall'	                        ,'ViolenceLevelController@trashall')->name('violencelevel.trashall');
Route::post('/violencelevel/changestatus'	                    ,'ViolenceLevelController@changestatus')->name('violencelevel.changestatus');
Route::get('/violencelevel/getstatus/{id}'	                  ,'ViolenceLevelController@getstatus')->name('violencelevel.getstatus');
Route::delete('/violencelevel/restore/{id}'	                  ,'ViolenceLevelController@restore')->name('violencelevel.restore');
Route::POST('/violencelevel/restoreall'	                      ,'ViolenceLevelController@restoreall')->name('violencelevel.restoreall');
Route::post('/violencelevel/softdeleteall'		                ,'ViolenceLevelController@softdeleteall')->name('violencelevel.softdeleteall');


// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('violence','ViolenceController');
Route::delete('/violence/trash/{id}'	                    ,'ViolenceController@trash')->name('violence.trash');
Route::post('/violence/trashall'	                        ,'ViolenceController@trashall')->name('violence.trashall');
Route::post('/violence/changestatus'	                    ,'ViolenceController@changestatus')->name('violence.changestatus');
Route::get('/violence/getstatus/{id}'	                    ,'ViolenceController@getstatus')->name('violence.getstatus');
Route::delete('/violence/restore/{id}'	                  ,'ViolenceController@restore')->name('violence.restore');
Route::POST('/violence/restoreall'	                      ,'ViolenceController@restoreall')->name('violence.restoreall');
Route::post('/violence/softdeleteall'		                  ,'ViolenceController@softdeleteall')->name('violence.softdeleteall');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('riskprogram','RiskProgramController');
Route::delete('/riskprogram/trash/{id}'	                      ,'RiskProgramController@trash')->name('riskprogram.trash');
Route::post('/riskprogram/trashall'	                          ,'RiskProgramController@trashall')->name('riskprogram.trashall');
Route::post('/riskprogram/changestatus'	                      ,'RiskProgramController@changestatus')->name('riskprogram.changestatus');
Route::get('/riskprogram/getstatus/{id}'	                    ,'RiskProgramController@getstatus')->name('riskprogram.getstatus');
Route::delete('/riskprogram/restore/{id}'	                    ,'RiskProgramController@restore')->name('riskprogram.restore');
Route::POST('/riskprogram/restoreall'	                        ,'RiskProgramController@restoreall')->name('riskprogram.restoreall');
Route::post('/riskprogram/softdeleteall'		                   ,'RiskProgramController@softdeleteall')->name('riskprogram.softdeleteall');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('incidentgroup','IncidentGroupController');
Route::any('incidentgroup'	                             ,'IncidentGroupController@index')->name('incidentgroup.index');
Route::delete('/incidentgroup/trash/{id}'	                      ,'IncidentGroupController@trash')->name('incidentgroup.trash');
Route::post('/incidentgroup/trashall'	                          ,'IncidentGroupController@trashall')->name('incidentgroup.trashall');
Route::post('/incidentgroup/changestatus'	                      ,'IncidentGroupController@changestatus')->name('incidentgroup.changestatus');
Route::get('/incidentgroup/getstatus/{id}'	                    ,'IncidentGroupController@getstatus')->name('incidentgroup.getstatus');
Route::delete('/incidentgroup/restore/{id}'	                    ,'IncidentGroupController@restore')->name('incidentgroup.restore');
Route::POST('/incidentgroup/restoreall'	                        ,'IncidentGroupController@restoreall')->name('incidentgroup.restoreall');
Route::post('/incidentgroup/softdeleteall'		                   ,'IncidentGroupController@softdeleteall')->name('incidentgroup.softdeleteall');
Route::post('/incidentgroup/search'	                                  ,'IncidentGroupController@search')->name('incidentgroup.search');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('incidentlist','IncidentListController');
Route::any('incidentlist'	                             ,'IncidentListController@index')->name('incidentlist.index');
Route::delete('/incidentlist/trash/{id}'	                      ,'IncidentListController@trash')->name('incidentlist.trash');
Route::post('/incidentlist/trashall'	                          ,'IncidentListController@trashall')->name('incidentlist.trashall');
Route::post('/incidentlist/changestatus'	                      ,'IncidentListController@changestatus')->name('incidentlist.changestatus');
Route::get('/incidentlist/getstatus/{id}'	                    ,'IncidentListController@getstatus')->name('incidentlist.getstatus');
Route::delete('/incidentlist/restore/{id}'	                    ,'IncidentListController@restore')->name('incidentlist.restore');
Route::POST('/incidentlist/restoreall'	                        ,'IncidentListController@restoreall')->name('incidentlist.restoreall');
Route::post('/incidentlist/softdeleteall'		                   ,'IncidentListController@softdeleteall')->name('incidentlist.softdeleteall');
//Route::post('/incidentlist/search'	                                  ,'IncidentListController@search')->name('incidentlist.search');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('incidentcase','IncidentCaseController');
Route::delete('/incidentcase/trash/{id}'	                      ,'IncidentCaseController@trash')->name('incidentcase.trash');
Route::post('/incidentcase/trashall'	                          ,'IncidentCaseController@trashall')->name('incidentcase.trashall');
Route::post('/incidentcase/changestatus'	                      ,'IncidentCaseController@changestatus')->name('incidentcase.changestatus');
Route::get('/incidentcase/getstatus/{id}'	                    ,'IncidentCaseController@getstatus')->name('incidentcase.getstatus');
Route::delete('/incidentcase/restore/{id}'	                    ,'IncidentCaseController@restore')->name('incidentcase.restore');
Route::POST('/incidentcase/restoreall'	                        ,'IncidentCaseController@restoreall')->name('incidentcase.restoreall');
Route::post('/incidentcase/softdeleteall'		                   ,'IncidentCaseController@softdeleteall')->name('incidentcase.softdeleteall');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('effect','EffectController');
Route::delete('/effect/trash/{id}'	                      ,'EffectController@trash')->name('effect.trash');
Route::post('/effect/trashall'	                          ,'EffectController@trashall')->name('effect.trashall');
Route::post('/effect/changestatus'	                      ,'EffectController@changestatus')->name('effect.changestatus');
Route::get('/effect/getstatus/{id}'	                    ,'EffectController@getstatus')->name('effect.getstatus');
Route::delete('/effect/restore/{id}'	                    ,'EffectController@restore')->name('effect.restore');
Route::POST('/effect/restoreall'	                        ,'EffectController@restoreall')->name('effect.restoreall');
Route::post('/effect/softdeleteall'		                   ,'EffectController@softdeleteall')->name('effect.softdeleteall');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('division','DivisionController');
Route::delete('/division/trash/{id}'	                      ,'DivisionController@trash')->name('division.trash');
Route::post('/division/trashall'	                          ,'DivisionController@trashall')->name('division.trashall');
Route::post('/division/changestatus'	                      ,'DivisionController@changestatus')->name('division.changestatus');
Route::get('/division/getstatus/{id}'	                    ,'DivisionController@getstatus')->name('division.getstatus');
Route::delete('/division/restore/{id}'	                    ,'DivisionController@restore')->name('division.restore');
Route::POST('/division/restoreall'	                        ,'DivisionController@restoreall')->name('division.restoreall');
Route::post('/division/softdeleteall'		                   ,'DivisionController@softdeleteall')->name('division.softdeleteall');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('subdivision','SubDivisionController');
Route::delete('/subdivision/trash/{id}'	                      ,'SubDivisionController@trash')->name('subdivision.trash');
Route::post('/subdivision/trashall'	                          ,'SubDivisionController@trashall')->name('subdivision.trashall');
Route::post('/subdivision/changestatus'	                      ,'SubDivisionController@changestatus')->name('subdivision.changestatus');
Route::get('/subdivision/getstatus/{id}'	                    ,'SubDivisionController@getstatus')->name('subdivision.getstatus');
Route::delete('/subdivision/restore/{id}'	                    ,'SubDivisionController@restore')->name('subdivision.restore');
Route::POST('/subdivision/restoreall'	                        ,'SubDivisionController@restoreall')->name('subdivision.restoreall');
Route::post('/subdivision/softdeleteall'		                  ,'SubDivisionController@softdeleteall')->name('subdivision.softdeleteall');

// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('employee','EmployeeController');
Route::delete('/employee/trash/{id}'	                      ,'EmployeeController@trash')->name('employee.trash');
Route::post('/employee/trashall'	                          ,'EmployeeController@trashall')->name('employee.trashall');
Route::post('/employee/changestatus'	                      ,'EmployeeController@changestatus')->name('employee.changestatus');
Route::get('/employee/getstatus/{id}'	                    ,'EmployeeController@getstatus')->name('employee.getstatus');
Route::delete('/employee/restore/{id}'	                    ,'EmployeeController@restore')->name('employee.restore');
Route::POST('/employee/restoreall'	                        ,'EmployeeController@restoreall')->name('employee.restoreall');
Route::post('/employee/softdeleteall'		                  ,'EmployeeController@softdeleteall')->name('employee.softdeleteall');
Route::get( '/employee/getsubdivision/{id}'                 ,'EmployeeController@getsubdivision')->name('employee.getsubdivision');


// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('incident','IncidentController');
Route::delete('/incident/trash/{id}'	                      ,'IncidentController@trash')->name('incidentincident.trash');
Route::post('/incident/trashall'	                          ,'IncidentController@trashall')->name('incident.trashall');
Route::post('/incident/changestatus'	                      ,'IncidentController@changestatus')->name('incident.changestatus');
Route::get('/incident/getstatus/{id}'	                      ,'IncidentController@getstatus')->name('incident.getstatus');
Route::delete('/incident/restore/{id}'	                    ,'IncidentController@restore')->name('incident.restore');
Route::POST('/incident/restoreall'	                        ,'IncidentController@restoreall')->name('incident.restoreall');
Route::post('/incident/softdeleteall'		                    ,'IncidentController@softdeleteall')->name('incident.softdeleteall');
Route::get( '/incident/getsubdivision/{id}'                 ,'IncidentController@getsubdivision')->name('incident.getsubdivision');
Route::get( '/incident/getincidentlist/{id}'                 ,'IncidentController@getincidentlist')->name('incident.getincidentlist'  );
Route::get( '/incident/getviolence/{id}'                    ,'IncidentController@getviolence')->name('incident.getviolence'  );
Route::post( '/incident/search'                             ,'IncidentController@search')->name('incident.search' );
Route::get( '/incident/list/index'                             ,'IncidentController@list')->name('incident.list' );
Route::get( '/incident/listshow/{id}'                         ,'IncidentController@listshow')->name('incident.listshow' );




// --------------------------------------------------------------------------------------------------------------------------------------------
Route::get('users/abc3', function () {
  $data   =  DB::table('level_access')->get();
              return response()->json(  $data );
});
Route::get('users/abc4', function () {
  $data   =  DB::table('level_access')->get();
              return response()->json(  $data );
});
Route::resource('users','UsersController');


Route::get('users/abc3', function () {
  $data   =  DB::table('level_access')->get();
              return response()->json(  $data );
});
Route::delete('/users/trash/{id}'	                      ,'UsersController@trash')->name('users.trash');
Route::post('/users/trashall'	                          ,'UsersController@trashall')->name('users.trashall');
Route::post('/users/changestatus'	                      ,'UsersController@changestatus')->name('users.changestatus');
Route::get('/users/getstatus/{id}'	                    ,'UsersController@getstatus')->name('users.getstatus');
Route::delete('/users/restore/{id}'	                    ,'UsersController@restore')->name('users.restore');
Route::POST('/users/restoreall'	                        ,'UsersController@restoreall')->name('users.restoreall');
Route::post('/users/softdeleteall'		                  ,'UsersController@softdeleteall')->name('users.softdeleteall');
Route::get( '/users/getsubdivision/{id}'                ,'UsersController@getsubdivision')->name('users.getsubdivision');
Route::get('/users/show1/{id}'	                        ,'UsersController@show1')->name('users.show1');
Route::get('/users/{id}/edit1'	                        ,'UsersController@edit1')->name('users.edit1');
Route::get('/users/changepassword/{id}'	                  ,'UsersController@changepassword')->name('users.changepassword');
Route::post('/users/updatepassword'	                   ,'UsersController@updatepassword')->name('users.updatepassword');
Route::patch('/users/{id}'	                            ,'UsersController@update1')->name('users.update1');
Route::get('users/uploadimageprompt/{id}'              ,'UsersController@uploadimageprompt')->name('users.uploadimageprompt');
Route::post('users/uploadimage'                       ,'UsersController@uploadimage')->name('users.uploadimage');

Route::post('users/getlevel'              ,'UsersController@getlevel')->name('users.getlevel');
Route::post('users/getdivision'                 ,'UsersController@getdivision')->name('users.getdivision');
Route::post('users/getsubdivision'                 ,'UsersController@getsubdivision')->name('users.getsubdivision');



Route::get('/users/abc2', function () {
  $data   =  DB::table('level_access')->get();
              return response()->json(  $data );
});



Route::resource('headrmsendback','HeadRMSendBackController');
Route::post('/headrmsendback/updateevent'		           ,'HeadRMSendBackController@updateevent')->name('headrmsendback.updateevent');
Route::get('/headrmsendback/{id}/promptremove'	        ,'HeadRMSendBackController@promptremove')->name('headrmsendback.promptremove');
Route::post('/headrmsendback/headrmdelete'		          ,'HeadRMSendBackController@headrmdelete')->name('headrmsendback.headrmdelete');
Route::post('/headrmsendback/rmrestore'		              ,'HeadRMSendBackController@rmrestore')->name('headrmsendback.rmrestore');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('headrmremove','HeadRMRemoveController');
Route::get('/headrmremove/{id}/show1'	                ,'HeadRMRemoveController@show1')->name('headrmremove.show1');
Route::get( '/headrmremove/getsubdivision/{id}'       ,'HeadRMRemoveController@getsubdivision')->name('headrmremove.getsubdivision');
Route::get( '/headrmremove/getviolence/{id}'          ,'HeadRMRemoveController@getviolence')->name('headrmremove.getviolence'  );
Route::get( '/headrmremove/getincidentlist/{id}'      ,'HeadRMRemoveController@getincidentlist')->name('headrmremove.getincidentlist'  );
Route::get('/headrmremove/{id}/promptremove'	        ,'HeadRMRemoveController@promptremove')->name('headrmremove.promptremove');
Route::post('/headrmremove/headrmdelete'		          ,'HeadRMRemoveController@headrmdelete')->name('headrmremove.headrmdelete');
Route::post('/headrmremove/rmrestore'		              ,'HeadRMRemoveController@rmrestore')->name('headrmremove.rmrestore');
Route::post('/headrmremove/updateevent'		           ,'HeadRMRemoveController@updateevent')->name('headrmremove.updateevent');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('usersindepreport','UsersIndepReportController');
Route::post('usersindepreport'	                       ,'UsersIndepReportController@index')->name('usersindepreport.index');
Route::get('usersindepreport/list/{id}/{daterage}'	   ,'UsersIndepReportController@list')->name('usersindepreport.list');
Route::get('usersindepreport/review/{id}'	             ,'UsersIndepReportController@review')->name('usersindepreport.review');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('usersinsubdivisionreport','UsersInSubDivisionReportController');
Route::post('usersinsubdivisionreport'	                       ,'UsersInSubDivisionReportController@index')->name('usersinsubdivisionreport.index');
Route::get('usersinsubdivisionreport/list/{id}/{daterage}'	   ,'UsersInSubDivisionReportController@list')->name('usersinsubdivisionreport.list');
Route::get('usersinsubdivisionreport/review/{id}'	             ,'UsersInSubDivisionReportController@review')->name('usersinsubdivisionreport.review');





// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('headdivisionreview','HeadDivisionReviewController');
Route::get('headdivisionreview/list/index'	                ,'HeadDivisionReviewController@list')->name('headdivisionreview.list');
Route::get('headdivisionreview/{id}/show1'	                ,'HeadDivisionReviewController@show1')->name('headdivisionreview.show1');
Route::get('headdivisionreview/{id}/show2'	                ,'HeadDivisionReviewController@show2')->name('headdivisionreview.show2');
Route::post('headdivisionreview/sendbackrm'	               ,'HeadDivisionReviewController@sendbackrm')->name('headdivisionreview.sendbackrm');
Route::get('headdivisionreview/{id}/showtorm'	             ,'HeadDivisionReviewController@showtorm')->name('headdivisionreview.showtorm');
Route::post('headdivisionreview/search'	                   ,'HeadDivisionReviewController@search')->name('headdivisionreview.search');



// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('headsubdivisionreview','HeadSubDivisionReviewController');
Route::any('headsubdivisionreview/list/index'	              ,'HeadSubDivisionReviewController@list')->name('headsubdivisionreview.list');
Route::get('headsubdivisionreview/create/{id}'	        ,'HeadSubDivisionReviewController@create')->name('headsubdivisionreview.create');

//Route::get('headsubdivisionreview/list/index'	          ,'HeadSubDivisionReviewController@list')->name('headsubdivisionreview.list');
Route::get('headsubdivisionreview/{id}/show1'	          ,'HeadSubDivisionReviewController@show1')->name('headsubdivisionreview.show1');
Route::get('headsubdivisionreview/{id}/show2'	          ,'HeadSubDivisionReviewController@show2')->name('headsubdivisionreview.show2');
Route::post('headsubdivisionreview/sendbackrm'	        ,'HeadSubDivisionReviewController@sendbackrm')->name('headsubdivisionreview.sendbackrm');
Route::post('headsubdivisionreview/search'	                    ,'HeadSubDivisionReviewController@search')->name('headsubdivisionreview.search');

// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('rmdivisionreview','RMDivisionReviewController');
Route::get('rmdivisionreview/list/index'	                ,'RMDivisionReviewController@list')->name('rmdivisionreview.list');
Route::get('rmdivisionreview/{id}/show1'	                ,'RMDivisionReviewController@show1')->name('rmdivisionreview.show1');
Route::get('rmdivisionreview/{id}/show2'	                ,'RMDivisionReviewController@show2')->name('rmdivisionreview.show2');
Route::post('rmdivisionreview/sendbackrm'	                ,'RMDivisionReviewController@sendbackrm')->name('rmdivisionreview.sendbackrm');
Route::get('rmdivisionreview/{id}/showtorm'	              ,'RMDivisionReviewController@showtorm')->name('rmdivisionreview.showtorm');
Route::post('rmdivisionreview/search'	                    ,'RMDivisionReviewController@search')->name('rmdivisionreview.search');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('rmsubdivisionreview','RMSubDivisionReviewController');
Route::get('rmsubdivisionreview/list/index'	                ,'RMSubDivisionReviewController@list')->name('rmsubdivisionreview.list');
Route::get('rmsubdivisionreview/create/{id}'	        ,'RMSubDivisionReviewController@create')->name('rmsubdivisionreview.create');
Route::get('rmsubdivisionreview/{id}/show1'	                ,'RMSubDivisionReviewController@show1')->name('rmsubdivisionreview.show1');
Route::get('rmsubdivisionreview/{id}/show2'	                ,'RMSubDivisionReviewController@show2')->name('rmsubdivisionreview.show2');
Route::post('rmsubdivisionreview/sendbackrm'	                ,'RMSubDivisionReviewController@sendbackrm')->name('rmsubdivisionreview.sendbackrm');
Route::get('rmsubdivisionreview/{id}/showtorm'	              ,'RMSubDivisionReviewController@showtorm')->name('rmsubdivisionreview.showtorm');
Route::post('rmsubdivisionreview/search'	                    ,'RMSubDivisionReviewController@search')->name('rmsubdivisionreview.search');
// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('rmsubdivisionallreview','RMSubDivisionAllReviewController');
Route::get('rmsubdivisionallreview/list/index'	                ,'RMSubDivisionAllReviewController@list')->name('rmsubdivisionallreview.list');
Route::get('rmsubdivisionallreview/{id}/show1'	                ,'RMSubDivisionAllReviewController@show1')->name('rmsubdivisionallreview.show1');
Route::get('rmsubdivisionallreview/{id}/show2'	                ,'RMSubDivisionAllReviewController@show2')->name('rmsubdivisionallreview.show2');
Route::post('rmsubdivisionallreview/sendbackrm'	                ,'RMSubDivisionAllReviewController@sendbackrm')->name('rmsubdivisionallreview.sendbackrm');
Route::get('rmsubdivisionallreview/{id}/showtorm'	              ,'RMSubDivisionAllReviewController@showtorm')->name('rmsubdivisionallreview.showtorm');
Route:

// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('headrmreview','HeadRMReviewController');
Route::post('headrmreview'	                    ,'HeadRMReviewController@search')->name('headrmreview.search');

Route::get('headrmreview/list/index'	                    ,'HeadRMReviewController@list')->name('headrmreview.list');
Route::get('headrmreview/{id}/show1'	                    ,'HeadRMReviewController@show1')->name('headrmreview.show1');
Route::get('headrmreview/create/{id}'	                    ,'HeadRMReviewController@create')->name('headrmreview.create');


// --------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('headdivisionnoanswer','HeadDivisionNoAnswerController');
Route::post('headdivisionnoanswer'	                    ,'HeadDivisionNoAnswerController@search')->name('headdivisionnoanswer.search');
Route::get('headdivisionnoanswer/list/index'	                    ,'HeadDivisionNoAnswerController@list')->name('headdivisionnoanswer.list');
Route::get('headdivisionnoanswer/{id}/show1'	                    ,'HeadDivisionNoAnswerController@show1')->name('headdivisionnoanswer.show1');
Route::get('headdivisionnoanswer/create/{id}'	                    ,'HeadDivisionNoAnswerController@create')->name('headdivisionnoanswer.create');


//---------------------------------------------------------------------------------------------------------------------------------------
Route::resource('headrmlistall','HeadRMListAllController');
Route::post('headrmlistall'	                    ,'HeadRMListAllController@search')->name('headrmlistall.search');
Route::post('headrmlistall/callbackrm'	        ,'HeadRMListAllController@callbackrm')->name('headrmlistall.callbackrm');
// --------------------------------------------------------------------------------------------------------------------------------------------



Route::resource('utility','UtilityController');
Route::post('/utility/alertnotkey'	                      ,'UtilityController@alertnotkey')->name('utility.alertnotkey');
/*
Route::resource('supervisor','SupervisorController');
Route::delete('/supervisor/trash/{id}'	                      ,'SupervisorController@trash')->name('supervisor.trash');
Route::post('/supervisor/trashall'	                          ,'SupervisorController@trashall')->name('supervisor.trashall');
Route::post('/supervisor/changestatus'	                      ,'SupervisorController@changestatus')->name('supervisor.changestatus');
Route::get('/supervisor/getstatus/{id}'	                    ,'SupervisorController@getstatus')->name('supervisor.getstatus');
Route::delete('/supervisor/restore/{id}'	                    ,'SupervisorController@restore')->name('supervisor.restore');
Route::POST('/supervisor/restoreall'	                        ,'SupervisorController@restoreall')->name('supervisor.restoreall');
Route::post('/supervisor/softdeleteall'		                  ,'SupervisorController@softdeleteall')->name('supervisor.softdeleteall');
Route::get( '/supervisor/getsubdivision/{id}'                 ,'SupervisorController@getsubdivision')->name('supervisor.getsubdivision');
*/





Route::get('fontend/test/{id}'	                ,'FontEndController@test')->name('fontend.test');

//-----------------------------------------------------------------------------

Route::get('new_msg/countrisk'	                ,'StateMessageController@countrisk')->name('new_msg.countrisk');













//--------------- REPORT ------------------------------------------------------------------------------------
Route::get('/reports/index'	                    ,'ReportsController@index')->name('reports.index');
Route::get('/reports/divisiondetail'	                ,'ReportsController@divisiondetail')->name('reports.divisiondetail');
Route::post('/reports/divisiondetail'	                ,'ReportsController@divisiondetail')->name('reports.divisiondetail');
Route::get('/reports/divisiondetail/export'	    ,'ReportsController@divisiondetail_export')->name('reports.divisiondetail.export');
Route::get('/reports/divisiondetail/exportExcel/{division}/{originaldate}', 'ReportsController@exportExcel')->name('reports.divisiondetail.exportExcel');
Route::get('/reports/divisiondetail/exportPDF', 'ReportsController@exportPDF')->name('reports.divisiondetail.exportPDF');
Route::get('/reports/divisiondetail/exportPDF2', 'ReportsController@exportPDF2')->name('reports.divisiondetail.exportPDF2');
//---------------------------------------------------------
Route::any('/reports/divisionfordetail'	                ,'Reports\DivisionForDetailController@index')->name('reports.divisionfordetail.index');
Route::get('/reports/divisionfordetail/{id}'	                ,'Reports\DivisionForDetailController@show')->name('reports.divisionfordetail.show');
Route::get('/reports/divisionfordetail/exportExcel/{division}/{originaldate}', 'Reports\DivisionForDetailController@exportExcel')->name('reports.divisionfordetail.exportExcel');


//--------------- REPORT หน่วยงาน-----------------------------------------------------------------------------
//Route::any('/reports/subdivisiondetail'	                      ,'Reports\SubDivisionDetailsController@index')->name('reports.subdivisiondetail');
Route::any('/reports/subdivisiondetail'	                      ,'Reports\SubDivisionDetailController@index')->name('reports.subdivisiondetail');
Route::get('/reports/subdivisiondetail/{id}'	                ,'Reports\SubDivisionDetailController@show')->name('reports.subdivisiondetail.show');
Route::get('/reports/subdivisiondetail/getsubdivision/{id}'   ,'Reports\SubDivisionDetailController@getsubdivision')->name('reports.subdivisiondetail.getsubdivision');
Route::get('/reports/subdivisiondetail/exportExcel/{division}/{subdivision}/{originaldate}', 'Reports\SubDivisionDetailController@exportExcel')
          ->name('reports.subdivisiondetail.exportExcel');
//--------------- REPORT รายงานกลุ่มงานที่ได้รับการรายงานอุบัติการณ์สูงสุด ---------------------------------------------
Route::any('/reports/divisiononreport'	                      ,'Reports\DivisionOnReportController@index')->name('reports.divisiononreport');
Route::get('/reports/divisiononreport/exportExcel/{originaldate}', 'Reports\DivisionOnReportController@exportExcel')->name('reports.divisiononreport.exportExcel');
//--------------- REPORT รายงานหน่วยงานที่ได้รับการรายงานอุบัติการณ์สูงสุด ---------------------------------------------
Route::any('/reports/subdivisiononreport'	                      ,'Reports\SubDivisionOnReportController@index')->name('reports.subdivisiononreport');
Route::get('/reports/subdivisiononreport/exportExcel/{originaldate}', 'Reports\SubDivisionOnReportController@exportExcel')->name('reports.subdivisiononreport.exportExcel');
//--------------- REPORT รายงานเจ้าหน้าที่ที่มีการรายงานอุบัติการณ์สูงสุด ---------------------------------------------
Route::any('/reports/usersreport'	                      ,'Reports\UsersReportController@index')->name('reports.usersreport');
Route::get('/reports/usersreport/exportExcel/{originaldate}', 'Reports\UsersReportController@exportExcel')->name('reports.usersreport.exportExcel');

//--------------- REPORT รายงานกลุ่มงานที่มีการรายงานอุบัติการณ์สูงสุด ---------------------------------------------
Route::any('/reports/divisionsendreport'	                      ,'Reports\DivisionSendReportController@index')->name('reports.divisionsendreport');
Route::get('/reports/divisionsendreport/exportExcel/{originaldate}', 'Reports\DivisionSendReportController@exportExcel')->name('reports.divisionsendreport.exportExcel');

//--------------- REPORT รายงาน สรุปจำนวนอุบัติการณ์ แยกตามอุบัติการณ์ ---------------------------------------------
Route::any('/reports/summaryincidentseparatelist'	                      ,'Reports\SummaryIncidentSeparateListController@index')->name('reports.summaryincidentseparatelist');
Route::get('/reports/summaryincidentseparatelist/exportExcel/{originaldate}', 'Reports\SummaryIncidentSeparateListController@exportExcel')->name('reports.summaryincidentseparatelist.exportExcel');

//--------------- REPORT รายงานสรุปจำนวนอุบัติการณ์ แยกตามความรุนแรง (รวมทุกหน่วย) ---------------------------------------------
Route::any('/reports/violencealldivision'	                      ,'Reports\ViolenceAllDivisionController@index')->name('reports.violencealldivision');
Route::get('/reports/violencealldivision/exportExcel/{originaldate}', 'Reports\ViolenceAllDivisionController@exportExcel')->name('reports.violencealldivision.exportExcel');


//--------------- REPORT รายงาน เจ้าหน้าที่ที่มีการรายงานสูงสุด แบบกลุ่มตามหน่วยงาน (รวมทุกหน่วย) ---------------------------------------------
Route::any('/reports/usersreportall'	                      ,'Reports\UsersReportAllController@index')->name('reports.usersreportall');
Route::get('/reports/usersreportall/exportExcel/{originaldate}', 'Reports\UsersReportAllController@exportExcel')->name('reports.usersreportall.exportExcel');
Route::get('/reports/usersreportall/getsubdivision/{id}'    ,'Reports\UsersReportAllController@getsubdivision')->name('reports.usersreportall.getsubdivision');

///--------------- REPORT รายงาน ความเสี่ยง ทั่วไป ---------------------------------------------
Route::any('/reports/general'	                      ,'Reports\GeneralController@index')->name('reports.general');
Route::get('/reports/general/{id}'	                  ,'Reports\GeneralController@show')->name('reports.general.show');
Route::get('/reports/general/getsubdivision/{id}'    ,'Reports\GeneralController@getsubdivision')->name('reports.general.getsubdivision');
Route::get('/reports/general/exportExcel/{division}/{subdivision}/{originaldate}', 'Reports\GeneralController@exportExcel')
          ->name('reports.general.exportExcel');
///--------------- REPORT รายงาน ความเสี่ยง Near Miss ---------------------------------------------
Route::any('/reports/nearmiss'	                      ,'Reports\NearMissController@index')->name('reports.nearmiss');
Route::get('/reports/nearmiss/{id}'	                  ,'Reports\NearMissController@show')->name('reports.nearmiss.show');
Route::get('/reports/nearmiss/getsubdivision/{id}'    ,'Reports\NearMissController@getsubdivision')->name('reports.nearmiss.getsubdivision');
Route::get('/reports/nearmiss/exportExcel/{division}/{subdivision}/{originaldate}', 'Reports\NearMissController@exportExcel')
          ->name('reports.nearmiss.exportExcel');

///--------------- REPORT รายงาน ความเสี่ยง Sentinel Event   ---------------------------------------------
Route::any('/reports/sentinelevent'	                      ,'Reports\SentinelEventController@index')->name('reports.sentinelevent');
Route::get('/reports/sentinelevent/{id}'	                  ,'Reports\SentinelEventController@show')->name('reports.sentinelevent.show');
Route::get('/reports/sentinelevent/getsubdivision/{id}'    ,'Reports\SentinelEventController@getsubdivision')->name('reports.sentinelevent.getsubdivision');
Route::get('/reports/sentinelevent/exportExcel/{division}/{subdivision}/{originaldate}', 'Reports\SentinelEventController@exportExcel')
          ->name('reports.sentinelevent.exportExcel');
///--------------- REPORT รายงาน ความเสี่ยงที่ต้องทำ RCA  ---------------------------------------------
Route::any('/reports/rca'	                      ,'Reports\RCAController@index')->name('reports.rca');
Route::get('/reports/rca/{id}'	                  ,'Reports\RCAController@show')->name('reports.rca.show');
Route::get('/reports/rca/getsubdivision/{id}'    ,'Reports\RCAController@getsubdivision')->name('reports.rca.getsubdivision');
Route::get('/reports/rca/exportExcel/{division}/{subdivision}/{originaldate}', 'Reports\RCAController@exportExcel')
          ->name('reports.rca.exportExcel');

///--------------- REPORT รายงาน สรุปจำนวนอุบัติการณ์ แยกตามอุบัติการณ์  ---------------------------------------------
Route::any('/reports/incidentlist'	                      ,'Reports\IncidentListController@index')->name('reports.incidentlist');
Route::get('/reports/incidentlist/{id}'	                  ,'Reports\IncidentListController@show')->name('reports.incidentlist.show');
Route::get('/reports/incidentlist/getsubdivision/{id}'    ,'Reports\IncidentListController@getsubdivision')->name('reports.incidentlist.getsubdivision');
Route::get('/reports/incidentlist/exportExcel/{division}/{subdivision}/{originaldate}', 'Reports\IncidentListController@exportExcel')
          ->name('reports.incidentlist.exportExcel');

//--------------- REPORT รายงานสรุปจำนวนอุบัติการณ์ แยกตามความรุนแรง (รวมทุกหน่วย) ---------------------------------------------
Route::any('/reports/violencesummary'	                      ,'Reports\ViolenceSummaryController@index')->name('reports.violencesummary');
Route::get('/reports/violencesummary/getsubdivision/{id}'    ,'Reports\ViolenceSummaryController@getsubdivision')->name('reports.violencesummary.getsubdivision');
Route::get('/reports/violencesummary/exportExcel/{originaldate}', 'Reports\ViolenceSummaryController@exportExcel')->name('reports.violencesummary.exportExcel');
// ---------- REPORT รายงาน ความเสี่ยง TypeKisk   ---------------------------------------------
Route::any('/reports/typerisk'	                      ,'Reports\TypeRiskController@index')->name('reports.typerisk');
Route::get('/reports/typerisk/{id}'	                  ,'Reports\TypeRiskController@show')->name('reports.typerisk.show');
Route::get('/reports/typerisk/getsubdivision/{id}'    ,'Reports\TypeRiskController@getsubdivision')->name('reports.typerisk.getsubdivision');
Route::get('/reports/typerisk/exportExcel/{typerisk}/{division}/{subdivision}/{originaldate}', 'Reports\TypeRiskController@exportExcel')
          ->name('reports.typerisk.exportExcel');

//--------------- REPORT รายงาน สรุปจำนวนอุบัติการณ์ตามผู้พบเห็นอุบัติการณ์ ---------------------------------------------
Route::any('/reports/witness'	                      ,'Reports\WitnessReportController@index')->name('reports.witness');
Route::get('/reports/witness/exportExcel/{originaldate}', 'Reports\WitnessReportController@exportExcel')->name('reports.witness.exportExcel');
//--------------- REPORT รายงานจำนวนอุบัติการณ์ตามโปรแแกรมความเสี่ยง---------------------------------------------
Route::any('/reports/riskprogram'	                      ,'Reports\RiskProgramReportController@index')->name('reports.riskprogram');
Route::any('/reports/riskprogram/list-main'	            ,'Reports\RiskProgramReportController@listmain')->name('reports.riskprogram.list-main');
Route::any('/reports/riskprogram/list-sub'	            ,'Reports\RiskProgramReportController@listsub')->name('reports.riskprogram.list-sub');
Route::get('/reports/riskprogram/detail/{id}'	              ,'Reports\RiskProgramReportController@detail')->name('reports.riskprogram.detail');
Route::get('/reports/riskprogram/exportExcel/{riskprogram}/{originaldate}', 'Reports\RiskProgramReportController@exportExcel')->name('reports.riskprogram.exportExcel');



Route::get('/reports/x1/{id}', 'ReportsController@x1')->name('reports.x1');

Route::get('/reports/selectPdf/{id}', 'ReportsController@selectPdf')->name('reports.divisiondetail.selectPdf');

//Route::get('/reports/divisiondetail/exportm/{type}/{division_id}', 'ReportsController@exportm');
//Route::post('/reports/typerisk'	                ,'ReportsController@typerisk')->name('reports.typerisk');
