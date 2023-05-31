<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->string('rent_number')->unique();
            $table->foreignId('vehicle_id');
            $table->foreignId('location_id');
            $table->foreignId('user_id');
            $table->foreignId('admin_id');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('total_price');
            $table->string('renter_name');
            $table->string('renter_email');
            $table->string('renter_phone');
            $table->string('driver_name');
            $table->string('driver_email');
            $table->string('driver_phone');
            $table->string('driver_identity');
            $table->string('driver_license');
            $table->foreignId('promo_id')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('status_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rents');
    }
};
