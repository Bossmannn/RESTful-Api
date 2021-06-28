<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsManagementTable extends Migration
{
    public function up()
    {
        Schema::create('assets_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('assignment_date');
            $table->string('status');
            $table->boolean('is_due')->default( false );
            $table->date('due_date');
            $table->string('assigned_by');
            $table->timestamps();
        });
    }

   
    public function down() {

        Schema::dropIfExists('assets_management');
    }
}
