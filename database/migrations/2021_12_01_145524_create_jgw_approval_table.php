<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJgwApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_user_id')->comment("작성자 고유 id");
            $table->integer('fk_department_id')->comment("작성 부서 고유 id");
            $table->integer('fk_document_id')->comment("문서 고유 id");
            $table->string('document_no',255)->nullable()->comment("문서번호");
            $table->string('send_type',50)->nullable()->comment("발신종류");
            $table->string('document_life',50)->nullable()->comment("보존년한");
            $table->enum('emergency_type' , ['Y','N'])->default('N')->comment("긴급유무");
            $table->string('agreement_type' , 50)->comment("합의방식");
            $table->string('approval_date',50)->nullable()->comment("기안일자");
            $table->string('title',255)->nullable()->comment("제목");
            $table->text('contents')->nullable()->comment("내용");
            $table->string('status',255)->nullable()->default('임시')->comment("기안상태");
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
        Schema::dropIfExists('approval');
    }
}
