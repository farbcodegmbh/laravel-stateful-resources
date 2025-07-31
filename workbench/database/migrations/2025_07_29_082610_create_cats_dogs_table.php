<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Workbench\App\Models\Cat;
use Workbench\App\Models\Dog;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cats_dogs', function (Blueprint $table) {
            $table->foreignIdFor(Cat::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Dog::class)->constrained()->cascadeOnDelete();
            $table->primary(['cat_id', 'dog_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cats_dogs');
    }
};
