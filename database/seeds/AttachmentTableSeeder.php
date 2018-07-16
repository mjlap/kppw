<?php

use Illuminate\Database\Seeder;

class AttachmentTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('attachment')->delete();
        
        \DB::table('attachment')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'a8a62cfeac90d00a71de53b42f89ae65.jpg',
                'type' => 'jpg',
                'size' => 55,
                'url' => 'attachment/user/2017/12/14/7c3f59f018a54d9d9d560c112bab64a3.jpg',
                'status' => 1,
                'user_id' => 5,
                'disk' => 'public',
                'created_at' => '2017-12-14 14:19:07',
            ),
        ));
        
        
    }
}
