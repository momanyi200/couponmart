<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE wallet_transactions 
            MODIFY COLUMN type 
            ENUM(
                'deposit',
                'withdrawal',
                'payment',
                'order_payment',
                'seller_earning',
                'system_commission'
            ) 
            NOT NULL
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE wallet_transactions 
            MODIFY COLUMN type 
            ENUM('deposit', 'withdrawal', 'payment') 
            NOT NULL
        ");
    }
};
