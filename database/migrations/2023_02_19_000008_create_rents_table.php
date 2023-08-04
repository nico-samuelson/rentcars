<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\Vehicle;
use App\Models\Location;
use App\Models\RentStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->foreignIdFor(Vehicle::class)->constrained();
            $table->foreignIdFor(Location::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Admin::class)->constrained();
            $table->foreignIdFor(RentStatus::class)->constrained();
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
            // $table->foreignIdFor('promo_id')->nullable();
            $table->text('notes')->nullable();
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
