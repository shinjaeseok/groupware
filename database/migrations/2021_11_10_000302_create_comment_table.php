<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->id();
            $table->char('fk_table')->comment('관련 DB 테이블');
            $table->integer('fk_id')->comment('관련 id');
            $table->integer('sort')->comment('순서');
            $table->longText('contents')->comment('내용');
            $table->enum('is_active',['Y','N'])->default('Y')->comment('활성화여부');
            $table->enum('is_delete',['Y','N'])->default('N')->comment('삭제여부');
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
        Schema::dropIfExists('comment');
    }
}
