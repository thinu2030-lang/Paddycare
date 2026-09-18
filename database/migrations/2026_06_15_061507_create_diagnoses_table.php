<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('disease_id')->nullable()->constrained()->onDelete('set null');
            $table->string('image_path');
            $table->decimal('confidence', 5, 2)->nullable(); // 94.50
            $table->string('status')->default('pending'); // pending, reviewed
            $table->text('officer_note')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('diagnoses'); }
};