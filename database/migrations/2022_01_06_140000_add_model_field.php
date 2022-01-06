<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModelField extends Migration
{
    public function up(): void
    {
        Schema::table('laravel_errors', function (Blueprint $table): void {
            $table->string('model')->after('group')->nullable();
            $table->unsignedBigInteger('model_id')->after('model')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('laravel_errors', function (Blueprint $table): void {
            $table->dropColumn('model');
            $table->dropColumn('model_id');
        });
    }
}
