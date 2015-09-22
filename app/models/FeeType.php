<?php 

class FeeType extends BaseModel{
    
    protected $table        = 'fee_types';
    protected $primaryKey   = 'item_id';

    protected $hidden       = [];
    protected $fillable     = [
        'item_id',
        'category',
        'item',
        'number',
        'flow_direction',
        'user_type'
    ];

    /*
     * 获得生成主键时所用的前缀
     */
    protected static function get_id_prefix(){

        return 'fylx';
    }

    /*
     * 获取用户费用
     */
    public function user_fee(){

        return $this->hasOne( 'UserFee', 'item_id', 'item_id' );
    }
}