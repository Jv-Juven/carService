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
     * 生成主键时所用的前缀
     */
    protected static $id_prefix = 'fylx';

    /*
     * 获取用户费用
     */
    public function user_fee(){

        return $this->hasOne( 'UserFee', 'item_id', 'item_id' );
    }

    /**
     * 监听创建事件
     */
    public static function boot(){

        parent::boot();

        self::creating(function( $item ){
            $item->item_id = self::get_unique_id( self::$id_prefix );
            return true;
        });
    }
}