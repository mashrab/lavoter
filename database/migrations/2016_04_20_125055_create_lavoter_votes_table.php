<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLavoterVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lavoter_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('voteable');
            $table->string('uuide')->index();
            $table->integer('value');
            $table->timestamps();
            $table->unique(['voteable_id', 'voteable_type', 'uuide']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lavoter_votes');
    }
}
