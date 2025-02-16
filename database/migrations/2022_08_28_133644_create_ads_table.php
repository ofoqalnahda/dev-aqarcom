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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('neighborhood_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('area_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ad_type_id')->nullable()->constrained('ad_types')->nullOnDelete();
            $table->foreignId('usage_type_id')->nullable()->constrained('usage_types')->nullOnDelete();
            $table->foreignId('estate_type_id')->nullable()->constrained('estate_types')->nullOnDelete();

            $table->enum('main_type' , ['sell' , 'buy']);
            $table->text('description');
            $table->string('address');
            $table->string('location')->nullable();
            $table->decimal('lng', 10, 7)->nullable()->default(0.0);
            $table->decimal('lat', 10, 7)->nullable()->default(0.0);
            $table->double('price' , 10 , 2)->nullable();
            $table->double('min_price' , 10 , 2)->nullable();
            $table->double('max_price' , 10 , 2)->nullable();
            $table->double('area' , 10 , 2)->nullable();
            $table->double('min_area' , 10 , 2)->nullable();
            $table->double('max_area' , 10 , 2)->nullable();
            $table->boolean('special')->default(0);
            $table->boolean('active')->default(1);

            $table->string('mortgage')->nullable();// رهانات
            $table->string('disputes')->nullable();//نزاعات
            $table->string('commitments')->nullable();//التزامات
            $table->string('estate_notes')->nullable();

            $table->foreignId('advertiser_orientation_id')->nullable()->constrained('adv_orientations')->nullOnDelete()->cascadeOnUpdate();
            $table->enum('advertiser_type', ['owner' , 'delegate'])->nullable();

            $table->string('license_number')->nullable();
            $table->string('delegation_number')->nullable();

            $table->string('advertiser_registration_number')->nullable();
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
        Schema::dropIfExists('ads');
    }
};
