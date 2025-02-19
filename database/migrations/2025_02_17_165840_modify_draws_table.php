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
        Schema::table('draws', function (Blueprint $table) {
            $table->dropColumn('balance');
            $table->double('amount', 8, 2)->after('marketer_id');
            $table->enum('transaction_type', ['deposit', 'withdraw'])->after('marketer_id');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending')->after('transaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
