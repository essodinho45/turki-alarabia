<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->double('amount');
            $table->foreignId('material_id')->constrained(
                table: 'materials', indexName: 'transactions_material_id'
            );
            $table->double('quantity');
            $table->string('client_name');
            $table->string('client_national_id');
            $table->string('client_phone');
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'transactions_user_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
