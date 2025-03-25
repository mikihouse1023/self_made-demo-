<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // ユーザーに紐づけ (未登録ユーザーは null)
            $table->string('code')->unique(); // クーポンコード
            $table->string('discount_type'); // 割引タイプ ('percentage' または 'fixed')
            $table->decimal('discount_value', 8, 2); // 割引額またはパーセンテージ
            $table->timestamp('expires_at')->nullable(); // 有効期限
            $table->boolean('used')->default(false); // 使用済みフラグ
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('coupons');
    }
};
