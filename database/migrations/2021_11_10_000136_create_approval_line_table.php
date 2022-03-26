<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_line', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_approval_id')->comment('기안 id');
            $table->integer('fk_user_id')->comment('유저 id');
            $table->integer('sort')->comment('순서');
            $table->char('approval_type')->comment('결재구분');
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
        Schema::dropIfExists('approval_line');
    }
}
