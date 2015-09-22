<?php 

class CostDetail extends BaseModel{
    
    protected $table        = 'cost_details';
    protected $primaryKey   = 'cost_id';

    protected $hidden       = [];
    protected $fillable     = [
        'cost_id',
        'user_id',
        'item_id',
        'number'
    ];

    /*
     * 获得生成主键时所用的前缀
     */
    protected static function get_id_prefix(){

        return 'fyxx';
    }

    /*
     * 获取所属用户
     */
    public function user(){

        return $this->belongsTo( 'User', 'user_id', 'user_id' );
    }

    /*
     * 获取所属费用类型
     */
    public function item(){

        return $this->belongsTo( 'FeeType', 'item_id', 'item_id' );
    }
}