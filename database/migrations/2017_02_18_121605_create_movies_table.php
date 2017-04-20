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
        Schema::create('movies', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('year');
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->string('status')->nullable();
            $table->text('summary')->nullable();
            $table->decimal('rating')->nullable();
            $table->string('poster')->nullable();
            $table->string('banner')->nullable();
            $table->string('imdb')->nullable();
            $table->string('tmdb')->nullable();
            $table->string('type');
            $table->integer('likes')->default(0);
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
        Schema::drop('movies');
    }
}
