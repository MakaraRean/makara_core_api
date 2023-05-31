<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('note',1000)->nullable();
            $table->unsignedBigInteger('debtor_id');
            $table->foreign('debtor_id')
                ->references('id')
                ->on('debtors')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debts');
    }
};
