<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropUnique('sales_order_code_unique'); // UNIQUE 制約を削除
        });
    }

    public function down() {
        Schema::table('sales', function (Blueprint $table) {
            $table->unique('order_code'); // 元に戻す場合
        });
    }
};
