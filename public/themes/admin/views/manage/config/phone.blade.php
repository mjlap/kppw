<div class="row">
    <div class="col-xs-12">
        <div class="space-10"></div>
        <!-- <div class="table-responsive"> -->
        <div class="widget-header mg-bottom20 mg-top12 widget-well">
            <div class="widget-toolbar no-border pull-left no-padding">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="/manage/config/site">站点配置</a>
                    </li>
                    <li>
                        <a href="/manage/config/link">关注链接</a>
                    </li>

                    <li>
                        <a href="/manage/config/seo">SEO配置</a>
                    </li>
                    <li>
                        <a href="/manage/config/email">邮箱配置</a>
                    </li>
                    <li  class="active">
                        <a href="/manage/config/phone">短信配置</a>
                    </li>
                    <li>
                        <a href="/manage/config/appalipay">app支付宝支付配置</a>
                    </li>
                    <li>
                        <a href="/manage/config/appwechat">app微信支付配置</a>
                    </li>
                    <li>
                        <a href="/manage/config/wechatpublic">微信端配置</a>
                    </li>
                </ul>
            </div>
        </div>

                   <!-- <div class="dataTables_borderWrap"> -->
        <br>
        <div class="space-10"></div>
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="/manage/config/phone">
                    {!! csrf_field() !!}
                    <div class="form-group basic-form-bottom">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 短信服务商： </label>

                        <div class="col-sm-4">
                            @if(isset($phone['yunTongXun']) && !empty($phone['yunTongXun']))
                            <label onclick="tab('.yuntongxun')">
                                <input class="ace" type="radio" name="scheme" value="YunTongXun" @if($phone['scheme'] == 'YunTongXun')checked="checked"@endif>
                                <span class="lbl"> 云通讯 </span>
                            </label>
                            @endif
                            @if(!empty($phone['alidayu']))
                            <label onclick="tab('.aldayu')">
                                <input class="ace" type="radio" name="scheme" value="Alidayu" @if($phone['scheme'] == 'Alidayu')checked="checked"@endif>
                                <span class="lbl"> 阿里大鱼</span>
                            </label>
                            @endif
                            @if(!empty($phone['aliyun']))
                            <label onclick="tab('.aliyun')">
                                <input class="ace" type="radio" name="scheme" value="Aliyun" @if($phone['scheme'] == 'Aliyun')checked="checked"@endif>
                                <span class="lbl"> 阿里云</span>
                            </label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group basic-form-bottom"></div>
                    <!-- 云通讯配置 -->
                    <div class="yuntongxun item" @if($phone['scheme'] == 'YunTongXun')style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group basic-form-bottom">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 主帐号： </label>

                            <div class="col-sm-4">
                                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="accountSid" @if($phone['yunTongXun']['accountSid'])value="{{$phone['yunTongXun']['accountSid']}}" @endif/>
                            </div>
                            <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (主帐号,对应开官网发者主账号下的 ACCOUNT SID )</label>
                        </div>
                        <div class="form-group basic-form-bottom">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 主帐号令牌： </label>

                            <div class="col-sm-4">
                                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="accountToken" @if($phone['yunTongXun']['accountToken'])value="{{$phone['yunTongXun']['accountToken']}}" @endif/>
                            </div>
                            <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN )</label>
                        </div>
                        <div class="form-group basic-form-bottom">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 应用Id： </label>

                            <div class="col-sm-4">
                                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="appId" @if($phone['yunTongXun']['appId'])value="{{$phone['yunTongXun']['appId']}}" @endif/>
                            </div>
                            <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID )</label>
                        </div>
                        <div class="form-group basic-form-bottom"></div>
                    </div>
                    <!-- 阿里大鱼配置 -->
                    <div class="aldayu item" @if($phone['scheme'] == 'Alidayu')style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group basic-form-bottom">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 请求地址： </label>

                            <div class="col-sm-4">
                                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="sendUrl" @if($phone['alidayu']['sendUrl'])value="{{$phone['alidayu']['sendUrl']}}" @endif/>
                            </div>
                            <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (请求地址 )</label>
                        </div>
                        <div class="form-group basic-form-bottom">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> appKey： </label>

                            <div class="col-sm-4">
                                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="appKey" @if($phone['alidayu']['appKey'])value="{{$phone['alidayu']['appKey']}}" @endif/>
                            </div>
                            <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (淘宝开放平台中，对应阿里大鱼短信应用的App Key)</label>
                        </div>
                        <div class="form-group basic-form-bottom">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> secretKey： </label>

                            <div class="col-sm-4">
                                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="secretKey" @if($phone['alidayu']['secretKey'])value="{{$phone['alidayu']['secretKey']}}" @endif/>
                            </div>
                            <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (淘宝开放平台中，对应阿里大鱼短信应用的App Secret)</label>
                        </div>
                        <div class="form-group basic-form-bottom">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 短信签名： </label>

                            <div class="col-sm-4">
                                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="smsFreeSignName" @if($phone['alidayu']['smsFreeSignName'])value="{{$phone['alidayu']['smsFreeSignName']}}" @endif/>
                            </div>
                            <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (短信签名，传入的短信签名必须是在阿里大鱼“管理中心-短信签名管理”中的可用签名 )</label>
                        </div>
                        <div class="form-group basic-form-bottom"></div>
                    </div>

                    <!-- 阿里云配置 -->
                    @if(!empty($phone['aliyun']))
                    <div class="aliyun item" @if($phone['scheme'] == 'Aliyun')style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group basic-form-bottom">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> accessKeyId： </label>

                            <div class="col-sm-4">
                                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="accessKeyId" @if($phone['aliyun']['accessKeyId'])value="{{$phone['aliyun']['accessKeyId']}}" @endif/>
                            </div>
                            <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (对应开官网发者主账号下的 accessKeyId )</label>
                        </div>
                        <div class="form-group basic-form-bottom">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> accessKeySecret： </label>

                            <div class="col-sm-4">
                                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="accessKeySecret" @if($phone['aliyun']['accessKeySecret'])value="{{$phone['aliyun']['accessKeySecret']}}" @endif/>
                            </div>
                            <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i>(对应开官网发者主账号下的 accessKeySecret ) </label>
                        </div>
                        <div class="form-group basic-form-bottom">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 短信签名： </label>

                            <div class="col-sm-4">
                                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="signName" @if($phone['aliyun']['signName'])value="{{$phone['aliyun']['signName']}}" @endif/>
                            </div>
                            <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (对应开官网发者主账号下的通过审核的短信签名 ) </label>
                        </div>
                    </div>
                    @endif


                    <div class="form-group basic-form-bottom"></div>

                    <div class="form-group basic-form-bottom">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 手机注册验证码： </label>

                        <div class="col-sm-4">
                            <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="sendMobileCode" value="{{$sendMobileCode}}" />
                        </div>
                        <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (手机注册验证码短信模板编号 )</label>
                    </div>
                    <div class="form-group basic-form-bottom">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 手机找回密码验证码： </label>

                        <div class="col-sm-4">
                            <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="sendMobilePasswordCode" value="{{$sendMobilePasswordCode}}" />
                        </div>
                        <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (手机找回密码验证码模板短信模板编号)</label>
                    </div>
                    <div class="form-group basic-form-bottom">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 绑定手机验证码： </label>

                        <div class="col-sm-4">
                            <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="sendBindSms" value="{{$sendBindSms}}" />
                        </div>
                        <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (绑定手机短信模板编号)</label>
                    </div>
                    <div class="form-group basic-form-bottom">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 手机解除绑定验证码： </label>

                        <div class="col-sm-4">
                            <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="sendUnbindSms" value="{{$sendUnbindSms}}" />
                        </div>
                        <label class="col-sm-5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (手机解除绑定验证码短信模板编号 )</label>
                    </div>

                    <div class="space-10"></div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <div class="row">
                                <button class="btn btn-info btn-sm" type="submit">
                                    提交
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="space-24"></div>
                </form>

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div><!-- /.row -->

{!! Theme::asset()->container('specific-js')->usepath()->add('datepicker', 'plugins/ace/css/bootstrap-datetimepicker/datepicker.css') !!}
{!! Theme::asset()->container('specific-js')->usepath()->add('jquery.webui-popover', '/plugins/jquery/css/jquery.webui-popover.min.css') !!}
{!! Theme::asset()->container('custom-css')->usepath()->add('backstage', 'css/backstage/backstage.css') !!}

{{--上传图片--}}
{!! Theme::asset()->container('specific-js')->usepath()->add('custom', 'plugins/ace/js/jquery-ui.custom.min.js') !!}
{!! Theme::asset()->container('specific-js')->usepath()->add('touch-punch', 'plugins/ace/js/jquery.ui.touch-punch.min.js') !!}
{!! Theme::asset()->container('specific-js')->usepath()->add('chosen', 'plugins/ace/js/chosen.jquery.min.js') !!}
{!! Theme::asset()->container('specific-js')->usepath()->add('autosize', 'plugins/ace/js/jquery.autosize.min.js') !!}
{!! Theme::asset()->container('specific-js')->usepath()->add('inputlimiter', 'plugins/ace/js/jquery.inputlimiter.1.3.1.min.js') !!}
{!! Theme::asset()->container('specific-js')->usepath()->add('maskedinput', 'plugins/ace/js/jquery.maskedinput.min.js') !!}

{!! Theme::asset()->container('custom-js')->usepath()->add('dataTab', 'plugins/ace/js/dataTab.js') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('jquery_dataTables', 'plugins/ace/js/jquery.dataTables.bootstrap.js') !!}

{!! Theme::asset()->container('custom-js')->usepath()->add('configbasic', 'js/doc/configbasic.js') !!}
