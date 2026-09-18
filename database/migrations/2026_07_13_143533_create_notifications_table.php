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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // Notification එකක් යවපු officer ව track කරන්න (foreign key)
            $table->foreignId('sent_by')->constrained('users')->onDelete('cascade');
            $table->string('district');
            $table->string('type'); // fertilizer, meeting, disease_alert, general
            $table->string('subject');
            $table->text('message');
            $table->integer('recipients_count')->default(0); // කී දෙනෙක්ට email ගියාද කියලා බලාගන්න
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};