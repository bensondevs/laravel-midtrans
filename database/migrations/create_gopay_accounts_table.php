<?php

use Bensondevs\Midtrans\Enums\Gopay\GopayStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gopay_accounts', function (Blueprint $table): void {
            $table->id();
            $table->morphs('holder');
            $table->string('account_id');
            $table->char('status')->default(GopayStatus::PENDING);
            $table->boolean('is_main')->default(false);
            $table->string('default_payment_option')->default('GOPAY_WALLET');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
