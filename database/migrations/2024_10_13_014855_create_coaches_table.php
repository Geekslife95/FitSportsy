<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->string('coaching_title',255);
            $table->integer('category_id');
            $table->string('age_group',20);
            $table->string('free_demo_session',10);
            $table->string('skill_level',255);
            $table->string('bring_own_equipment',10);
            $table->string('venue_name',255);
            $table->string('venue_area',255);
            $table->string('venue_address',255);
            $table->string('venue_city',255);
            $table->string('sports_available',500)->nullable();
            $table->string('ameneties',500)->nullable();
            $table->text('description')->nullable();
            $table->string('poster_image',255)->nullable();
            $table->string('description_image',255)->nullable();
            $table->string('coaches_info',1500)->nullable();
            $table->integer('organiser_id');
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
        Schema::dropIfExists('coaches');
    }
}
