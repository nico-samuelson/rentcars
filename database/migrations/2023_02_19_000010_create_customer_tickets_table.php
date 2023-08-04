<?php

use App\Models\User;
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
        Schema::create('customer_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->text('message');
            $table->boolean('resolved');
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
        Schema::dropIfExists('customer_tickets');
    }
};
