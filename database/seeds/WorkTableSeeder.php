<?php

use Illuminate\Database\Seeder;

class WorkTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('work')->delete();
        
        \DB::table('work')->insert(array (
            0 => 
            array (
                'id' => 1,
                'task_id' => 15,
                'desc' => '<p>我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿</p>',
                'status' => 1,
                'forbidden' => 0,
                'uid' => 5,
                'bid_by' => 0,
                'bid_at' => '2017-12-14 14:39:06',
                'created_at' => '2017-12-14 13:58:37',
                'price' => NULL,
            ),
            1 =>
                array (
                    'id' => 2,
                    'task_id' => 12,
                    'desc' => '<p>我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿</p>',
                    'status' => 1,
                    'forbidden' => 0,
                    'uid' => 1,
                    'bid_by' => 0,
                    'bid_at' => '2017-12-14 14:39:06',
                    'created_at' => '2017-12-14 13:58:37',
                    'price' => NULL,
                ),
            2 =>
                array (
                    'id' => 3,
                    'task_id' => 13,
                    'desc' => '<p>我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿</p>',
                    'status' => 1,
                    'forbidden' => 0,
                    'uid' => 4,
                    'bid_by' => 0,
                    'bid_at' => '2017-12-14 14:39:06',
                    'created_at' => '2017-12-14 13:58:37',
                    'price' => NULL,
                ),
            3 =>
                array (
                    'id' => 4,
                    'task_id' => 8,
                    'desc' => '<p>我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿</p>',
                    'status' => 1,
                    'forbidden' => 0,
                    'uid' => 2,
                    'bid_by' => 0,
                    'bid_at' => '2017-12-14 14:39:06',
                    'created_at' => '2017-12-14 13:58:37',
                    'price' => NULL,
                ),
            4 =>
                array (
                    'id' => 5,
                    'task_id' => 7,
                    'desc' => '<p>我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿</p>',
                    'status' => 1,
                    'forbidden' => 0,
                    'uid' => 6,
                    'bid_by' => 0,
                    'bid_at' => '2017-12-14 14:39:06',
                    'created_at' => '2017-12-14 13:58:37',
                    'price' => NULL,
                ),
            5 =>
                array (
                    'id' => 6,
                    'task_id' => 6,
                    'desc' => '<p>我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿</p>',
                    'status' => 1,
                    'forbidden' => 0,
                    'uid' => 7,
                    'bid_by' => 0,
                    'bid_at' => '2017-12-14 14:39:06',
                    'created_at' => '2017-12-14 13:58:37',
                    'price' => NULL,
                ),
            6 =>
                array (
                    'id' => 7,
                    'task_id' => 3,
                    'desc' => '<p>我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿</p>',
                    'status' => 1,
                    'forbidden' => 0,
                    'uid' => 12,
                    'bid_by' => 0,
                    'bid_at' => '2017-12-14 14:39:06',
                    'created_at' => '2017-12-14 13:58:37',
                    'price' => NULL,
                ),
            7 =>
                array (
                    'id' => 8,
                    'task_id' => 2,
                    'desc' => '<p>我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿</p>',
                    'status' => 1,
                    'forbidden' => 0,
                    'uid' => 9,
                    'bid_by' => 0,
                    'bid_at' => '2017-12-14 14:39:06',
                    'created_at' => '2017-12-14 13:58:37',
                    'price' => NULL,
                ),
            8 =>
                array (
                    'id' => 9,
                    'task_id' => 9,
                    'desc' => '<p>我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿</p>',
                    'status' => 1,
                    'forbidden' => 0,
                    'uid' => 9,
                    'bid_by' => 0,
                    'bid_at' => '2017-12-14 14:39:06',
                    'created_at' => '2017-12-14 13:58:37',
                    'price' => NULL,
                ),
            9 =>
                array (
                    'id' => 10,
                    'task_id' => 15,
                    'desc' => '<p>我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿我要投稿</p>',
                    'status' => 1,
                    'forbidden' => 0,
                    'uid' => 6,
                    'bid_by' => 0,
                    'bid_at' => '2017-12-14 14:39:06',
                    'created_at' => '2017-12-14 13:58:37',
                    'price' => NULL,
                ),

        ));
        
        
    }
}
