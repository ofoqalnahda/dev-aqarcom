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
        Schema::create('adv_orientation_translations', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('adv_orientation_id')->constrained('adv_orientations')->onDelete('cascade')->onDelete('cascade');;
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['adv_orientation_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adv_orientation_translations');
    }
};
