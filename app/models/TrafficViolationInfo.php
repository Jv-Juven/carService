<?php 

class TrafficViolationInfo extends BaseModel{
    
    protected $table        = 'traffic_violation_info';
    protected $primaryKey   = 'traffic_id';

    protected $hidden       = [];
    protected $fillable     = [
        'traffic_id',
        'order_id',
        'req_car_plate_no',
        'req_car_engine_no',
        'req_car_frame_no',
        'rep_event_time',
        'rep_event_city',
        'rep_event_addr',
        'rep_violation_behavior',
        'rep_point_no',
        'rep_priciple_balance',
        'rep_late_fee',
        'rep_service_charge'
    ];

    /*
     * 获得生成主键时所用的前缀
     */
    protected static function get_id_prefix(){
        
        return 'wzxx';
    }

    /*
     * 获得所属订单
     */
    public function order(){

        return $this->belongsTo( 'AgencyOrder', 'order_id', 'order_id' );
    }
}