<?php

use Illuminate\Database\Seeder;

class TagShopTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tag_shop')->delete();
        
        \DB::table('tag_shop')->insert(array (
            0 => 
            array (
                'id' => 2,
                'tag_id' => 142,
                'shop_id' => 1,
            ),
            1 => 
            array (
                'id' => 3,
                'tag_id' => 143,
                'shop_id' => 1,
            ),
            2 =>
                array (
                    'id' => 4,
                    'tag_id' => 152,
                    'shop_id' => 2,
                ),
            3 =>
                array (
                    'id' => 5,
                    'tag_id' => 153,
                    'shop_id' => 2,
                ),
            4 =>
                array (
                    'id' => 6,
                    'tag_id' => 155,
                    'shop_id' => 3,
                ),
            5 =>
                array (
                    'id' => 7,
                    'tag_id' => 156,
                    'shop_id' => 3,
                ),
            6 =>
                array (
                    'id' => 8,
                    'tag_id' => 158,
                    'shop_id' => 4,
                ),
            7 =>
                array (
                    'id' => 9,
                    'tag_id' => 157,
                    'shop_id' => 4,
                ),
            8 =>
                array (
                    'id' => 10,
                    'tag_id' => 166,
                    'shop_id' => 5,
                ),
            9 =>
                array (
                    'id' => 11,
                    'tag_id' => 167,
                    'shop_id' => 5,
                ),
            10 =>
                array (
                    'id' => 12,
                    'tag_id' => 170,
                    'shop_id' => 6,
                ),
            11 =>
                array (
                    'id' => 13,
                    'tag_id' => 171,
                    'shop_id' => 6,
                ),
            12 =>
                array (
                    'id' => 14,
                    'tag_id' => 180,
                    'shop_id' => 7,
                ),
            13 =>
                array (
                    'id' => 15,
                    'tag_id' => 181,
                    'shop_id' => 7,
                ),
            14 =>
                array (
                    'id' => 16,
                    'tag_id' => 190,
                    'shop_id' => 8,
                ),
            15 =>
                array (
                    'id' => 17,
                    'tag_id' => 191,
                    'shop_id' => 8,
                ),
            16 =>
                array (
                    'id' => 18,
                    'tag_id' => 195,
                    'shop_id' => 9,
                ),
            17 =>
                array (
                    'id' => 19,
                    'tag_id' => 194,
                    'shop_id' => 9,
                ),
            18 =>
                array (
                    'id' => 20,
                    'tag_id' => 196,
                    'shop_id' => 10,
                ),
            19 =>
                array (
                    'id' => 21,
                    'tag_id' => 197,
                    'shop_id' => 10,
                ),
            20 =>
                array (
                    'id' => 22,
                    'tag_id' => 199,
                    'shop_id' => 11,
                ),
            21 =>
                array (
                    'id' => 23,
                    'tag_id' => 198,
                    'shop_id' => 11,
                ),
            22 =>
                array (
                    'id' => 24,
                    'tag_id' => 200,
                    'shop_id' => 12,
                ),
            23 =>
                array (
                    'id' => 25,
                    'tag_id' => 201,
                    'shop_id' => 12,
                ),
            24 =>
                array (
                    'id' => 26,
                    'tag_id' => 218,
                    'shop_id' => 13,
                ),
            25 =>
                array (
                    'id' => 27,
                    'tag_id' => 217,
                    'shop_id' => 13,
                ),
            26 =>
                array (
                    'id' => 28,
                    'tag_id' => 222,
                    'shop_id' => 14,
                ),
            27 =>
                array (
                    'id' => 29,
                    'tag_id' => 221,
                    'shop_id' => 14,
                ),
            28 =>
                array (
                    'id' => 30,
                    'tag_id' => 223,
                    'shop_id' => 15,
                ),
            29 =>
                array (
                    'id' => 31,
                    'tag_id' => 224,
                    'shop_id' => 15,
                ),

        ));
        
        
    }
}
