<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    public function up() {

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('type');
            $table->string('serial_no');
            $table->string('description');
            $table->enum('fixed_or_movable', ['fixed', 'movable']);
            $table->string('picture_path');
            $table->date('purchase_date');
            $table->date('start_use_date');
            $table->decimal('purchase_price', 10, 2);
            $table->date('warranty_expiry_date');
            $table->string('degradation');
            $table->decimal('current_value', 10, 2);
            $table->string('location');
            $table->timestamps();
        });
    }

    
    public function down() {

        Schema::dropIfExists('assets');
    }
}
