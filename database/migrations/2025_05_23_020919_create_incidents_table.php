<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->enum('priority', ['Low', 'Medium', 'High']);
            $table->enum('status', ['Open', 'In Progress', 'Resolved'])->default('Open');
            $table->timestamp('resolved_at')->nullable();
            $table->string('evidence_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
