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
        Schema::create('estate_developer_service_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('estate_developer_services')->onDelete('cascade')->onDelete('cascade');;
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
        Schema::dropIfExists('estate_developer_service_translations');
    }
};
