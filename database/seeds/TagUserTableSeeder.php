<?php

use Illuminate\Database\Seeder;

class TagUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tag_user')->delete();
        
        \DB::table('tag_user')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tag_id' => 203,
                'uid' => 3,
            ),
            1 => 
            array (
                'id' => 2,
                'tag_id' => 198,
                'uid' => 3,
            ),
            2 =>
                array (
                    'id' => 4,
                    'tag_id' => 205,
                    'uid' => 2,
                ),
            3 =>
                array (
                    'id' => 5,
                    'tag_id' => 200,
                    'uid' => 2,
                ),
            4 =>
                array (
                    'id' => 6,
                    'tag_id' => 208,
                    'uid' => 1,
                ),
            5 =>
                array (
                    'id' => 7,
                    'tag_id' => 202,
                    'uid' => 1,
                ),
            6 =>
                array (
                    'id' => 8,
                    'tag_id' => 211,
                    'uid' => 4,
                ),
            7 =>
                array (
                    'id' => 9,
                    'tag_id' => 157,
                    'uid' => 4,
                ),
            8 =>
                array (
                    'id' => 10,
                    'tag_id' => 209,
                    'uid' => 5,
                ),
            9 =>
                array (
                    'id' => 11,
                    'tag_id' => 167,
                    'uid' => 5,
                ),
            10 =>
                array (
                    'id' => 12,
                    'tag_id' => 209,
                    'uid' => 6,
                ),
            11 =>
                array (
                    'id' => 13,
                    'tag_id' => 171,
                    'uid' => 6,
                ),
            12 =>
                array (
                    'id' => 14,
                    'tag_id' => 180,
                    'uid' => 7,
                ),
            13 =>
                array (
                    'id' => 15,
                    'tag_id' => 181,
                    'uid' => 7,
                ),
            14 =>
                array (
                    'id' => 16,
                    'tag_id' => 190,
                    'uid' => 8,
                ),
            15 =>
                array (
                    'id' => 17,
                    'tag_id' => 191,
                    'uid' => 8,
                ),
            16 =>
                array (
                    'id' => 18,
                    'tag_id' => 195,
                    'uid' => 9,
                ),
            17 =>
                array (
                    'id' => 19,
                    'tag_id' => 194,
                    'uid' => 9,
                ),
            18 =>
                array (
                    'id' => 20,
                    'tag_id' => 196,
                    'uid' => 10,
                ),
            19 =>
                array (
                    'id' => 21,
                    'tag_id' => 197,
                    'uid' => 10,
                ),
            20 =>
                array (
                    'id' => 22,
                    'tag_id' => 199,
                    'uid' => 11,
                ),
            21 =>
                array (
                    'id' => 23,
                    'tag_id' => 198,
                    'uid' => 11,
                ),
            22 =>
                array (
                    'id' => 24,
                    'tag_id' => 200,
                    'uid' => 12,
                ),
            23 =>
                array (
                    'id' => 25,
                    'tag_id' => 201,
                    'uid' => 12,
                ),
            24 =>
                array (
                    'id' => 26,
                    'tag_id' => 218,
                    'uid' => 13,
                ),
            25 =>
                array (
                    'id' => 27,
                    'tag_id' => 217,
                    'uid' => 13,
                ),
            26 =>
                array (
                    'id' => 28,
                    'tag_id' => 222,
                    'uid' => 14,
                ),
            27 =>
                array (
                    'id' => 29,
                    'tag_id' => 221,
                    'uid' => 14,
                ),
            28 =>
                array (
                    'id' => 30,
                    'tag_id' => 223,
                    'uid' => 15,
                ),
            29 =>
                array (
                    'id' => 31,
                    'tag_id' => 224,
                    'uid' => 15,
                ),

        ));
        
        
    }
}
