<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_user', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('movie_id')->unsigned();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');

            $table->string('type')->nullable();
            $table->decimal('score', 3,1)->nullable();
            $table->float('rating')->nullable();
            $table->integer('likes')->default(0);

            $table->text('review')->nullable();
            $table->text('rev_recap')->nullable();
            $table->float('rev_rating')->nullable();;
            $table->integer('rev_total_likes')->default(0);
            $table->timestamp('rev_date')->nullable();

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
        Schema::dropIfExists('movie_user');
    }
}
