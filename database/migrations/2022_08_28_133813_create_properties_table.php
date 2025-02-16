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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_type_id')->constrained('ad_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('estate_type_id')->constrained('estate_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('type' , ['slider' , 'switch' , 'multi']);
            $table->json('values_ar')->nullable();
            $table->json('values_en')->nullable();
            $table->integer('min_value')->nullable();
            $table->integer('max_value')->nullable();
            $table->boolean('show_outside')->default(0);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('properties');
    }
};
