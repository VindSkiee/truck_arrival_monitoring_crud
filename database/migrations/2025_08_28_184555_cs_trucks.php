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
        Schema::create('cs_trucks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('arrival_date')->nullable(); // Tanggal Kedatangan
            $table->integer('arrival_number'); // No. Kedatangan (1, 2, 3)
            $table->string('no_truck')->nullable(); // Akan di-update dari Security
            $table->string('loading_dock')->nullable(); // loading dock whouse

            // input dari Security
            $table->integer('empty_weight')->nullable(); // Berat Kosong (Kg)
            $table->integer('cargo_weight')->nullable(); // Berat Muatan (Kg)
            $table->dateTime('arrival_time')->nullable(); // Waktu Kedatangan

            // hasil sum dari cs_items
            $table->integer('total_qty_box')->nullable();
            $table->integer('total_qty_pcs')->nullable();
            $table->integer('total_items_weight')->nullable();

            $table->decimal('total_material_weight', 12, 3)->nullable(); // BERAT TOTAL (Kg)
            $table->decimal('total_box_weight', 12, 3)->nullable(); // BERAT box (Kg)
            $table->decimal('total_load_weight', 12, 3)->nullable(); // BERAT ISI TRUCK = total_material_weight

            // computed column masih bisa nullable, tapi otomatis terisi ketika total_load_weight ada
            $table->decimal('min_weight', 12, 3)->nullable()->storedAs('total_load_weight * 0.96');
            $table->decimal('max_weight', 12, 3)->nullable()->storedAs('total_load_weight * 1.04');
            $table->decimal('tolerance_weight', 12, 3)->nullable()->storedAs('max_weight * 1.06');
            $table->decimal('warning_weight', 12, 3)->nullable()->storedAs('max_weight * 1.10');

            $table->enum('status_process', ['loading', 'finish'])->default('loading');
            $table->enum('status_security', ['periksa', 'pass'])->default('periksa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cs_trucks');
    }
};
