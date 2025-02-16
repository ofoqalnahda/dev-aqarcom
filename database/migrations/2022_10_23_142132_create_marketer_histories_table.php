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
        Schema::create('marketer_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->double('amount' , 8 , 2);
            $table->text('notes');
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
        Schema::dropIfExists('marketer_histories');
    }
};
