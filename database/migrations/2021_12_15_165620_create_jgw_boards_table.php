<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJgwBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('board_type' , 50)->comment("게시판종류");
            $table->string('title' , 50)->comment("제목");
            $table->longText('contents')->comment("내용");
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
        Schema::dropIfExists('boards');
    }
}
