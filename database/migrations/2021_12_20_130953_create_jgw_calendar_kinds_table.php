<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJgwCalendarKindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_kinds', function (Blueprint $table) {
            $table->id();
            $table->string('fk_user_id')->nullable()->comment('유저 고유번호');
            $table->string('kind')->comment('캘린더구분');
            $table->string('kind_child_name')->comment('캘린더 하위 이름');
            $table->string('sort')->nullable()->comment('정렬순위');
            $table->string('color')->nullable()->comment('색상');
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
        Schema::dropIfExists('calendar_kinds');
    }
}
