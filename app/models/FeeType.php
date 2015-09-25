<?php 

class FeeType extends Eloquent{
    
    protected $table        = 'fee_types';
    protected $primaryKey   = 'id';

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
     * 生成主键时所用的前缀
     */
    protected static $id_prefix = 'fylx';

    /*
     * 获取用户费用
     */
    public function user_fee(){

        return $this->hasOne( 'UserFee', 'id', 'fee_type_id' );
    }
}