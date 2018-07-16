<style type="text/css">
    .ma-t20 {
        margin-top: 20px;
    }
    .ma-l40 {
    margin-left: 40px;
    }
    .ma-t10 {
        margin-top: 10px;
    }
    .ma-l50 {
    margin-left: 50px;
    }
    .ma-t50 {
        margin-top: 50px;
    }
    .pd-t20 {
        padding-top: 20px;
    }
    .pd-l54 {
        padding-left: 54px;
    }
    .kee .bord {
        border-top: 1px solid rgb(204, 204, 204);
    }
    .kee .img {
        width: 50px;
        height: 50px;
    }
    .kee .serial_number span {
        display: block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        border: 1px solid rgb(204, 204, 204);
        border-radius: 50%;
        -ms-border-radius: 50%;
        -moz-border-radius: 50%;
        -o-border-radius: 50%;
        -webkit-border-radius: 50%;
        margin-top: 10px;
    }
    .kee .serial_number p {
        width: 40px;
        height: 5px;
        text-align: center;
        color: #777;
    }
</style>
<div class="row kee">
    <div class="clearfix ma-t20">
        <div class="col-sm-3 col-md-2 col-xs-4 ma-l40 ma-t10 img">
            
        </div>
        <div class="col-sm-9  col-md-10  col-xs-8">
            <div class="col-sm-12 col-md-12 col-xs-12">
                <h3 class="ma-t25 pd-l20">
                    <img src="{!! Theme::asset()->url('img/KEE_logo.png') !!}" alt="" />&nbsp;&nbsp;&nbsp;&nbsp;交付台接入</h3>
            </div>
            <div class="col-sm-12 col-md-12 col-xs-12">
                <p class="col-sm-11 lh-30 pd-l20">交付台 —— 项目协作交付工作台，专为项目交易后交付场景的协同工具，以工具思维为雇主解决项目管控问题，实现项目成果最大化效益（了解更多请点击<a href="http://www.kee.im/home" target="_blank">www.jiaofutai.com</a>）</p>
            </div>
            @if($kee_status == 100)
            <div class="col-sm-12 col-md-12 col-xs-12">
                <a class="btn btn-xs btn-primary pd-l20" href="/manage/keeLoadFirst">立即申请</a>
            </div>
            @elseif($kee_status === 0)
            <div class="col-sm-12 col-md-12 col-xs-12">
                <span class="col-bule pd-l20">请等待管理员审核...</span>
            </div>
            @elseif($kee_status == 1)
            <div class="col-sm-12 col-md-12 col-xs-12">
                <label class="pd-l20">
                    <input type="radio" name="state" value="1" @if($is_open == 1) checked="checked" @endif onclick="isOpenKee(this)"/>&nbsp;&nbsp;
                启用</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <label>
                    <input type="radio" name="state" value="0" @if($is_open == 0) checked="checked" @endif onclick="isOpenKee(this)"/>&nbsp;&nbsp;
                禁用</label>
            </div>
            @elseif($kee_status == 99)
            <div class="col-sm-12 col-md-12 col-xs-12 col-bule">
                很遗憾，您未通过审核，您可以  <a class="btn btn-xs btn-info" href="/manage/keeLoadAgain">重新申请</a>
            </div>
            @endif
        </div>
        <div class="col-sm-10 col-md-8  col-lg-12 ma-l50 ma-t50 pd-t20 pd-l54 bord">
            <div class="col-sm-12 col-md-12 col-xs-12">
                <h3 class="pd-l20">接入流程</h3>
            </div>
            <div class="col-sm-8 col-md-7 col-xs-10 ma-t10">
                <div class="col-sm-2 col-md-2 col-lg-1 serial_number pd-l20">
                    <span>1</span>
                    <p>.</p>
                    <p>.</p>
                    <p>.</p>
                </div>
                <div class="col-sm-10 text pd-l20">
                    <h5>申请接入</h5>
                    <p>申请接入交付台后等待交付台管理人員审核</p>
                </div>
            </div>
            <div class="col-sm-8 col-md-7 col-xs-10 ma-t10">
                <div class="col-sm-2 col-md-2 col-lg-1 serial_number pd-l20">
                    <span>2</span>
                    <p>.</p>
                    <p>.</p>
                    <p>.</p>
                </div>
                <div class="col-sm-10 text pd-l20">
                    <h5>开启交付台接入功能</h5>
                    <p>审核通过后即可成功使用交付台</p>
                </div>
            </div>
            <div class="col-sm-8 col-md-7 col-xs-10 ma-t10">
                <div class="col-sm-2 col-md-2 col-lg-1 serial_number pd-l20">
                    <span>3</span>
                </div>
                <div class="col-sm-10 text pd-l20">
                    <h5>进入交付台管理悬赏项目或众包项目</h5>
                    <p>在详情页面点击【交付工作台】即可进入交付台管理项目</p>
                </div>
            </div>
        </div>
    </div>

</div>

{!! Theme::asset()->container('custom-js')->usepath()->add('loadKee', 'js/loadKee.js') !!}