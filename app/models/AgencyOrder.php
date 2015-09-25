<?php 

class AgencyOrder extends BaseModel{
    
    protected $table        = 'agency_orders';
    protected $primaryKey   = 'order_id';

    protected $hidden       = [];
    protected $fillable     = [
        'order_id',
        'user_id',
        'pay_platform',
        'pay_time',
        'pay_trade_no',
        'car_plate_no',
        'agency_no',
        'capital_sum',
        'late_fee_sum',
        'service_charge_sum',
        'is_delivered',
        'trade_status',
        'process_status',
        'express_fee',
        'recipient_name',
        'recipient_addr',
        'recipient_phone',
        'car_engine_no',
        'car_type_no'
    ];

    /*
     * 生成主键时所用的前缀
     */
    protected static $id_prefix = 'dbdd';

    /*
     * 获得所属用户
     */
    public function user(){

        return $this->belongsTo( 'User', 'user_id', 'user_id' );
    }

    /*
     * 获取该订单代办的违章信息
     */
    public function traffic_violation_info(){

        return $this->hasMany( 'TrafficViolationInfo', 'order_id', 'order_id' );
    }

    /*
     * 获取退款记录
     */
    public function refund_record(){

        return $this->hasOne( 'RefundRecord', 'order_id', 'order_id' );
    }
}