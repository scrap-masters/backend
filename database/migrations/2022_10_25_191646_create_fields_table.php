<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("fields", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->integer("faculty_id");
            $table->foreign("faculty_id")->references("id")->on("faculties");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("fields");
    }
};
