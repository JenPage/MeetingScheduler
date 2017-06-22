<?php
namespace Meetings;
use Route;

Route::get('meetings/{id}', 'Meetings\Controllers\MeetingsController@index');