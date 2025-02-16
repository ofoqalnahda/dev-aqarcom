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
        Schema::create('neighborhood_translations', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('neighborhood_id')->constrained()->onDelete('cascade')->onDelete('cascade');;
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['neighborhood_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('neighborhood_translations');
    }
};
