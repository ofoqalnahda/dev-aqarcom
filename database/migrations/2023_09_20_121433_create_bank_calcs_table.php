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
        Schema::create('bank_calcs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->string('national_id');
            $table->date('birth_date');
            $table->float('salary');
            $table->string('contact_number');
            $table->enum('job',['مدني','قطاع خاص','عسكري','متقاعد']);
            $table->string('job_name');
            $table->string('financial_obligations');
            $table->string("bank_name");
            $table->boolean("gov_supported");
            $table->string('result')->nullable();
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
        Schema::dropIfExists('bank_calcs');
    }
};
