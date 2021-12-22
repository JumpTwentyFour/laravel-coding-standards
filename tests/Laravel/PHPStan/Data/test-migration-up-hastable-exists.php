<?php

namespace Tests\Laravel\PHPStan\Data;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestMigrationUpHasTableExists extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('test')) {
            return;
        }

        Schema::create('test', function (Blueprint $table) {
            $table->increments('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test');
    }
}
