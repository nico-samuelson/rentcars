<?php

use App\Models\Vendor;
use App\Models\VehicleModel;
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
        Schema::create('vendor_vehicle_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class)->constrained();
            $table->foreignIdFor(VehicleModel::class)->constrained();
            $table->integer('daily_rate');
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
        Schema::dropIfExists('vendor_vehicle_rates');
    }
};
