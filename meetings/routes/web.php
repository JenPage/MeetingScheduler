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
use Illuminate\Support\Facades\Redis;
//use App\Events\UserSignedUp;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/company_contacts', 'MessageController@get_contacts');


Route::get('/redis', 'MessageController@redis');
Route::get('/get-messages', 'MessageController@get_messages');
Route::get('/get-messages/{id}', 'MessageController@get_messages');

Route::get('/messages', 'MessageController@index');
Route::get('/createevent', 'MessageController@index');
Route::get('/your-events', 'MessageController@index');

Route::get('edit-meeting', 'MeetingsController@edit_meeting');

Route::post('save-meeting', 'MeetingsController@update_meeting');
Route::get('delete-meeting', 'MeetingsController@delete_meeting');

Route::get('event/{id}', 'MeetingsController@event_page');

Route::post('/broadcast', 'MessageController@create_broadcast');

//Route::get('/messages', 'MessageController@get_messages');

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/event', function(){
//    $facade = EventClass::createEvent('test facade');
//    echo $facade;
//});
Route::get('/chat/{id}', 'MessageController@user_recieved_messages')->name('chat');

Route::get('/testMessage', 'HomeController@testMessage');

Route::get('/mymessages', 'MessageController@push_messages');

Route::get('/testOtherMessage', 'HomeController@testOtherMessage');

Route::get('create_meeting', 'MeetingsController@index');
Route::post('create_meeting', 'MeetingsController@create_meeting');

Route::get('meeting-invite', 'MeetingsController@meeting_invite');
Route::post('create_message', 'MessageController@create_message');

Route::get('get-meetings', 'MeetingsController@get_meetings');

Route::post('invite-contact', 'MeetingsController@invite_contact');
Route::post('event-response', 'MeetingsController@eventResponse');
// API route group that we need to protect
Route::group(['prefix' => 'api', 'middleware' => ['ability:owner,edit_payment,edit_message']], function()
{
    Auth::routes();
    Route::get('users', 'ApiController@company_users');
    Route::post('role', 'JwtAuthenticateController@createRole');
    Route::post('permission', 'JwtAuthenticateController@createPermission');
    Route::post('assign-role', 'JwtAuthenticateController@assignRole');
    Route::post('attach-permission', 'JwtAuthenticateController@attachPermission');
    Route::post('authenticate', 'JwtAuthenticateController@authenticate');

    Route::get('create_meeting', 'MeetingsController@create_meeting');
});

Route::group(['prefix' => 'api', 'middleware' => ['ability:member, edit_message']], function(){
    Route::post('create_message', 'MessageController@create_message');
    Route::post('login', 'ApiController@login');
    Route::get('get_sent_messages', 'MessageController@user_sent_messages');
    Route::get('get_recieved_messages', 'MessageController@user_recieved_messages');
    Route::get('get_threads', 'MessageController@user_all_messages');
});

//The Register and login routes for the website
Auth::routes();
