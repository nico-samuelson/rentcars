<?php

use App\Models\VehicleModel;
use App\Models\Vendor;
use App\Models\Location;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class)->constrained();
            $table->foreignIdFor(Location::class)->constrained();
            $table->foreignIdFor(VehicleModel::class)->constrained();
            $table->string('license_plate');
            $table->integer('year');
            $table->string('transmission');
            $table->boolean('is_available');
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
        Schema::dropIfExists('vehicles');
    }
};
