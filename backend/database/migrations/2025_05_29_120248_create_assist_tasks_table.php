<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistTasksTable extends Migration
{
    public function up(): void
    {
        Schema::create('assist_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('subject');
            $table->string('type');
            $table->string('assigned_to');
            $table->date('due_date');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assist_tasks');
    }
}
