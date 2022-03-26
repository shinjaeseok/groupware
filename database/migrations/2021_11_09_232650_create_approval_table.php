<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_user_id')->comment('유저 id');
            $table->integer('fk_department_id')->comment('부서 id');
            $table->date('approval_date')->comment('기안일자')->nullable($value = true);
            $table->char('title')->comment('제목')->nullable($value = true);
            $table->longText('contents')->comment('내용')->nullable($value = true);
            $table->char('status')->default('임시')->comment('기안상태');
            $table->enum('is_active',['Y','N'])->default('Y')->comment('활성화여부');
            $table->enum('is_delete',['Y','N'])->default('N')->comment('삭제여부');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'))->nullable($value = true);
            $table->integer('created_user')->nullable($value = true);
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->nullable($value = true);
            $table->integer('updated_user')->nullable($value = true);
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
