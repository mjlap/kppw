<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id')->comment('文章编号');
            $table->integer('cat_id', false)->default(0)->comment('分类编号');
            $table->integer('user_id', false)->default(0)->comment('用户编号');
            $table->string('user_name',255)->nullable()->comment('用户名');
            $table->string('title',255)->comment('标题');
            $table->string('author',32)->nullable()->comment('作者');
            $table->string('from',255)->nullable()->comment('来源');
            $table->string('fromurl',255)->nullable()->comment('来源地址');
            $table->string('url',255)->nullable()->comment('文章地址');
            $table->string('summary',255)->nullable()->comment('简介');
            $table->string('pic',255)->nullable()->comment('新闻列表图片');
            $table->tinyInteger('thumb',false)->default(0);
            $table->tinyInteger('tag', false)->default(0);
            $table->tinyInteger('status', false)->default(0);
            $table->longText('content')->nullable()->comment('文字内容');
            $table->integer('view_times', false)->nullable()->comment('文章阅读浏览次数');
            $table->string('seotitle',255)->nullable()->comment('SEO标题');
            $table->string('keywords',255)->nullable()->comment('SEO关键词');
            $table->string('description',255)->nullable()->comment('SEO描述');
            $table->integer('display_order', false)->nullable()->comment('排序');
            $table->tinyInteger('is_recommended', false)->nullable()->comment('是否推荐 1->是 2->否');
            $table->timestamp('created_at', false)->nullable()->comment('添加时间');
            $table->timestamp('updated_at', false)->nullable()->comment('修改时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article');
    }
}
