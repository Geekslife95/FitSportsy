<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->string('venue_name',255);
            $table->string('venue_area',255);
            $table->string('venue_address',255);
            $table->string('venue_city',255);
            $table->string('sports_available',500);
            $table->string('ameneties',500);
            $table->text('description');
            $table->string('poster_image',255);
            $table->string('gallery_images',1500);
            $table->integer('created_by');
            $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('courts');
    }
}
