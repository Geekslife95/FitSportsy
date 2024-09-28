<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_u_id');
            $table->integer('app_user_id');
            $table->string('pay_type',20);
            $table->text('shipping_details');
            $table->string('payment_id');
            $table->decimal('total_paid',8,2);
            $table->decimal('delivery_charge',8,2);
            $table->enum('payment_status',['Pending','Paid']);
            $table->enum('status',['Pending','Shipped','Delivered']);
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
        Schema::dropIfExists('product_orders');
    }
}
