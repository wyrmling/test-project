<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_countries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->unique();
            $table->string('country_name');
            $table->smallInteger('country_code');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_countries');
    }
};
