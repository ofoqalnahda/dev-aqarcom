<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('marketers', function (Blueprint $table) {
            $table->double('target_count')->default(0)->after('commission_percentage');
            $table->double('commission_target')->default(0)->after('target_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marketers', function (Blueprint $table) {
            //
        });
    }
};
