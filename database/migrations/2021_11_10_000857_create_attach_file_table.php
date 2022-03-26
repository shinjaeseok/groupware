<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attach_file', function (Blueprint $table) {
            $table->id();
            $table->char('fk_table')->comment('관련 DB 테이블');
            $table->integer('fk_id')->comment('관련 id');
            $table->integer('sort')->comment('순서');
            $table->char('file_extension')->comment('확장자');
            $table->char('file_ori_name')->comment('원본 파일명');
            $table->char('file_path')->comment('저장주소');
            $table->integer('file_size')->comment('파일용량');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'))->nullable($value = true);
            $table->char('created_user')->nullable($value = true);
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->nullable($value = true);
            $table->char('updated_user')->nullable($value = true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attach_file');
    }
}
