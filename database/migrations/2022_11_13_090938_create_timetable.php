<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("timetable", function (Blueprint $table): void {
            $table->id()->autoIncrement();
            $table->integer("specialization_id");
            $table->foreign("specialization_id")->references("id")->on("specializations");
            $table->string("day");
            $table->string("hour");
            $table->string("group");
            $table->string("lecturer");
            $table->string("lesson");
            $table->string("lesson_room");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("timetable");
    }
};
