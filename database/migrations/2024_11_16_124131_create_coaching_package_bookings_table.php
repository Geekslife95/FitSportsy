<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachingPackageBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coaching_package_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id',155)->nullable();
            $table->string('full_name', 155);
            $table->string('email', 90);
            $table->string('mobile_number', 20);
            $table->string('address', 255)->nullable();
            $table->string('transaction_id',155)->nullable();
            $table->integer('coaching_package_id');
            $table->integer('user_id');
            $table->decimal('actual_amount', 8, 2);
            $table->decimal('paid_amount', 8, 2);
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
        Schema::dropIfExists('coaching_package_bookings');
    }
}
