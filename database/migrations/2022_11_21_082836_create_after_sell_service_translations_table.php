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
        Schema::create('after_sell_service_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('after_sell_services')->onDelete('cascade')->onDelete('cascade');;
            $table->string('locale')->index();
            $table->string('title');
            $table->unique(['service_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('after_sell_service_translations');
    }
};
