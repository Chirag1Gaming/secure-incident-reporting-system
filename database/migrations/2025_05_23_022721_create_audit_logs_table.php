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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action'); // e.g. created, updated, deleted
            $table->string('auditable_type'); // e.g. App\Models\User
            $table->unsignedBigInteger('auditable_id'); // record ID
            $table->json('data')->nullable(); // optional: old/new data
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
        });
    }
};
