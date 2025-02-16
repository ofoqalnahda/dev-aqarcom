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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string("code")->unique();
            $table->enum("type", ["fixed", "percent"]);
            $table->integer("value");
            $table->date("expire_date")->nullable();
            $table->boolean("is_active")->default(true);
            $table->foreignId("user_id")->nullable()->constrained("users")->nullOnDelete();
//            $table->string("usage_limit")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
