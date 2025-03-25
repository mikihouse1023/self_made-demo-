<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     *  @return void
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->date('date'); // 日付
            $table->string('category'); // カテゴリ
            $table->boolean('is_new')->default(true); // NEWフラグ（デフォルトでtrue）
            $table->string('title'); // タイトル
            $table->text('description')->nullable(); // 詳細説明（オプション）
            $table->timestamps(); // 作成日時と更新日時
        });
    }

    /**
     * Reverse the migrations.
     * 
     *  @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
