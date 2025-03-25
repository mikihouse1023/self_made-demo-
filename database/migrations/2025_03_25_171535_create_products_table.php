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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);          // 商品名
            $table->string('val', 10);           // 値段（必要に応じて integer や decimal に変更）
            $table->text('explanation');         // 商品説明
            $table->string('picture', 255);      // 商品写真
            $table->string('category', 15);      // 商品区分（定食・丼・麺・サイドメニュー など）
            $table->timestamps();                // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
