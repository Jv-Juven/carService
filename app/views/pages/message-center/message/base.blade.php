<div class="msg-wrap">
    <div class="msg-body">
        <h3 class="msg-tag">平台公告</h3>
        <div class="data-wrap">
            <div class="data-section">
                <ul class="data-list">
                    <li class="data-item data-head clearfix">
                        <span class="item-lf">标题</span>
                        <span class="item-rt">时间</span>
                    </li>
                    @for ( $i = 0; $i < count( $notices ); ++$i )
                        <li class="data-item
                        @if ( $i % 2 == 0 )
                            event-item
                        @else
                            odd-item
                        @endif
                        @if ( !empty( $notice['already_read'] ) )
                            read
                        @endif
                        clearfix">
                            <span class="item-lf">{{{ $notices[$i]->title }}}</span>
                            <span class="item-rt">{{{ $notices[$i]->created_at->format( 'Y-m-d H:i:s' ) }}}</span>
                        </li>
                    @endfor
                </ul>
            </div>
            @include('components.pagination', [ 'paginator' => $paginator ])
        </div>
    </div>
</div>