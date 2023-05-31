<?php

Route::group(array('prefix' => 'api/stateadmin', 'namespace' => 'Scripts', 'middleware' => ['throttle:60,60']), function () {

    $sc = 'ScriptsController@';

    Route::post('migrate/schools/new-cycle/{status}', $sc . 'migrateSchoolsToNewCycle');

    Route::get('remove/duplicate/school/level/entries/{type?}', $sc . 'removeDuplicateLevelEntries');

    Route::post('map/school/to/nodal', $sc . 'postMapSchoolToNodal');

    Route::post('map/school/cycles-status', $sc . 'postSchoolStatusCycles');

    Route::get('schools/not-registered-in/school_cycles/for-latest-app-cyc/{type}', $sc . 'getSchoolsNotRegisteredInLatestAppCyc');

    Route::get('schools/registered-in/school_cycles/for-latest-app-cyc/have-zero-or-null-avalible-seats', $sc . 'getSchoolsRegisteredInLatestAppCycWithNullAvaliableSeats');

    Route::get('schools/re-checked', $sc . 'getRecheckSchool');

    Route::post('schools/convert/re-checked/to/registered', $sc . 'postConvertRecheckSchoolToRegistered');

    Route::get('get-school/{type}', $sc . 'getSchool');

    Route::get('get-complete-school/{udise}', $sc . 'getCompleteSchool');

    Route::post('script/school-admin/update', $sc . 'postSchoolAdminUpdate');

    Route::post('script/download-duplicate-udise-schools', $sc . 'postDownloadDuplicateUdiseSchools');

    Route::post('script/school-status-update', $sc . 'postSchoolCycleStatusUpdate');

    Route::get('script/school/{school_id}/subsublocality/all', $sc . 'getStateSubLocality');

    Route::post('script/school/{school_id}/subsublocality/add', $sc . 'postAddSchoolSubLocality');

    // students section APIs

    Route::get('script/student/applied-to-school/udise/{udise?}', $sc . 'getStudentsSelectedSchoolInPreferrence');

    Route::get('script/student/applied-to-school/udise/{udise?}/replace-udise/{replace_udise?}', $sc . 'getStudentsSelectedSchoolInPreferrenceReplace');

    Route::post('script/student/applied-to-school/app_cyc/{app_cyc}/udise/{udise?}/download', $sc . 'getStudentsSelectedSchoolInPreferrenceDownload');

    Route::get('script/student/info/{stu_data}', $sc . 'getAllSearchedStudent');

    Route::get('script/students/schools-not-selected', $sc . 'getStudentsNotSchools');

    Route::post('script/student/status/update', $sc . 'postStudentStatusUpdate');

    Route::post('script/student/category/update', $sc . 'postStudentCategoryUpdate');

    Route::post('script/student/dob/update', $sc . 'postStudentDOBUpdate');

    Route::get('script/student/step2/get', $sc . 'getRegistratonStep2');

    Route::post('script/manual/lottery/run', $sc . 'postManualTriggerLottery');

    Route::post('script/lottery/analysis', $sc . 'postLotteryAnalysis');

    Route::post('script/student/{registration_id}/allot-seat', $sc . 'postAllotStudentSeat');

    Route::get('script/students/not-allotted', $sc . 'getNotAllottedStudents');

    Route::get('script/students/not-updated-application', $sc . 'getStudentsNotUpdatedSecondCycle');

});

Route::group(array('namespace' => 'Scripts', 'middleware' => ['throttle:60,60']), function () {

    $sc = 'ScriptsController@';

    Route::get('scripts', $sc . 'scriptLandingPage');

});
