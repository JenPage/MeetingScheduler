<?php
namespace Meetings\migrations;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration
{
    public function up()
    {
        Schema::create('meetings', function(Blueprint $t)
        {
            $t->increments('id')->unsigned();
            $t->string('type');
            $t->integer('owner');
            $t->string('date');
            $t->string('location');
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('meetings');
    }
}