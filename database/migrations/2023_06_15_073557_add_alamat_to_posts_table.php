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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image_name')->nullable();
            $table->string('regency')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('postal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('image_name');
            $table->dropColumn('regency');
            $table->dropColumn('district');
            $table->dropColumn('village');
            $table->dropColumn('postal');
        });
    }
};
