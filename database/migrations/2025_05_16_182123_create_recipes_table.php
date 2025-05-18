<?php

declare(strict_types=1);
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->integer('preptime');
            $table->integer('cooktime');
            $table->string('source')->nullable();
            $table->string('image')->nullable();
            $table->float('servings')->nullable();
            $table->string('difficulty');
            $table->string('cuisine')->nullable();
            $table->json('tags')->nullable()->default('[]');
            $table->string('diet')->nullable();
            $table->json('nutrients')->nullable();
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
