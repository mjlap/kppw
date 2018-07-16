<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_target', function (Blueprint $table) {
            $table->increments('target_id')->comment('广告位编号');
            $table->string('name')->nullable()->comment('广告位名称');
            $table->string('code')->nullable()->comment('广告位标签');
            $table->string('description')->nullable()->comment('描述');
            $table->string('targets')->nullable()->comment('广告标签');
            $table->string('position')->nullable()->comment('广告位置');
            $table->string('ad_size')->nullable()->comment('广告位大小');
            $table->integer('ad_num', false)->nullable()->comment('广告位个数');
            $table->string('pic')->nullable()->comment('广告位图片');
            $table->tinyInteger('is_open', false)->nullable()->comment('是否开启   1-开启  2-关闭');
            $table->text('content')->nullable()->comment('内容');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ad_target');
    }
}
