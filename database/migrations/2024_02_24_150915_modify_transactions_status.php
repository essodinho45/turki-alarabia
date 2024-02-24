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
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum(
                'status',
                [
                    'offer',
                    'waiting_manager_approval',
                    'approved_by_manager',
                    'printed',
                    'waiting_turki_approval',
                    'approved_by_turki',
                    'waiting_client_approval',
                    'approved_by_client',
                    'done',
                    'canceled_by_manager',
                    'canceled_by_bank',
                ]
            )
                ->default('offer')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
