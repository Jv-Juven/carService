<?php 

class CostDetail extends BaseModel{
    
    protected $table        = 'cost_details';
    protected $primaryKey   = 'cost_id';

    protected $hidden       = [];
    protected $fillable     = [
        'cost_id',
        'user_id',
        'fee_type_id',
        'number'
    ];

    /*
     * 生成主键时所用的前缀
     */
    protected static $id_prefix = 'fyxx';

    /*
     * 获取所属用户
     */
    public function user(){

        return $this->belongsTo( 'User', 'user_id', 'user_id' );
    }

    /*
     * 获取所属费用类型
     */
    public function fee_type(){

        return $this->belongsTo( 'FeeType', 'fee_type_id', 'id' );
    }
}