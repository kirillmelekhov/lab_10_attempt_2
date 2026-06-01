<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_classes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('creative_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('leader_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->date('session_date');
            $table->time('slot_time');
            $table->unsignedInteger('max_participants');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->unique(['leader_id', 'session_date', 'slot_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_classes');
    }
};
