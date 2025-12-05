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
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete();
            $table->integer('code')->nullable();
            $table->integer('status')->default(1);
            $table->enum('payment_method' , ['cash'  , 'visa' ])->nullable();
            $table->timestamp('date_order')->nullable(); // 'تم الطلب'
            $table->timestamp('date_progress')->nullable();  // 'جاري المعالجه'
            $table->timestamp('date_processing')->nullable();  // 'جاري التنفيذ'
            $table->timestamp('date_done')->nullable();  // 'تم التنفيذ'
            $table->timestamp('date_delivery')->nullable();  // 'جاري التوصيل'
            $table->timestamp('date_complete')->nullable();  //  'مكتمل'
            $table->timestamp('date_canceled')->nullable();  //  'مكتمل'
            $table->enum('type' , ['cart' , 'order']);
            $table->decimal('cost' , 8 , 2)->nullable();
            $table->decimal('total_discount' , 8 , 2)->nullable();
            $table->decimal('shipping_tax' , 8 , 2)->default(0.0);
            $table->decimal('total' , 8 , 2)->nullable();
            $table->enum('Payment' , ['paid' , 'unpaid'])->default('unpaid');
            $table->string('coupon')->nullable();
            $table->string('address')->nullable();
            $table->string('addres_details')->nullable();
            $table->timestamps();
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
