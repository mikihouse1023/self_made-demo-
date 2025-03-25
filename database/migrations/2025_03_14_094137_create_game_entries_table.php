<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('game_entries', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->integer('game_code');
            $table->integer('game_count')->default(0);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('game_entries');
    }
    
};
