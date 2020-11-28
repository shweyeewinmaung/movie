<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('episode_name')->nullable();
            $table->integer('moviename_id');
            $table->string('season_number')->nullable();
            $table->text('video_file');
            $table->string('disk')->nullable();
            $table->string('stream_path');
            $table->integer('processed')->default(0);
            $table->datetime('converted_for_streaming_at')->nullable();
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
        Schema::dropIfExists('movies');
    }
}
