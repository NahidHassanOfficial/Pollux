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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->uuid('poll_uid')->unique()->index();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('description');
            $table->boolean('allow_multiple');
            $table->boolean('public_visibility')->default(true);
            $table->enum('status', ['active', 'inactive', 'restricted'])->default('active');
            $table->integer('total_visitor')->default(0);
            $table->integer('total_vote')->default(0);
            $table->dateTime('expire_at'); //used datetime to avoid ON UPDATE CURRENT_TIMESTAMP(), or we can use timestamp with nullable to avoid this issue.
            $table->string('signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
