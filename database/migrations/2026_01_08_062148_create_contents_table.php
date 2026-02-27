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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('desc');
            $table->foreignId('user_id')->nullOnDelete();
            $table->integer('views')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::create('content_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->foreignId('content_id')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('content_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->onDelete('cascade');
            $table->string('ip_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
        Schema::dropIfExists('content_attachments');
        Schema::dropIfExists('content_views');
    }
};
