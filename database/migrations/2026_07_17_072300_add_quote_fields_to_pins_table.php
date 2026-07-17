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
        Schema::table('pins', function (Blueprint $table) {
            $table->string('type')->default('photo')->after('category'); // 'photo' or 'quote'
            $table->text('quote_text')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pins', function (Blueprint $table) {
            $table->dropColum(['type', 'quote_text']);
        });
    }
};
