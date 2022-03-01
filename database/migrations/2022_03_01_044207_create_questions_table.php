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

        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            // foreign key to the section table
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('sections');

            $table->text('text')->nullable();

            $table->text('type')->nullable();
            $table->text('options')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive'])->default('active');

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
        Schema::dropIfExists('questions');
    }
};
