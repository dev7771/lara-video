<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
       
        Schema::create('videos', function (Blueprint $table) {
           
            $table->increments('id')->index()->unsigned();
            $table->date('date')->nullable();
            $table->char('image')->nullable();
            $table->char('link')->nullable();
            $table->char('video')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('ordering')->default(0);
            $table->timestamps();

        });


       Schema::create('video_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('video_id')->unsigned();
            $table->text('title')->nullable();
            $table->string('locale')->index();

            $table->unique(['video_id', 'locale']);
            $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_translations');
        Schema::dropIfExists('videos');
    }
}
