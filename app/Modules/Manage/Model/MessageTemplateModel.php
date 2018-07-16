<?php

namespace  App\Modules\Manage\Model;

use Illuminate\Database\Eloquent\Model;

class MessageTemplateModel extends Model
{
    
    protected $table = 'message_template';
    protected $primaryKey = 'id';


    protected $fillable = [
        'id','code_name','name','content','message_type','is_open','is_on_site','is_send_email','created_at','updated_at'
    ];

    public $timestamps = false;

    
    static function sendMessage($codeName,$messageVariableArr,$sendWay=1)
    {
        switch($sendWay){
            case 1:
                $sendWay = 'is_on_site';
                break;
            case 2:
                $sendWay = 'is_send_email';
                break;
        }

        
        $message = MessageTemplateModel::where('code_name',$codeName)->where('is_open',1)->where($sendWay,1)->first();
        if($message['num'] > 0)
        {
            $rule = "/\{\{[\\w](.*?)\}\}/";
            preg_match_all($rule,$message['content'],$matches);
            $oldArr = empty($matches[0])?:array_unique($matches[0]);
            $res = str_replace($oldArr,$messageVariableArr,$message['content']);
        }
        else
        {
            $res = $message['content'];
        }
        return $res;
    }


}
