<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("specializations", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->string("slug");
            $table->integer("field_id");
            $table->foreign("field_id")->references("id")->on("fields");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("specializations");
    }
};
