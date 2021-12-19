<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_loan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('loan_type_id')->nullable();
            $table->text('total_amount')->nullable();
            $table->integer('installment_count')->comment('tedade ghest')->nullable();
            $table->text('installment_amount')->comment('mablaghe har ghest')->nullable();
            $table->timestamp('first_installment_received_at')->comment('tarikhe avalin ghest')->nullable();
            $table->timestamp('loan_paid_to_user_at')->comment('tarikhe pardakhte vam be karbar')->nullable();
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
        Schema::dropIfExists('user_loan');
    }
}
