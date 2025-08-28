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
            $table->integer('arrival_number'); // No. Kedatangan (1, 2, 3)
            $table->string('no_truck')->nullable(); // Akan di-update dari Security
            $table->string('loading_dock')->nullable(); // loading dock whouse
            $table->integer('empty_weight'); // Berat Kosong (Kg) → dari Security
            $table->integer('cargo_weight'); // Berat Muatan (Kg) → dari Security
            $table->dateTime('arrival_time')->nullable(); // Waktu Kedatangan →
            $table->integer('total_qty_box'); // Qty Box / pallet (total)
            $table->integer('total_qty_pcs'); // Qty Box / pallet (total)
            $table->integer('total_items_weight'); // Qty Box / pallet (total)
            $table->decimal('total_material_weight', 10, 3); // BERAT TOTAL (Kg) → dari CS
            $table->decimal('total_box_weight', 10, 3); // BERAT box (Kg)
            $table->decimal('total_load_weight', 10, 3); // BERAT ISI TRUCK = total_material_weight
            $table->decimal('min_weight', 10, 3)->storedAs('total_load_weight * 0.96');
            $table->decimal('max_weight', 10, 3)->storedAs('total_load_weight * 1.04');
            $table->decimal('tolerance_weight', 10, 3)->storedAs('max_weight * 1.06');
            $table->decimal('warning_weight', 10, 3)->storedAs('max_weight * 1.10');
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
