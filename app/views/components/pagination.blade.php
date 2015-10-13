<div class="paginate-wrap clearfix">
    <div class="clk-rd-wrap">
        <ul class="page-list clearfix">
            <?php echo with(new ZurbPresenter($paginator))->render(); ?>
        </ul>
    </div>
    <div class="ipt-rd-wrap">
        <form class="clearfix" method="GET" action="">
            @if ( isset( $params ) )
                @foreach ( $params as $key => $value )
                    @if ( $key != 'page' )
                        <input type="hidden" name="{{{ $key }}}" value="{{{ $value }}}">
                    @endif
                @endforeach
            @endif
            <input type="text" name="page" class="ipt-page">
            <input type="submit" value="GO" class="ipt-sbm">
        </form>
    </div>
</div>