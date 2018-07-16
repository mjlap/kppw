<div class="s-slidebar bg-blue"><i class="fa fa-reorder cor-white"></i></div>
<div class="bg-white s-slidecenter">
    <div class="accordion-style1 panel-group accordion-style2 g-side1" id="accordion1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title clearfix">
                    <a href="#collapseThree1" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle g-wrap1 g-active">
                        <i class="text-size20 g-tradingico"></i>&nbsp;&nbsp;&nbsp;&nbsp;交易管理
                        <i class="pull-right ace-icon fa fa-angle-down" data-icon-hide="fa-angle-down" data-icon-show="fa-angle-right"></i>
                        <i class="bigger-110 icon-angle-down" ></i>
                    </a>
                </h4>
            </div>
            <div id="collapseThree1" class="panel-collapse collapse {{ (preg_match('/^\/user\/(myTask|acceptTasksList|workComment|serviceMyJob|mySellGoods)/',$_SERVER['REQUEST_URI']))?'in':'' }}">
                <div class="g-sidenav {{ (preg_match('/^\/user\/(myTask|acceptTasksList)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                    <a href="/user/acceptTasksList" class="g-wrap2 {{ (preg_match('/^\/user\/(myTask|myTasksList)/',$_SERVER['REQUEST_URI']))?'active':'' }}">我承接的任务</a>
                </div>
                <div class="g-sidenav ">
                    <a href="/user/serviceMyJob" class="g-wrap2 {{ (preg_match('/^\/user\/(serviceMyJob)/',$_SERVER['REQUEST_URI']))?'active':'' }}">我承接的服务</a>
                </div>
                <div class="g-sidenav ">
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
                    <a href="#collapseThree3" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle g-wrap1 g-active">
                        <i class="text-size20 g-tradingico g-tradshopico"></i>&nbsp;&nbsp;&nbsp;&nbsp;店铺管理
                        <i class="pull-right ace-icon fa fa-angle-right" data-icon-hide="fa-angle-down" data-icon-show="fa-angle-right"></i>
                        <i class="bigger-110 icon-angle-down" ></i>
                    </a>
                </h4>
            </div>
            <div id="collapseThree3" class="panel-collapse collapse {{ (preg_match('/^\/user\/(switchUrl|shop|goodsShop|waitGoodsHandle|pubGoods|editGoods|serviceList|myShopSuccessCase|shopcommentowner|addShopSuccess|editShopSuccess|enterpriseAuth)/',$_SERVER['REQUEST_URI']))?'in':'' }}">
                <div class="g-sidenav {{ (preg_match('/^\/user\/(switchUrl)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                    <a href="/user/switchUrl" class="g-wrap2 active">我的店铺</a>
                </div>
                <div class="g-sidenav {{ (preg_match('/^\/user\/(shop|enterpriseAuth)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                    <a href="/user/shop" class="g-wrap2">店铺设置</a>
                </div>
                <div class="g-sidenav {{ (preg_match('/^\/user\/(shop|enterpriseAuth)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                    <a href="" class="g-wrap2">店铺装修</a>
                </div>
                <div class="g-sidenav {{ (preg_match('/^\/user\/(goodsShop|waitGoodsHandle|pubGoods|editGoods)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                    <a href="/user/goodsShop" class="g-wrap2">作品管理</a>
                </div>
                <div class="g-sidenav {{ (preg_match('/^\/user\/(serviceList)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                    <a href="/user/serviceList" class="g-wrap2">服务管理</a>
                </div>
                <div class="g-sidenav {{ (preg_match('/^\/user\/(myShopSuccessCase|addShopSuccess|editShopSuccess)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                    <a href="/user/myShopSuccessCase" class="g-wrap2">案例管理</a>
                </div>
                <div class="g-sidenav {{ (preg_match('/^\/user\/(shopcommentowner)/',$_SERVER['REQUEST_URI']))?'z-active':'' }}">
                    <a href="/user/shopcommentowner" class="g-wrap2">交易评价</a>
                </div>
            </div>
        </div>

    </div>
</div>