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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('whatsapp')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('code');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->boolean('receive_notification')->default(true);
            $table->boolean('receive_messages')->default(true);
            $table->integer('free_ads')->unsigned()->default(0);
            $table->string('device_token')->nullable();
            $table->timestamp('last_login')->nullable();

            //for authenticated users only
            $table->boolean('is_authentic')->default(0);
            $table->boolean('pending_authentication')->default(0);
            $table->foreignId('account_type_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('payment_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('identity_owner_name')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('commercial_owner_name')->nullable();
            $table->string('commercial_name')->nullable();
            $table->string('commercial_number')->nullable();
            $table->string('commercial_image')->nullable();
            $table->string('identity_image')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
