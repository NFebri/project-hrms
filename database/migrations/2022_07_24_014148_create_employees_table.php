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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onUpdate('cascade')->onDelete('cascade');
            $table->string('employee_code')->nullable();
            $table->text('address')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->integer('salary')->nullable();
            $table->date('join_date')->nullable();
            $table->date('exit_date')->nullable();
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
        Schema::dropIfExists('employees');
    }
};
