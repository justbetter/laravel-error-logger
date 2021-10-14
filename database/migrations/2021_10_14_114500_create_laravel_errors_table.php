<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaravelErrorsTable extends Migration
{
    public function up(): void
    {
        Schema::create('laravel_errors', function (Blueprint $table): void {
            $table->id();
            $table->string('group')->nullable();
            $table->text('message')->nullable();
            $table->text('trace')->nullable();
            $table->text('vendor_trace')->nullable();
            $table->string('channel')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laravel_errors');
    }
}
