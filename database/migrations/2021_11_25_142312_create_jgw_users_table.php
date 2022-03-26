<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJgwUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code' , 50)->unique()->comment("사원코드");
            $table->string('password' , 255)->comment("비밀번호");
            $table->string('name' , 50)->comment("이름");
            $table->string('phone' , 25)->nullable()->comment("연락처");
            $table->string('email' , 50)->nullable()->comment("이메일");
            $table->enum('manager' , ['Y','N'])->default('N')->comment("관리자여부");
            $table->bigInteger("department_id")->unsigned()->comment("부서 고유번호");
            $table->bigInteger("position_id")->unsigned()->comment("직책 고유번호");
            $table->date("join_date")->comment("입사일");
            $table->date("leave_date")->nullable()->comment("퇴사일");
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_user_code', 50)->nullable()->comment("작성자");
            $table->timestamp('updated_at')->useCurrent();
            $table->string('updated_user_code', 50)->nullable()->comment("수정자");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
