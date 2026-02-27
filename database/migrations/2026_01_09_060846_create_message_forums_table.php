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
        Schema::create('message_forums', function (Blueprint $table) {
            $table->id();
            $table->string('message')->nullable();
            $table->foreignId('forum_id')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable();
            $table->enum('message_type', ['text', 'poll'])->nullable()->default('text');
            $table->foreignId('messages_id')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('message_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->cascadeOnDelete();
            $table->string('name');
            $table->string('file');
            $table->double('size', 15, 8);
            $table->timestamps();
        });
        
        Schema::create('poll_options', function (Blueprint $table) {
            $table->id();
            $table->string('option');
            $table->foreignId('messages_id')->cascadeOnDelete();
            $table->timestamps();
            });
            
        Schema::create('poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_id');
            $table->foreignId('user_id');
            $table->enum('message_type', ['text', 'poll'])->nullable()->default('text');
            $table->foreignId('messages_id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages_forum');
    }
};
