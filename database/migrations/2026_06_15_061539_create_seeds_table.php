<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('seeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // BG 352
            $table->string('district');      // Gampaha
            $table->string('season');        // Yala / Maha / Both
            $table->integer('maturity_days');
            $table->decimal('yield_per_ha', 4, 1);
            $table->string('blast_resistance'); // High / Medium / Low
            $table->text('description')->nullable();
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('seeds'); }
};