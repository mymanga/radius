<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailConversationsTable extends Migration
{
    public function up()
    {
        Schema::create('email_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('subject');
            $table->text('body');
            $table->string('priority')->default('normal');
            $table->string('status')->default('new');
            $table->string('thread_id')->nullable();
            $table->string('mail_id')->unique();
            $table->string('ticket_number')->unique()->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_conversations');
    }
}

