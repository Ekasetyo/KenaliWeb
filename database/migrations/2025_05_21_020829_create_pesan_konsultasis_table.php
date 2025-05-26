<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('consultation_messages', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('consultation_id');
        $table->enum('sender', ['user', 'admin']);
        $table->text('message');
        $table->timestamps();

        $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('cascade');
    });
}

};
