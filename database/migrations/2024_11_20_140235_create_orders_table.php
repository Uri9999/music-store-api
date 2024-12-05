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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('type')->default(1);
            $table->integer('total_price');
            $table->text('note')->nullable();
            $table->json('meta')->nullable();
            $table->date('approval_date')->nullable();
            $table->integer('approver_id')->nullable();
            $table->integer('canceller_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
