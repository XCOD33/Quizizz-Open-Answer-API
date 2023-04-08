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
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('api_key', 64)->unique();
            $table->integer('max_hit')->default(20);
            $table->integer('hit_count')->default(0);
            $table->timestamps();
            $table->date('last_reset_date');
            $table->dropColumn('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_keys');

        // Schema::table('games', function (Blueprint $table) {
        //     $table->dropForeign('api_keys_id');
        // });

        // Schema::table('api_keys', function (Blueprint $table) {
        //     $table->dropColumn('updated_at');
        // });
    }
};
