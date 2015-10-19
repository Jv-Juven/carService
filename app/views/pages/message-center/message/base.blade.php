<div class="contain-wrap">
    <div class="contain-body">
        <h3 class="msg-tag">平台公告</h3>
        <div class="data-wrap">
            <div class="data-section">
                <ul class="data-list">
                    <li class="data-item data-head clearfix">
                        <span class="item-lf">标题</span>
                        <span class="item-rt">时间</span>
                    </li>
                    @for ( $i = 0; $i < count( $notices ); ++$i )
                        <li class="data-item clearfix {{ $i % 2 ? 'odd-item' : 'even-item' }} {{ !empty( $notices[$i]['already_read'] ) ? 'read' : '' }}">
                            <span class="item-lf">
                                <a target="_blank" href="/message-center/message/detail?notice_id={{{ $notices[$i]->id }}}">{{{ $notices[$i]->title }}}</a>
                            </span>
                            <span class="item-rt">{{{ $notices[$i]->created_at }}}</span>
                        </li>
                    @endfor
                </ul>
            </div>
            @include('components.pagination', [ 'paginator' => $paginator ])
        </div>
    </div>
</div>