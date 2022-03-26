<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJgwApprovalLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_approval_id')->comment("기안 고유 id");
            $table->integer('fk_user_id')->comment("사원 고유 id");
            $table->string('sort',50)->comment("순서");
            $table->string('approval_type', 50)->comment("결재방법");
            $table->string('approval_status', 50)->default('대기')->comment("결재상태(대기, 가능, 완료)");
            $table->string('approval_result', 50)->default('대기')->comment("결재결과(대기, 승인, 반려)");
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
        Schema::dropIfExists('approval_lines');
    }
}
