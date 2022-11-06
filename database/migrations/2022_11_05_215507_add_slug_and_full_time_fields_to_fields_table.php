<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table("fields", function (Blueprint $table): void {
            $table->string("slug")->unique();
            $table->boolean("is_full_time");
        });
    }

    public function down(): void
    {
        Schema::table("fields", function (Blueprint $table): void {
            $table->dropColumn("slug");
            $table->dropColumn("is_full_time");
        });
    }
};
