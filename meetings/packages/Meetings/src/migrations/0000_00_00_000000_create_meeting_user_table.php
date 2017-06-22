<?php
namespace Meetings\migrations;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingUserTable extends Migration
{
    public function up()
    {
        Schema::create('meeting_user', function(Blueprint $t)
        {
            $t->increments('id')->unsigned();
            $t->integer('meeting_id');
            $t->integer('user_id');
            $t->integer('message_id');
            $t->string('response');
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('meeting_user');
    }
}