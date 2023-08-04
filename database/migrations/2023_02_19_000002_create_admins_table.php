<?php

use App\Models\Vendor;
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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class)->constrained();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email');
            $table->string('phone');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // $table->integer('access_lvl');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // access level:
        // 1 -> normal admin -> liat buat dirinya sendiri
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
        Schema::dropIfExists('admins');
    }
};
