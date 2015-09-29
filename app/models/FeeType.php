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

    protected static $types_map    = [
        '10'    => [
            'name'      => '普通充值',
            'subitems'  => [
                '1'     => '普通充值'
            ]
        ],
        '20'    => [
            'name'      => '快递费',
            'subitems'  => [
                '1'     => '个人用户快递费',
                '2'     => '企业用户快递费'
            ]
        ],
        '30'    => [
            'name'      => '服务费',
            'subitems'  => [
                '1'     => '个人用户代办服务费',
                '2'     => '企业用户代办服务费'
            ]
        ]
    ];

    /**
     * 获得目录
     *
     * @return array
     */
    public function get_all_types(){

        return static::$types_map;
    }

    /**
     * 获得子目录
     *
     * @return array
     */
    public function get_subitems( $category ){

        return static::$types_map[ $category ][ 'subitems' ];
    }

    /**
     * 获得分类名称
     *
     * @return array
     */
    public function get_category_name( $category ){

        return static::$types_map[ $category ][ 'name' ];
    }
    
    /**
     * 获得细项名称
     *
     * @return array
     */
    public function get_subitem_name( $category, $item ){

        return static::$types_map[ $category ][ $item ];
    }

    /**
     * 生成主键时所用的前缀
     */
    protected static $id_prefix = 'fylx';

    /**
     * 获取用户费用
     */
    public function user_fee(){

        return $this->hasOne( 'UserFee', 'id', 'fee_type_id' );
    }
}