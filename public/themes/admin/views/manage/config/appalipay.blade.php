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
            <li >
                <a href="/manage/config/email">邮箱配置</a>
            </li>
            <li>
                <a href="/manage/config/phone">短信配置</a>
            </li>
            <li class="active">
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
    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="/manage/config/appalipay">
                    {!! csrf_field() !!}

        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 合作身份者id： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="partner_id" value="{{$partner_id}}"/>
            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (合作身份者id，以2088开头的16位纯数字。)</div>
        </div>

        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 卖家支付宝帐户： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="seller_id" value="{{$seller_id}}"/>
            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (卖家支付宝帐户)</div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 安全检验码： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="key" value="{{$key}}"/>
            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (安全检验码，以数字和字母组成的32位字符)</div>
        </div>

        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 商户私钥： </label>

            <div class="col-sm-4">
                <input type="file"  placeholder="" class="col-xs-10 col-sm-12" name="private_key_path"/>
            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i>(上传文件rsa_private_key.pem) </div>
        </div>

        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 阿里公钥： </label>

            <div class="col-sm-4">
                <input type="file" placeholder="" class="col-xs-10 col-sm-12" name="public_key_path"/>
            </div>
            <div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (上传文件rsa_public_key.pem)</div>
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
