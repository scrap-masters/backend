<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table("timetable", function (Blueprint $table): void {
            $table->index("lecturer");
        });
        Schema::table("fields", function (Blueprint $table): void {
            $table->index("name");
            $table->index("faculty_id");
        });
        Schema::table("specializations", function (Blueprint $table): void {
            $table->index("slug");
            $table->index("field_id");
        });
    }

    public function down(): void
    {
        Schema::table("timetable", function (Blueprint $table): void {
            $table->dropIndex(["lecturer"]);
        });
        Schema::table("fields", function (Blueprint $table): void {
            $table->dropIndex(["name", "faculty_id"]);
        });
        Schema::table("specializations", function (Blueprint $table): void {
            $table->dropIndex(["slug", "field_id"]);
        });
    }
};
