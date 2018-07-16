<?php

use Illuminate\Database\Seeder;

class AuthRecordTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('auth_record')->delete();
        
        \DB::table('auth_record')->insert(array (
            0 => 
            array (
                'id' => 1,
                'auth_id' => 1,
                'uid' => 3,
                'username' => 'test',
                'auth_code' => 'realname',
                'status' => 1,
                'auth_time' => '2017-12-14 09:39:01',
            ),
            1 =>
                array (
                    'id' => 2,
                    'auth_id' => 2,
                    'uid' => 1,
                    'username' => '学会伪装',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            2 =>
                array (
                    'id' => 3,
                    'auth_id' => 3,
                    'uid' => 2,
                    'username' => 'kekezu123',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            3 =>
                array (
                    'id' => 4,
                    'auth_id' => 4,
                    'uid' => 4,
                    'username' => 'kekezu456',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            4 =>
                array (
                    'id' => 5,
                    'auth_id' => 5,
                    'uid' => 5,
                    'username' => '只是当时已惘然',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            5 =>
                array (
                    'id' => 6,
                    'auth_id' => 6,
                    'uid' => 6,
                    'username' => 'kekezu789',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            6 =>
                array (
                    'id' => 7,
                    'auth_id' => 7,
                    'uid' => 7,
                    'username' => 'kekezu111',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            7 =>
                array (
                    'id' => 8,
                    'auth_id' => 8,
                    'uid' => 8,
                    'username' => 'kekezu222',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            8 =>
                array (
                    'id' => 9,
                    'auth_id' => 9,
                    'uid' => 9,
                    'username' => 'kekezu333',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            9 =>
                array (
                    'id' => 10,
                    'auth_id' => 10,
                    'uid' => 10,
                    'username' => 'kekezu444',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            10 =>
                array (
                    'id' => 11,
                    'auth_id' => 11,
                    'uid' => 11,
                    'username' => 'kekezu555',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            11 =>
                array (
                    'id' => 12,
                    'auth_id' => 12,
                    'uid' => 12,
                    'username' => 'kekezu666',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            12 =>
                array (
                    'id' => 13,
                    'auth_id' => 13,
                    'uid' => 13,
                    'username' => 'kekezu777',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            13 =>
                array (
                    'id' => 14,
                    'auth_id' => 14,
                    'uid' => 14,
                    'username' => 'kekezu888',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            14 =>
                array (
                    'id' => 15,
                    'auth_id' => 15,
                    'uid' => 15,
                    'username' => 'kekezu999',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
            15 =>
                array (
                    'id' => 16,
                    'auth_id' => 16,
                    'uid' => 16,
                    'username' => 'kekezu000',
                    'auth_code' => 'realname',
                    'status' => 1,
                    'auth_time' => '2017-12-14 09:39:01',
                ),
        ));
        
        
    }
}
