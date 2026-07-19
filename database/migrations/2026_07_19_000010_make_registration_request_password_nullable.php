<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registration_requests', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('registration_requests')->whereNull('password')->update(['password' => '']);

        Schema::table('registration_requests', function (Blueprint $table) {
            $table->string('password')->nullable(false)->change();
        });
    }
};
