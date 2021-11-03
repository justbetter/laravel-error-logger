<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLaravelErrorsTableDetailsField extends Migration
{
    public function up(): void
    {
        Schema::table('laravel_errors', function (Blueprint $table): void {
            $table->text('details')->after('message')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('laravel_errors', function (Blueprint $table): void {
            $table->dropColumn('details');
        });
    }
}
