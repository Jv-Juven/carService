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
        'refund_no',
        'comment'
    ];

    protected static $audit_status = [
        '0'     => '审核中',
        '1'     => '审核通过，退款中',
        '2'     => '退款成功',
        '3'     => '审核不通过',
        '4'     => '退款失败'
    ];

    public static function format_audit_status( $index ){

        return static::$audit_status[ $index ];
    }

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
}