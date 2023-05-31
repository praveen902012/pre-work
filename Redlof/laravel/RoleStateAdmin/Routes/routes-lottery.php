<?php

Route::group(['middleware' => ['role:role-state-admin', 'web'], 'namespace' => 'Lottery', 'prefix' => 'stateadmin'], function () {
    $c = 'RoleStateAdminLotteryViewController@';
    Route::get('lottery', ['as' => 'stateadmin.lottery', 'uses' => $c . 'getLotteryView']);

    Route::get('lottery/result', ['as' => 'stateadmin.lottery-result', 'uses' => $c . 'getLotteryResultView']);

});

Route::group(array('prefix' => 'api/stateadmin', 'namespace' => 'Lottery'), function () {
    $c = 'RoleStateAdminLotteryController@';
    Route::post('lottery', $c . 'postLotteryDetails');
    Route::post('lottery/trigger', $c . 'postTriggerLottery');
    Route::post('lottery/send/notification/{application_id}', $c . 'postSendNotification');
    Route::get('lottery', $c . 'getLotteries');
    Route::get('lottery/result', $c . 'getAllottedStudent');
    Route::post('lottery/edit/{lottery_id}', $c . 'postEditLotteryDetails');
    Route::post('lottery/{lottery_id}/district-wise-stats', $c . 'postDownloadLotteryStats');

    Route::get('lottery/{lottery_id}', $c . 'getLottery');
    Route::get('lottery/search/all', $c . 'searchLotteries');
});
