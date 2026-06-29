<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('title');           // Название: MAN TGS 26.440
            $table->string('brand');           // MAN, КАМАЗ, Volvo...
            $table->integer('year');
            $table->decimal('price', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('load_capacity')->nullable(); // Грузоподъёмность
            $table->string('body_type')->nullable();     // Самосвал, фура...
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
