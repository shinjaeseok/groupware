<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department', function (Blueprint $table) {
            $table->id();
            $table->integer('sort')->comment('정렬순서');
            $table->integer('parent_id')->comment('부모 id');
            $table->char('title')->comment('부서명');
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
        Schema::dropIfExists('department');
    }
}
