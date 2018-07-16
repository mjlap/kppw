<?php

use Illuminate\Database\Seeder;

class SkillTagsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('skill_tags')->delete();
        
        \DB::table('skill_tags')->insert(array (
            0 => 
            array (
                'id' => 142,
                'tag_name' => '微信推广',
                'cate_id' => 171,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 143,
                'tag_name' => '微信加粉',
                'cate_id' => 172,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 144,
                'tag_name' => '微信投票',
                'cate_id' => 173,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 145,
                'tag_name' => '微店推广',
                'cate_id' => 174,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 146,
                'tag_name' => '论坛推广',
                'cate_id' => 175,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 147,
                'tag_name' => '软文发布',
                'cate_id' => 176,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 148,
                'tag_name' => '搜索引擎优化',
                'cate_id' => 177,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 149,
                'tag_name' => '发帖推广',
                'cate_id' => 178,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 150,
                'tag_name' => '网站推广',
                'cate_id' => 179,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 151,
                'tag_name' => '微博推广',
                'cate_id' => 180,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 152,
                'tag_name' => '活动推广',
                'cate_id' => 181,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 153,
                'tag_name' => '产品推广',
                'cate_id' => 182,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 154,
                'tag_name' => '微博祝福',
                'cate_id' => 183,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 155,
                'tag_name' => '新品促销',
                'cate_id' => 184,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 156,
                'tag_name' => '店铺推广',
                'cate_id' => 185,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 157,
                'tag_name' => 'Logo设计',
                'cate_id' => 186,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 158,
                'tag_name' => 'VI设计',
                'cate_id' => 187,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 159,
                'tag_name' => '图标设计',
                'cate_id' => 188,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 160,
                'tag_name' => '字体设计',
                'cate_id' => 189,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 161,
                'tag_name' => '按钮图标设计',
                'cate_id' => 190,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 162,
                'tag_name' => '文具设计',
                'cate_id' => 191,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 163,
                'tag_name' => '服饰设计',
                'cate_id' => 192,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 164,
                'tag_name' => '包装设计',
                'cate_id' => 193,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 165,
                'tag_name' => '产品外观设计',
                'cate_id' => 194,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 166,
                'tag_name' => '电路设计',
                'cate_id' => 195,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 167,
                'tag_name' => '宣传册页',
                'cate_id' => 196,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 168,
                'tag_name' => '横幅设计',
                'cate_id' => 197,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 169,
                'tag_name' => '台历设计',
                'cate_id' => 198,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 170,
                'tag_name' => '海报设计',
                'cate_id' => 199,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 171,
                'tag_name' => '书籍封面设计',
                'cate_id' => 200,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 172,
                'tag_name' => '插画设计',
                'cate_id' => 201,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 173,
                'tag_name' => '排版设计',
                'cate_id' => 202,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 174,
                'tag_name' => '电子书制作',
                'cate_id' => 203,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 175,
                'tag_name' => '新房装修',
                'cate_id' => 204,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 176,
                'tag_name' => '别墅设计',
                'cate_id' => 205,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 177,
                'tag_name' => '小区规划',
                'cate_id' => 206,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 178,
                'tag_name' => '商场装修',
                'cate_id' => 207,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 179,
                'tag_name' => '导视系统设计',
                'cate_id' => 208,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 180,
                'tag_name' => '软装搭配',
                'cate_id' => 209,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 181,
                'tag_name' => '定制衣柜设计',
                'cate_id' => 210,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 182,
                'tag_name' => '施工图设计',
                'cate_id' => 211,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 183,
                'tag_name' => '二手房装修',
                'cate_id' => 212,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 184,
                'tag_name' => '样板间设计',
                'cate_id' => 213,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 185,
                'tag_name' => '办公装修设计',
                'cate_id' => 214,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 186,
                'tag_name' => '店面装修设计',
                'cate_id' => 215,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 187,
                'tag_name' => '软装配饰',
                'cate_id' => 216,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 188,
                'tag_name' => '订制家具设计',
                'cate_id' => 217,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 189,
                'tag_name' => '效果图制作',
                'cate_id' => 218,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 190,
                'tag_name' => '智能家居系统规划',
                'cate_id' => 219,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 191,
                'tag_name' => '精装房设计',
                'cate_id' => 220,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 192,
                'tag_name' => '展会设计',
                'cate_id' => 221,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 193,
                'tag_name' => '园林景观',
                'cate_id' => 222,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 194,
                'tag_name' => '形象墙设计',
                'cate_id' => 223,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 195,
                'tag_name' => '其他装修',
                'cate_id' => 224,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 196,
                'tag_name' => '市场调查',
                'cate_id' => 225,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 197,
                'tag_name' => '帮我投票',
                'cate_id' => 226,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 198,
                'tag_name' => '数据导入',
                'cate_id' => 227,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 199,
                'tag_name' => '心理咨询',
                'cate_id' => 228,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 200,
                'tag_name' => '跑腿排队',
                'cate_id' => 229,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 201,
                'tag_name' => '理财咨询',
                'cate_id' => 230,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 202,
                'tag_name' => '家政服务',
                'cate_id' => 231,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 203,
                'tag_name' => '程序开发',
                'cate_id' => 232,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 204,
                'tag_name' => '编写脚本',
                'cate_id' => 233,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 205,
                'tag_name' => '软件皮肤',
                'cate_id' => 234,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 206,
                'tag_name' => '插件开发',
                'cate_id' => 235,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 207,
                'tag_name' => '游戏开发',
                'cate_id' => 236,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 208,
                'tag_name' => '程序功能开发',
                'cate_id' => 237,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 209,
                'tag_name' => '软件美工',
                'cate_id' => 238,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 210,
                'tag_name' => '开发文档编写',
                'cate_id' => 239,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 211,
                'tag_name' => '功能完善',
                'cate_id' => 240,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 221,
                'tag_name' => '游戏推广',
                'cate_id' => 242,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 222,
                'tag_name' => '活动方案',
                'cate_id' => 243,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 223,
                'tag_name' => '比赛方案',
                'cate_id' => 244,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 224,
                'tag_name' => '游戏剧情',
                'cate_id' => 245,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}
