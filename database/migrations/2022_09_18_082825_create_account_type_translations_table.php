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
        Schema::create('account_type_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_type_id')->constrained()->onDelete('cascade')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['account_type_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_type_translations');
    }
};
