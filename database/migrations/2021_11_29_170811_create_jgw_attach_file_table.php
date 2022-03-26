<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJgwAttachFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attach_files', function (Blueprint $table) {
            $table->id();
            $table->string('fk_table' , 255)->comment('관련 DB 테이블');
            $table->bigInteger('fk_id')->comment('관련 id');
            $table->integer('sort')->comment('정렬순서');
            $table->string('file_extension', 20)->comment('파일 확장자');
            $table->string('file_ori_name', 255)->comment('파일 원본 이름');
            $table->longText('file_path')->comment('저장주소' );
            $table->integer('file_size')->comment('파일용량' );
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
        Schema::dropIfExists('attach_file');
    }
}
