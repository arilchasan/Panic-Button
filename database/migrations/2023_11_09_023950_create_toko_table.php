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
        Schema::create('toko', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->bigInteger('province_id');
            $table->bigInteger('regencies_id');
            $table->bigInteger('district_id');
            $table->bigInteger('village_id');
            $table->decimal('latitude', 10 , 8);
            $table->decimal('longitude', 11, 8);
            $table->bigInteger('subsription_id');
            $table->bigInteger('user_id');
            $table->enum('status', ['online', 'offline']);
            $table->string('key');
            $table->enum('status_active', ['true', 'false']);
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
        Schema::dropIfExists('toko');
    }
};
