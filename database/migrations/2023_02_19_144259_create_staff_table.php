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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->foreignId('department_id');
            $table->string('position');
            $table->integer('salary');
            $table->string('email');
            $table->string('phone');
            $table->date('birthdate');
            $table->string('address');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('location_id');
            $table->boolean('access_lvl');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // access level:
        // 1 -> normal staff -> liat buat dirinya sendiri
        // 2 -> HRD -> liat buat semua pegawai di lokasi yg sama
        // 2 -> supervisor/ manager/ head of department/ branch head -> liat buat semua anggota di departemen & lokasi yg sama
        // 3 -> director/ owner/ comissioner -> liat semua
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
};
