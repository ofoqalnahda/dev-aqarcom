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
        Schema::create('estate_type_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estate_type_id')->constrained('estate_types')->onDelete('cascade')->onDelete('cascade');;
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['estate_type_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estate_type_translations');
    }
};
