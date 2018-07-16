<?php

use Illuminate\Database\Seeder;

class LinkTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('link')->delete();
        
        \DB::table('link')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '一品威客',
                'content' => 'http://www.epwk.com',
                'addtime' => '2016-08-03 15:41:17',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/61bcbbf7cb7b236f711720f21ba3c443.jpg',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '互帮网',
                'content' => 'http://www.bangcn.com',
                'addtime' => '2016-08-03 15:41:33',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/f89a14bb88b14e2bad7cfe2ca3b7f7e4.png',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'A5任务',
                'content' => 'http://www.a5.cn',
                'addtime' => '2016-08-03 15:41:48',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/1f6e23f4dea3212ca022c1f1407fcb2b.png',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => '多人维',
                'content' => 'http://www.duorenwei.com',
                'addtime' => '2016-08-03 15:42:03',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/59ca5632e60778455de22acc8478d8e7.png',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => '达人酷',
                'content' => 'http://www.darenku.cn',
                'addtime' => '2016-08-03 15:42:14',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/cf85369e4fb4b8806238501805ba05db.png',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => '米画师',
                'content' => 'http://www.mihuashi.com ',
                'addtime' => '2016-08-03 15:42:30',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/ddad36f3b275232c6c2236d5e94aebca.jpg',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => '人人印',
                'content' => 'http://www.rryin.com',
                'addtime' => '2016-08-03 15:42:43',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/1e6b1f4fc6773aa19f68f31b00df5927.jpg',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => '印客联盟',
                'content' => 'http://www.35880.cn',
                'addtime' => '2016-08-03 15:42:58',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/9927515bc94d693290a0e787170a4780.jpg',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => '设计邦',
                'content' => 'http://www.shejibon.com',
                'addtime' => '2016-08-03 15:43:12',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/5a3962dbff2f103d04ee746f17aa53eb.jpg',
            ),
            9 => 
            array (
                'id' => 10,
                'title' => '花艺在线',
                'content' => 'http://www.huadian360.com',
                'addtime' => '2016-08-03 15:43:29',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/ad5e8ec025eeadccb81f58d09f124963.jpg',
            ),
            10 => 
            array (
                'id' => 11,
                'title' => '微电影',
                'content' => 'http://www.wdy.com',
                'addtime' => '2016-08-03 15:43:42',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/362fd28828db8e4f446724ce7fb8a1dd.jpg',
            ),
            11 => 
            array (
                'id' => 12,
                'title' => '熊猫演',
                'content' => 'http://www.xmyshow.com',
                'addtime' => '2016-08-03 15:43:53',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/d35600472186e9956714aba303cb2efc.jpg',
            ),
            12 => 
            array (
                'id' => 13,
                'title' => '千里马',
                'content' => 'http://www.qianlima.com',
                'addtime' => '2016-08-03 15:44:06',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/bdbb01c7e26305deeff1f982e044c16d.jpg',
            ),
            13 => 
            array (
                'id' => 14,
                'title' => '部落网',
                'content' => 'http://www.boolaw.com',
                'addtime' => '2016-08-03 15:44:48',
                'status' => 1,
                'sort' => 0,
                'pic' => 'attachment/sys/8fb33e99e5bdb86ce55ab1f02bd79e76.png',
            ),
        ));
        
        
    }
}
