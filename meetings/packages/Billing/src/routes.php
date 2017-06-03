<?php
namespace Billing;

use Route;

use Billing;

Route::group(['middleware' => ['web']], function () {

Route::get('plans', function(){
    return 'plans';
});

Route::get('subscription', 'Billing\Controllers\PlanController@index');

Route::get('signup/{plan}', 'Billing\Controllers\PlanController@signup');

Route::post('save/plan', 'Billing\Controllers\PlanController@save')->name('save.plan');


});
