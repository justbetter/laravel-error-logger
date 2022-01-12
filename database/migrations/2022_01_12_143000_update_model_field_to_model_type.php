<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateModelFieldToModelType extends Migration
{
    public function up(): void
    {
        Schema::table('laravel_errors', function (Blueprint $table): void {
            $table->renameColumn('model', 'model_type');
        });
    }

    public function down(): void
    {
        Schema::table('laravel_errors', function (Blueprint $table): void {
            $table->renameColumn('model_type', 'model');
        });
    }
}
