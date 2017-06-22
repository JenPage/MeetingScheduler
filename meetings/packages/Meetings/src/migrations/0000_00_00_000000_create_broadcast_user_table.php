<?php
namespace Meetings\migrations;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBroadcastUserTable extends Migration
{
    public function up()
    {
        Schema::create('broadcast_user', function(Blueprint $t)
        {
            $t->increments('id')->unsigned();
            $t->integer('user_id');
            $t->integer('message_id');
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('broadcast_user');
    }
}