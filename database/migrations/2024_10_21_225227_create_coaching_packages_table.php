<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachingPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coaching_packages', function (Blueprint $table) {
            $table->id();
            $table->integer('coach_id')->index();
            $table->string('package_name',155);
            $table->string('batch_size',20);
            $table->decimal('package_price',8,2)->index();
            $table->string('discount_percent',10);
            $table->tinyInteger('platform_fee_pay_by');
            $table->tinyInteger('gateway_fee_pay_by');
            $table->string('description',1500);
            $table->time('session_start_time');
            $table->time('session_end_time');
            $table->string('session_days',255);
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
        Schema::dropIfExists('coaching_packages');
    }
}
