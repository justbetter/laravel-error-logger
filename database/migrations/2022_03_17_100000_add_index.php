<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laravel_errors', function (Blueprint $table): void {
            $table->index(['updated_at']);
        });
    }

    public function down(): void
    {
        Schema::table('laravel_errors', function (Blueprint $table): void {
            $table->dropIndex(['updated_at']);
        });
    }
};
