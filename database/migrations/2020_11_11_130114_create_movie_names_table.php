<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_names', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subcategory_id');
            $table->integer('category_id');
            $table->string('name');
            $table->string('prefix_for_movie');
            $table->text('movie_file');
            $table->text('outline');
            $table->boolean('episode')->default(0);
            $table->string('status')->nullable();
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
        Schema::dropIfExists('movie_names');
    }
}
