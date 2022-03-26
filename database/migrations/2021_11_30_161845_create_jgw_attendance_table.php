<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJgwAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id")->unsigned()->comment("사원 id");
            $table->bigInteger("approval_user_id")->unsigned()->nullable()->comment("승인자 사원 id");
            $table->date("work_date")->comment("근무일자");
            $table->time('work_start_time')->nullable()->comment("출근시간(수정요청전)");
            $table->time('work_end_time')->nullable()->comment("퇴근시간(수정요청전)");
            $table->time('work_start_time_after')->nullable()->comment("출근시간(수정요청후)");
            $table->time('work_end_time_after')->nullable()->comment("퇴근시간(수정요청후)");
            $table->enum('status', ['완료', '미처리', '승인', '반려'])->default('완료')->comment("수정요청 상태");
            $table->text("reason")->nullable()->comment("사유");
            $table->text("answer")->nullable()->comment("답변");
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
        Schema::dropIfExists('attendance');
    }
}
