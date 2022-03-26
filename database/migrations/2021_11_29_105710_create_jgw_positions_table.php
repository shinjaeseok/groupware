<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJgwPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('position',25)->comment('직책');
            $table->integer('position_grade')->comment('직책등급');
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
        Schema::dropIfExists('positions');
    }
}
