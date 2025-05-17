<?php

declare(strict_types=1);
use App\Models\Recipe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipe_instructions', function (Blueprint $table) {
            $table->id();
            $table->integer('position');
            $table->text('content');
            $table->text('image')->nullable();
            $table->foreignIdFor(Recipe::class)->constrained('recipes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_instructions');
    }
};
