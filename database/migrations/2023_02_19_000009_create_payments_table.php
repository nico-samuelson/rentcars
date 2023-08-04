<?php

use App\Models\PaymentMethod;
use App\Models\Rent;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Rent::class)->constrained();
            $table->foreignIdFor(PaymentMethod::class)->constrained();
            $table->string('reference_number')->unique();
            $table->string('card_number');
            $table->integer('nominal');
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
        Schema::dropIfExists('payments');
    }
};
