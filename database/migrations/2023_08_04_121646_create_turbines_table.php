<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turbines', function (Blueprint $table) {
            $table->id();
            $table->string("name", 50);
            $table->string("description", 255);
            $table->string("location", 255);
            $table->foreignId('farm_id')->constrained()->onDelete('cascade');
            $table->date('install_date')->nullable();
            $table->enum('status', config('WindFarmXpert.farm_status'));
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
        Schema::dropIfExists('turbines');
    }
};