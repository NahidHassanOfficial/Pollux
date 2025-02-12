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
        Schema::create('poll_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id');
            $table->string('reporter_ip');
            $table->string('reason');
            $table->text('description');
            $table->boolean('restrict_poll')->default(false);
            $table->enum('report_status', ['pending', 'resolved'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->foreignId('superuser_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poll_reports');
    }
};