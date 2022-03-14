<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();

            // all responses will be json encoded in the database and will be decoded in the frontend
            // all quiz responses stored in one json object with the question id as key
            $table->longText('data');

            $table->text('APS')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();

            $table->text('duration')->nullable();
            $table->text('started_at')->nullable();
            $table->text('finished_at')->nullable();
            $table->integer('progress')->nullable();

            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->foreign('quiz_id')->references('id')->on('quizzes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
