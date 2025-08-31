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
        Schema::create('cs_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')->nullable()->constrained('cs_trucks')->onDelete('cascade');
            $table->dateTime('kedatangan_truck')->nullable();
            $table->string('nama_customer')->nullable();
            $table->string('area')->nullable();
            $table->integer('urutan_bongkar')->nullable();
            $table->string('no_so')->nullable();
            $table->string('mid')->nullable();
            $table->string('type')->nullable();
            $table->decimal('item_weight', 10, 2)->nullable();
            $table->string('color')->nullable();
            $table->string('pattern_nose')->nullable();
            $table->integer('qty_box_pallet')->nullable();
            $table->integer('qty_pcs')->nullable();
            $table->integer('qty_box')->nullable();
            $table->enum('status_stock', ['Stock Ready', 'On Production'])->default('Stock Ready');
            $table->string('waktu_muat')->nullable();
            $table->decimal('material_weight', 12, 2)->nullable();
            $table->decimal('box_weight', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cs_items');
    }
};
