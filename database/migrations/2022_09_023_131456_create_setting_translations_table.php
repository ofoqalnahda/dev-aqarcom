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
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->constrained()->onDelete('cascade')->onDelete('cascade');
            $table->string('locale')->index();

            $table->text('about_us')->nullable();
            $table->text('our_vision')->nullable();
            $table->text('our_message')->nullable();

            $table->text('terms')->nullable();
            $table->text('privacy')->nullable();
            $table->text('description')->nullable();

            $table->text('agreement')->nullable();
            $table->text('ad_conditions')->nullable();
            $table->text('app_commission')->nullable();
            $table->text('idea_policy')->nullable();

            $table->unique(['setting_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_translations');
    }
};
