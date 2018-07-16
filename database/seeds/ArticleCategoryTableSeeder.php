<?php

use Illuminate\Database\Seeder;

class ArticleCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('article_category')->delete();
        
        \DB::table('article_category')->insert(array (
            0 => 
            array (
                'id' => 1,
                'pid' => 0,
                'cate_name' => '资讯中心',
                'articles' => 0,
                'display_order' => 0,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '1',
                'seotitle' => '1',
                'keyword' => '1',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'pid' => 0,
                'cate_name' => '帮助中心',
                'articles' => 0,
                'display_order' => 0,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '1',
                'seotitle' => '1',
                'keyword' => '1',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'pid' => 0,
                'cate_name' => '页脚配置',
                'articles' => 0,
                'display_order' => 0,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '1',
                'seotitle' => '1',
                'keyword' => '1',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            3 => 
            array (
                'id' => 8,
                'pid' => 2,
                'cate_name' => 'dfdf',
                'articles' => 0,
                'display_order' => 4,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            4 => 
            array (
                'id' => 10,
                'pid' => 2,
                'cate_name' => 'qwew',
                'articles' => 0,
                'display_order' => 1,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            5 => 
            array (
                'id' => 29,
                'pid' => 3,
                'cate_name' => '关于我们',
                'articles' => 0,
                'display_order' => 1,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '2016-07-18 14:44:43',
            ),
            6 => 
            array (
                'id' => 30,
                'pid' => 3,
                'cate_name' => '服务条款',
                'articles' => 0,
                'display_order' => 1,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            7 => 
            array (
                'id' => 31,
                'pid' => 3,
                'cate_name' => '帮助中心',
                'articles' => 0,
                'display_order' => 2,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            8 => 
            array (
                'id' => 33,
                'pid' => 31,
                'cate_name' => '服务商',
                'articles' => 0,
                'display_order' => 1,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            9 => 
            array (
                'id' => 34,
                'pid' => 31,
                'cate_name' => '常见问题',
                'articles' => 0,
                'display_order' => 1,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            10 => 
            array (
                'id' => 35,
                'pid' => 31,
                'cate_name' => '任务大厅',
                'articles' => 0,
                'display_order' => 1,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            11 => 
            array (
                'id' => 36,
                'pid' => 31,
                'cate_name' => '新手上路',
                'articles' => 0,
                'display_order' => 1,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            12 => 
            array (
                'id' => 37,
                'pid' => 33,
                'cate_name' => '空间规则',
                'articles' => 0,
                'display_order' => 2,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            13 => 
            array (
                'id' => 38,
                'pid' => 33,
                'cate_name' => '案例管理',
                'articles' => 0,
                'display_order' => 1,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            14 => 
            array (
                'id' => 39,
                'pid' => 3,
                'cate_name' => '空间规则',
                'articles' => 0,
                'display_order' => 11,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            15 => 
            array (
                'id' => 43,
                'pid' => 35,
                'cate_name' => '任务',
                'articles' => 0,
                'display_order' => 1,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            16 => 
            array (
                'id' => 44,
                'pid' => 36,
                'cate_name' => '新手问题',
                'articles' => 0,
                'display_order' => 1,
                'url' => '',
                'user_id' => 0,
                'user_name' => '',
                'created_at' => '0000-00-00 00:00:00',
                'description' => '',
                'seotitle' => '',
                'keyword' => '',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            17 => 
            array (
                'id' => 50,
                'pid' => 50,
                'cate_name' => '行业动态',
                'articles' => NULL,
                'display_order' => 2,
                'url' => NULL,
                'user_id' => NULL,
                'user_name' => NULL,
                'created_at' => '2016-08-03 15:47:22',
                'description' => NULL,
                'seotitle' => NULL,
                'keyword' => NULL,
                'updated_at' => '2016-08-03 15:55:57',
            ),
            18 => 
            array (
                'id' => 51,
                'pid' => 50,
                'cate_name' => '新闻',
                'articles' => NULL,
                'display_order' => 0,
                'url' => NULL,
                'user_id' => NULL,
                'user_name' => NULL,
                'created_at' => '2016-08-03 15:54:06',
                'description' => NULL,
                'seotitle' => NULL,
                'keyword' => NULL,
                'updated_at' => '2016-08-03 15:55:01',
            ),
            19 => 
            array (
                'id' => 55,
                'pid' => 1,
                'cate_name' => '新闻',
                'articles' => NULL,
                'display_order' => 1,
                'url' => NULL,
                'user_id' => NULL,
                'user_name' => NULL,
                'created_at' => '2016-08-03 15:56:44',
                'description' => NULL,
                'seotitle' => NULL,
                'keyword' => NULL,
                'updated_at' => '2016-08-03 15:56:44',
            ),
            20 => 
            array (
                'id' => 56,
                'pid' => 1,
                'cate_name' => '行业动态',
                'articles' => NULL,
                'display_order' => 2,
                'url' => NULL,
                'user_id' => NULL,
                'user_name' => NULL,
                'created_at' => '2016-08-03 15:57:00',
                'description' => NULL,
                'seotitle' => NULL,
                'keyword' => NULL,
                'updated_at' => '2016-08-03 15:57:00',
            ),
            21 => 
            array (
                'id' => 57,
                'pid' => 1,
                'cate_name' => '经验分享',
                'articles' => NULL,
                'display_order' => 3,
                'url' => NULL,
                'user_id' => NULL,
                'user_name' => NULL,
                'created_at' => '2016-08-03 15:57:09',
                'description' => NULL,
                'seotitle' => NULL,
                'keyword' => NULL,
                'updated_at' => '2016-08-03 15:57:09',
            ),
            22 => 
            array (
                'id' => 58,
                'pid' => 1,
                'cate_name' => '公告',
                'articles' => NULL,
                'display_order' => 4,
                'url' => NULL,
                'user_id' => NULL,
                'user_name' => NULL,
                'created_at' => '2016-08-03 15:57:19',
                'description' => NULL,
                'seotitle' => NULL,
                'keyword' => NULL,
                'updated_at' => '2016-08-03 15:57:19',
            ),
        ));
        
        
    }
}