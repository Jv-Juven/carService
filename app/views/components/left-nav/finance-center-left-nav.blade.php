<div class="left-nav" id="finance-center-left-nav">
    <div class="nav">
        <ul class="nav-first">
            <li class="li">
                <a href="javascript:">
                    <i class="nav-icon">
                        <img src="/images/components/data_icon.png">
                    </i>
                    费用管理
                </a>
                <ul class="nav-sec">
                    @if( Sentry::getUser()->is_business_user() )
                    <li>
                        <a class="nav-item" href="/finance-center/cost-manage/overview">
                            <i>•</i>
                            概览
                        </a>
                        <i class="nav-arrow">
                            <img src="/images/components/nav_arrow.png">
                        </i>
                    </li>
                    <li class="">
                        <a class="nav-item" href="/finance-center/cost-manage/cost-detail">
                            <i>•</i>
                            费用明细
                        </a>
                        <i class="nav-arrow">
                            <img src="/images/components/nav_arrow.png">
                        </i>
                    </li>
                    @else
                    <li class="blank-li">
                        <a class="blank-a nav-item">
                        </a>
                    </li>
                    <li class="blank-li">
                        <a class="blank-a nav-item">
                        </a>
                    </li>
                    @endif
                    <li>
                        <a class="nav-item" href="/finance-center/cost-manage/refund-record">
                            <i>•</i>
                            退款记录
                        </a>
                        <i class="nav-arrow">
                            <img src="/images/components/nav_arrow.png">
                        </i>
                    </li>
                </ul>
            </li>
            @if( Sentry::getUser()->is_business_user() )
            <li class="li">
                <a href="javascript:">
                    <i class="nav-icon">
                        <img src="/images/components/business_icon.png">
                    </i>
                    充值
                </a>
                <ul class="nav-sec">
                    <li>
                        <a class="nav-item" href="/finance-center/recharge/index">
                            <i>•</i>
                            充值
                        </a>
                        <i class="nav-arrow">
                            <img src="/images/components/nav_arrow.png">
                        </i>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </div>
</div>