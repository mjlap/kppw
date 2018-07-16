<?php

use Illuminate\Database\Seeder;

class UnionAttachmentTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('union_attachment')->delete();
        
        \DB::table('union_attachment')->insert(array (
            0 => 
            array (
                'id' => 1,
                'object_id' => 1,
                'object_type' => 4,
                'attachment_id' => 1,
                'created_at' => '2017-12-14 14:19:14',
            ),
            1 =>
                array (
                    'id' => 2,
                    'object_id' => 2,
                    'object_type' => 4,
                    'attachment_id' => 1,
                    'created_at' => '2017-12-14 14:19:14',
                ),
            2 =>
                array (
                    'id' => 3,
                    'object_id' => 3,
                    'object_type' => 4,
                    'attachment_id' => 1,
                    'created_at' => '2017-12-14 14:19:14',
                ),
            3 =>
                array (
                    'id' => 4,
                    'object_id' => 4,
                    'object_type' => 4,
                    'attachment_id' => 1,
                    'created_at' => '2017-12-14 14:19:14',
                ),
            4 =>
                array (
                    'id' => 5,
                    'object_id' => 5,
                    'object_type' => 4,
                    'attachment_id' => 1,
                    'created_at' => '2017-12-14 14:19:14',
                ),
            5 =>
                array (
                    'id' => 6,
                    'object_id' => 6,
                    'object_type' => 4,
                    'attachment_id' => 1,
                    'created_at' => '2017-12-14 14:19:14',
                ),
            6 =>
                array (
                    'id' => 7,
                    'object_id' => 7,
                    'object_type' => 4,
                    'attachment_id' => 1,
                    'created_at' => '2017-12-14 14:19:14',
                ),
            7 =>
                array (
                    'id' => 8,
                    'object_id' => 8,
                    'object_type' => 4,
                    'attachment_id' => 1,
                    'created_at' => '2017-12-14 14:19:14',
                ),
            8 =>
                array (
                    'id' => 9,
                    'object_id' => 9,
                    'object_type' => 4,
                    'attachment_id' => 1,
                    'created_at' => '2017-12-14 14:19:14',
                ),
            9 =>
                array (
                    'id' => 10,
                    'object_id' => 10,
                    'object_type' => 4,
                    'attachment_id' => 1,
                    'created_at' => '2017-12-14 14:19:14',
                ),
        ));
        
        
    }
}
