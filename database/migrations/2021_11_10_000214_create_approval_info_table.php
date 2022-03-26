<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_info', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_approval_id')->comment('기안 id');
            $table->char('approval_no')->comment('문서번호');
            $table->char('send_type')->comment('발신종류');
            $table->char('emergency_type')->default('N')->comment('긴급유무');
            $table->integer('document_life')->default('0')->comment('보존기한');
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
        Schema::dropIfExists('approval_info');
    }
}
