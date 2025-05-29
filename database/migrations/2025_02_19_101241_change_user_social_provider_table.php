<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::table('social_provider_user', function (Blueprint $table): void {
            $table->string('token', 2048)->change();
            $table->string('refresh_token', 2048)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('social_provider_user', function (Blueprint $table): void {
            $table->string('token', 191)->change();
            $table->string('refresh_token', 191)->nullable()->change();
        });
    }
};
