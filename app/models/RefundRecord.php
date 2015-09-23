<?php 

class RefundRecord extends BaseModel{
    
    protected $table        = 'refund_records';
    protected $primaryKey   = 'refund_id';

    protected $hidden       = [];
    protected $fillable     = [
        'refund_id',
        'order_id',
        'user_id',
        'approval_at',
        'status',
        'comment'
    ];

    /*
     * 生成主键时所用的前缀
     */
    protected static $id_prefix = 'tkjl';

    /*
     * 获得所属订单
     */
    public function order(){

        return $this->belongsTo( 'AgencyOrder', 'order_id', 'order_id' );
    }

    /*
     * 获得所属用户
     */
    public function user(){

        return $this->belongsTo( 'User', 'user_id', 'user_id' );
    }

    /**
     * 监听创建事件
     */
    public static function boot(){

        parent::boot();

        self::creating(function( $refund_record ){
            $refund_record->refund_id = self::get_unique_id( self::$id_prefix );
            return true;
        });
    }
}