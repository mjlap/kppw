<div class="widget-header mg-bottom20 mg-top12 widget-well">
    <div class="widget-toolbar no-border pull-left no-padding">
        <ul class="nav nav-tabs">
            <li>
                <a href="/manage/config/site">站点配置</a>
            </li>
            <li>
                <a href="/manage/config/link">关注链接</a>
            </li>

            <li class="active">
                <a href="/manage/config/seo">SEO配置</a>
            </li>
            <li>
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

                <!-- PAGE CONTENT BEGINS -->
<form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="/manage/config/seo">
    {!! csrf_field() !!}
                <!-- #section:elements.form -->
    <div class="g-backrealdetails clearfix bor-border interface">
        <div class="space-8 col-xs-12"></div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 首页SEO标题： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-12" name="homepage_seo_title" @if(isset($seo['seo_index']['title']))value="{{$seo['seo_index']['title']}}"@endif/>
            </div>
            <div class="col-sm-4 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> 网页标题通常是搜索引擎关注的重点，本附加字设置将出现在标题中网站名称的后面，如果有多个关键字，建议用 "|"、","(不含引号) 等符号分隔</div>
        </div>

        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 首页SEO关键词： </label>

            <div class="col-sm-4">
                <textarea class="col-xs-10 col-sm-12"  name="homepage_seo_keywords">@if(isset($seo['seo_index']['keywords'])){{$seo['seo_index']['keywords']}}@endif</textarea>
            </div>
            <div class="col-sm-4 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> Keywords 项出现在页面头部的 Meta 标签中，用于记录本页面的关键字，多个关键字间请用半角逗号 "," 隔开</div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 首页SEO描述： </label>

            <div class="col-sm-4">
                <textarea class="col-xs-10 col-sm-12" name="homepage_seo_desc">@if(isset($seo['seo_index']['description'])){{$seo['seo_index']['description']}}@endif</textarea>
            </div>
            <div class="col-sm-4 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> Description 出现在页面头部的 Meta 标签中，用于记录本页面的概要与描述</div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 任务大厅SEO标题： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="Username" class="col-xs-10 col-sm-12"  name="task_seo_title" @if(isset($seo['seo_task']['title']))value="{{$seo['seo_task']['title']}}"@endif/>
            </div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 任务大厅SEO关键词： </label>

            <div class="col-sm-4">
                <textarea class="col-xs-10 col-sm-12"  name="task_seo_keywords"> @if(isset($seo['seo_task']['keywords'])){{$seo['seo_task']['keywords']}}@endif</textarea>
            </div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 任务大厅SEO描述： </label>

            <div class="col-sm-4">
                <textarea class="col-xs-10 col-sm-12" name="task_seo_desc"> @if(isset($seo['seo_task']['description'])){{$seo['seo_task']['description']}}@endif</textarea>
            </div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 服务商列表SEO标题： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="Username" class="col-xs-10 col-sm-12"  name="service_seo_title" @if(isset($seo['seo_service']['title']))value="{{$seo['seo_service']['title']}}"@endif/>
            </div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 服务商列表SEO关键词： </label>

            <div class="col-sm-4">
                <textarea class="col-xs-10 col-sm-12" name="service_seo_keywords">@if(isset($seo['seo_service']['keywords'])){{$seo['seo_service']['keywords']}}@endif</textarea>
            </div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 服务商列表SEO描述： </label>

            <div class="col-sm-4">
                <textarea class="col-xs-10 col-sm-12" name="service_seo_desc">@if(isset($seo['seo_service']['description'])){{$seo['seo_service']['description']}}@endif</textarea>
            </div>
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 资讯中心SEO标题： </label>

            <div class="col-sm-4">
                <input type="text" id="form-field-1" placeholder="Username" class="col-xs-10 col-sm-12"  name="article_seo_title" @if(isset($seo['seo_article']['title']))value="{{$seo['seo_article']['title']}}"@endif/>
            </div>
            {{--<div class="col-sm-5 h5 cor-gray87"><i class="fa fa-exclamation-circle cor-orange text-size18"></i> (可用变量){资讯分类}</div>--}}
        </div>
        <div class="form-group interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 资讯中心SEO关键词： </label>

            <div class="col-sm-4">
                <textarea class="col-xs-10 col-sm-12" name="article_seo_keywords">@if(isset($seo['seo_article']['keywords'])){{$seo['seo_article']['keywords']}}@endif</textarea>
            </div>
        </div>
        <div class="interface-bottom col-xs-12">
            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 资讯中心SEO描述： </label>

            <div class="col-sm-4">
                <textarea class="col-xs-10 col-sm-12" name="article_seo_desc">@if(isset($seo['seo_article']['description'])){{$seo['seo_article']['description']}}@endif</textarea>
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
    </div>
</form>



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