<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('seed_id')->nullable()->constrained()->onDelete('set null');
            $table->string('seed_name');
            $table->date('sowing_date');
            $table->date('harvest_date');
            $table->integer('maturity_days');
            $table->boolean('task1_done')->default(false);
            $table->boolean('task2_done')->default(false);
            $table->boolean('task3_done')->default(false);
            $table->boolean('task4_done')->default(false);
            $table->boolean('task5_done')->default(false);
            $table->boolean('task6_done')->default(false);
            $table->boolean('task7_done')->default(false);
            $table->boolean('task8_done')->default(false);
            $table->boolean('task9_done')->default(false);
            $table->boolean('task10_done')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('crops');
    }
};