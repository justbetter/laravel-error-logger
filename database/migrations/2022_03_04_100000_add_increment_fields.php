<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIncrementFields extends Migration
{
    public function up(): void
    {
        Schema::table('laravel_errors', function (Blueprint $table): void {
            $table->integer('count')->default(1)->after('channel');
            $table->boolean('show_on_index')->default(true)->after('count');
        });
    }

    public function down(): void
    {
        Schema::table('laravel_errors', function (Blueprint $table): void {
            $table->dropColumn('count', 'show_on_index');
        });
    }
}
