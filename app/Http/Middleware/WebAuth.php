<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Config;
use Cache;
use Illuminate\Support\Facades\Crypt;
use Log;

class WebAuth
{
    
    public function handle(Request $request, Closure $next)
    {

        
        if (empty($request->get('token'))) {
            return $this->formateResponse(1011,'请先登录！');
        } else {
            
            $tokenInfo = Crypt::decrypt(urldecode($request->input('token')));
            if ( is_array($tokenInfo) && isset($tokenInfo['uid']) && isset($tokenInfo['name']) 
 && isset($tokenInfo['akey']) && isset($tokenInfo['expire'])) {
                $akey = md5(Config::get('app.key'));
                
                if ( $tokenInfo['expire'] > time() && $akey == $tokenInfo['akey'] && Cache::get($tokenInfo['uid'])) {
                    return $next($request);
                } else {
                    
                    return $this->formateResponse(1013,'登录过期,请重新登录！');
                }
            } else {
                
                return $this->formateResponse(1012,'不合法的token！');
            }
        }

    }

    
    public function formateResponse($code=1000, $message='success', $data=null, $statusCode=200){
        $result['code'] = $code;
        $result['message'] = $message;
        if (isset($data)) {
            $result['data'] = is_array($data) ? $data : json_decode($data,true);
        }
        return new Response($result,$statusCode);
    }

}
