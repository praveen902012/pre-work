<?php

Route::group(['middleware' => ['role:role-nodal-admin', 'web'], 'namespace' => 'Grievance'], function () {

	Route::get('nodaladmin/admission-denied', ['as' => 'nodaladmin.admission.denied', 'uses' => 'GrievanceViewController@getAdmissionDeniedView']);

});

Route::group(array('prefix' => 'api/nodaladmin', 'namespace' => 'Grievance', 'middleware' => ['throttle:60,60']), function () {

	Route::get('admission-denied', 'GrievanceController@getAdmissionDenied');

});