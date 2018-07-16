<div class="accordion-style1 panel-group accordion-style2 g-side1" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title clearfix">
                <a href="#collapseThree4" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle g-wrap1
                {{ (preg_match('/^\/user\/(acceptTasksList|serviceMyJob|workComment|mySellGoods)/',$_SERVER['REQUEST_URI']))?'g-active':'' }}">
                    <i class="text-size20 g-tradingico"></i>&nbsp;&nbsp;&nbsp;&nbsp;交易管理
                    <i class="pull-right ace-icon fa fa-angle-down" data-icon-hide="fa-angle-down" data-icon-show="fa-angle-right"></i>

                </a>
            </h4>
        </div>
        <div id="collapseThree4" class="panel-collapse collapse {{ (preg_match('/^\/user\/(acceptTasksList|serviceMyJob|workComment|mySellGoods)/',$_SERVER['REQUEST_URI']))?'in':'' }}">
            <div class="g-sidenav {{ (preg_match('/^\/user\/(myTask|acceptTasksList)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="/user/acceptTasksList" class="g-wrap2 {{ (preg_match('/^\/user\/(myTask|myTasksList)/',$_SERVER['REQUEST_URI']))?'active':'' }}">我承接的任务</a>
            </div>
            <div class="g-sidenav {{ (preg_match('/^\/user\/(serviceMyJob)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="/user/serviceMyJob" class="g-wrap2 {{ (preg_match('/^\/user\/(serviceMyJob)/',$_SERVER['REQUEST_URI']))?'active':'' }}">我承接的服务</a>
            </div>
            <div class="g-sidenav {{ (preg_match('/^\/user\/(mySellGoods)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="/user/mySellGoods" class="g-wrap2 {{ (preg_match('/^\/user\/(mySellGoods)/',$_SERVER['REQUEST_URI']))?'active':'' }}">我卖出的作品</a>
            </div>
            <div class="g-sidenav {{ (preg_match('/^\/user\/(workComment)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="/user/workComment" class="g-wrap2 {{ (preg_match('/^\/user\/(workComment)/',$_SERVER['REQUEST_URI']))?'active':'' }}">交易评价</a>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title clearfix">
                <a href="#collapseThrees2" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle g-wrap1
                   {{ (preg_match('/^\/user\/(shop|myShopSuccessCase|goodsShop|serviceList|serviceEdit|serviceCreate|serviceBounty|shopcommentowner|waitGoodsHandle|pubGoods|editGoods|addShopSuccess|editShopSuccess|enterpriseAuth)/',$_SERVER['REQUEST_URI']))?'g-active':'' }} collapsed">
                    <i class="text-size20 g-tradingico g-tradshopico"></i>&nbsp;&nbsp;&nbsp;&nbsp;店铺管理
                    <i class="pull-right ace-icon fa fa-angle-right" data-icon-hide="fa-angle-down" data-icon-show="fa-angle-right"></i>
                </a>
            </h4>
        </div>
        <div id="collapseThrees2" class="panel-collapse collapse
        {{ (preg_match('/^\/user\/(switchUrl|shop|myShopSuccessCase|goodsShop|serviceList|serviceEdit|serviceCreate|serviceBounty|shopcommentowner|waitGoodsHandle|pubGoods|editGoods|addShopSuccess|editShopSuccess|enterpriseAuth|waitServiceHandle|vipshopbar)/',$_SERVER['REQUEST_URI']))?'in':'' }}">
            <div class="g-sidenav {{ (preg_match('/^\/user\/switchUrl$/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="/user/switchUrl" class="g-wrap2 {{ (preg_match('/^\/user\/(switchUrl)/',$_SERVER['REQUEST_URI']))?'active':'' }}">我的店铺</a>
            </div>
            <div class="g-sidenav {{ (preg_match('/^\/user\/(shop|enterpriseAuth)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="/user/shop" class="g-wrap2 {{ (preg_match('/^\/user\/(shop|enterpriseAuth)/',$_SERVER['REQUEST_URI']))?'active':'' }}">店铺设置</a>
            </div>
            <div class="g-sidenav {{ (preg_match('/^\/user\/(vipshopbar)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="{{url('user/vipshopbar')}}" class="g-wrap2 {{ (preg_match('/^\/user\/(vipshopbar)/',$_SERVER['REQUEST_URI']))?'active':'' }}">店铺装修</a>
            </div>
            <div class="g-sidenav {{ (preg_match('/^\/user\/(goodsShop|waitGoodsHandle|pubGoods|editGoods)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="/user/goodsShop" class="g-wrap2 {{ (preg_match('/^\/user\/(goodsShop)/',$_SERVER['REQUEST_URI']))?'active':'' }}">作品管理</a>
            </div>
            <div class="g-sidenav {{ (preg_match('/^\/user\/(serviceList|serviceEdit|serviceCreate|serviceBounty|waitServiceHandle)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="{{ URL('user/serviceList') }}" class="g-wrap2">服务管理</a>
            </div>
            <div class="g-sidenav {{ (preg_match('/^\/user\/(myShopSuccessCase|addShopSuccess|editShopSuccess)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="/user/myShopSuccessCase" class="g-wrap2 {{ (preg_match('/^\/user\/(myShopSuccessCase|addShopSuccess|editShopSuccess)/',$_SERVER['REQUEST_URI']))?'active':'' }}">案例管理</a>
            </div>
            <div class="g-sidenav {{ (preg_match('/^\/user\/(shopcommentowner)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                <a href="/user/shopcommentowner" class="g-wrap2 {{ (preg_match('/^\/user\/(shopcommentowner)/',$_SERVER['REQUEST_URI']))?'active':'' }}">交易评价</a>
            </div>
        </div>
    </div>
    
</div>
