<?php

// database/migrations/2025_07_02_150001_create_category_parents_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_parents', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('categories')->onDelete('cascade');
            $table->primary(['category_id', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_parents');
    }
};
