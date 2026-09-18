<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('diseases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('scientific_name')->nullable();
            $table->text('description');
            $table->text('chemical_treatment');
            $table->text('organic_treatment');
            $table->text('ipm_advice');
            $table->string('severity_level'); // low, medium, high
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('diseases'); }
};