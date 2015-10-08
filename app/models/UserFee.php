<?php 

class UserFee extends Eloquent{
    
    protected $table        = 'user_fee';

    protected $hidden       = [];
    protected $fillable     = [
        'user_id',
        'fee_type_id',
        'fee_no'
    ];

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