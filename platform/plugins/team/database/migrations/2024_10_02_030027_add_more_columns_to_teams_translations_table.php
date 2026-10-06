<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('teams_translations', function (Blueprint $table): void {
            if (! Schema::hasColumn('teams_translations', 'content')) {
                $table->longText('content')->nullable();
            }

            if (! Schema::hasColumn('teams_translations', 'address')) {
                $table->string('address')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams_translations', function (Blueprint $table): void {
            if (Schema::hasColumn('teams_translations', 'content')) {
                $table->dropColumn('content');
            }

            if (Schema::hasColumn('teams_translations', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
};
