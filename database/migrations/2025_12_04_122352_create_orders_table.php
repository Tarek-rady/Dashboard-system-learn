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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->index();
            $table->foreignId('vendor_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('status')->default(1)->index();
            $table->string('code')->nullable()->index();
            $table->integer('payment')->default();
            $table->timestamp('date_requested')->nullable();
            $table->timestamp('date_accepted')->nullable();
            $table->timestamp('date_completed')->nullable();
            $table->timestamp('date_implementation')->nullable();
            $table->timestamp('date_cancled')->nullable();
            $table->decimal('cost' , 8 , 2)->default(0);
            $table->decimal('total_discount' , 8 , 2)->nullable();
            $table->decimal('tax' , 8 , 2)->default(0);
            $table->decimal('total' , 8 , 2)->default(0);
            $table->string('coupon')->nullable();
            $table->longText('msg')->nullable();
            $table->boolean('read')->default(0);
            $table->integer('time_type')->default(1)->index();
            $table->integer('res_type')->default(1)->index();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();


            $table->index(['status', 'created_at']);
            $table->index(['time_type', 'res_type', 'created_at']);
            $table->index(['user_id' , 'created_at']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
