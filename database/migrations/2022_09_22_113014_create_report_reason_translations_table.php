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
        Schema::create('report_reason_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_reason_id')->constrained('report_reasons')->onDelete('cascade')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('reason');
            $table->unique(['report_reason_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_reason_translations');
    }
};
