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
        Schema::create('lavoter_votes', function (Blueprint $table)
        {
            $table->increments('id');
            $table->morphs('voteable'); // voteable_id and voteable_type columns
            $table->string('uuid')->index();
            $table->integer('value');
            $table->timestamps();

            $table->unique(['voteable_id', 'voteable_type', 'uuid']);
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
