<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContentsCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('calendars', function (Blueprint $table) {
            //
            $table->string('contents' , 255)->nullable()->comment("내용")->after('title');
            $table->string('fk_kind_child_id' , 255)->nullable()->comment("캘린더 하위 구분")->after('kind');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('calendars', function (Blueprint $table) {
            $table->dropColumn('contents');
            $table->dropColumn('fk_kind_child_id');
        });
    }
}
