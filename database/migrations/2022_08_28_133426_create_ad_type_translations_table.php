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
        Schema::create('ad_type_translations', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('ad_type_id')->constrained('ad_types')->onDelete('cascade')->onDelete('cascade');;
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['ad_type_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_type_translations');
    }
};
