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
            <li class="active">
                <a href="/manage/config/email">邮箱配置</a>
            </li>
            <li>
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
<div class="g-backrealdetails clearfix bor-border interface">

    <div class="space-8 col-xs-12"></div>
                <!-- PAGE CONTENT BEGINS -->
    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="/manage/config/email">
                    {!! csrf_field() !!}
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 启用加密连接(SSL)： </label>
            <div class="col-sm-4">
                <label><input class="ace" type="radio" name="mail_encryption" value="tls" @if(isset($email['mail_encryption']) &&$email['mail_encryption'] == 'tls')checked="checked"@endif><span class="lbl"> 否 </span></label>
                <label><input class="ace" type="radio" name="mail_encryption" value="ssl" @if(isset($email['mail_encryption']) &&$email['mail_encryption'] == 'ssl')checked="checked"@endif><span class="lbl"> 是 </span></label>
            </div>
        </div>

        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 发送邮件服务器： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="send_mail_server" @if(isset($email['send_mail_server']))value="{{$email['send_mail_server']}}"@endif/>
            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (邮件服务器主机地址,如果本机发送则为localhost)</div>
        </div>

        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 服务器端口： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="server_port" @if(isset($email['server_port']))value="{{$email['server_port']}}" @endif/>
            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (默认端口为：465)</div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 发送邮件账号： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="email_account" @if(isset($email['email_account'])) value="{{$email['email_account']}}" @endif/>
            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (发送邮件所需账号,必须设置)</div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 邮箱授权码： </label>

            <div class="col-sm-4">
                <input type="password" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="account_password" @if(isset($email['account_password'])) value="{{$email['account_password']}}" @endif/>
            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (发送邮件所需账号的授权码,必须设置)</div>

        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 邮件回复地址： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="reply_email_address"
@if(isset($email['reply_email_address']))value="{{$email['reply_email_address']}}" @endif/>

            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i>(和发送邮箱帐号一致,必须设置)</div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 邮件回复名称： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="reply_email_name" @if(isset($email['reply_email_name']))value="{{$email['reply_email_name']}}" @endif/>
            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (邮件回复名称,必须设置)</div>

        </div>
        <div class="interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 测试邮件地址： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="test_email_address" @if(isset($email['test_email_address']))value="{{$email['test_email_address']}}" @endif/>
                <a href="javascript:;" class="send_email">发送测试邮件</a>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="clearfix row bg-backf5 padding20 mg-margin12">
                <div class="col-xs-12">
                    <div class="col-sm-1 text-right"></div>
                    <div class="col-sm-10"><button type="submit" class="btn btn-sm btn-primary">提交</button></div>
                </div>
            </div>
        </div>

    </form>

</div><!-- /.col -->


{!! Theme::asset()->container('specific-js')->usepath()->add('datepicker', 'plugins/ace/css/bootstrap-datetimepicker/datepicker.css') !!}
{!! Theme::asset()->container('specific-js')->usepath()->add('jquery.webui-popover', '/plugins/jquery/css/jquery.webui-popover.min.css') !!}
{!! Theme::asset()->container('custom-css')->usepath()->add('backstage', 'css/backstage/backstage.css') !!}


{{--{!! Theme::asset()->container('custom-js')->usepath()->add('dataTab', 'plugins/ace/js/dataTab.js') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('jquery_dataTables', 'plugins/ace/js/jquery.dataTables.bootstrap.js') !!}--}}

{!! Theme::asset()->container('custom-js')->usepath()->add('configemail', 'js/doc/configemail.js') !!}
