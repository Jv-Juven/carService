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

    public static $type_codes = [
        'recharge'      => '10',
        'express'       => '20',
        'service'       => '30'
    ];

    protected static $types_map = [
        '10'    => [
            'name'      => '普通充值',
            'subitems'  => [
                '0'     => '普通充值'
            ]
        ],
        '20'    => [
            'name'      => '快递费',
            'subitems'  => [
                '0'     => '个人用户快递费',
                '1'     => '企业用户快递费'
            ]
        ],
        '30'    => [
            'name'      => '服务费',
            'subitems'  => [
                '0'     => '个人用户代办服务费',
                '1'     => '企业用户代办服务费'
            ]
        ]
    ];

    public function get_recharge_code(){

        return static::$type_codes[ 'recharge' ];
    }

    public function get_express_code(){

        return static::$type_codes[ 'express' ];
    }

    public function get_service_code(){

        return static::$type_codes[ 'service' ];
    }

    /**
     * 获得普通充值分类的子项
     * 
     * @return string
     */
    public static function get_recharge_subitem( $user_type ){

        return $user_type;
    }

    /**
     * 获得快递费分类的子项
     * 
     * @return string
     */
    public static function get_express_subitem( $user_type ){

        return $user_type;
    }

    /**
     * 获得服务费分类的子项
     * 
     * @return string
     */
    public static function get_service_subitem( $user_type ){

        return $user_type;
    }

    /**
     * 获得目录
     *
     * @return array
     */
    public static function get_all_types(){

        return static::$types_map;
    }

    /**
     * 获得子目录
     *
     * @return array
     */
    public static function get_subitems( $category ){

        return static::$types_map[ $category ][ 'subitems' ];
    }

    /**
     * 获得分类名称
     *
     * @return array
     */
    public static function get_category_name( $category ){

        return static::$types_map[ $category ][ 'name' ];
    }

    /**
     * 获得所有分类名称
     * 
     * @return array    ['10' => '普通充值', '20' => '快递费']
     */
    public static function get_all_category(){

        $result = [];

        foreach ( static::$types_map as $key => $value ){
            $result[ $key ] = $value[ 'name' ];
        } 

        return $result;
    }

    /**
     * 判断分类是否存在 
     *
     * @return bool
     */
    public static function is_category_exists( $category ){

        return array_key_exists( $category, static::$types_map );
    }
    
    /**
     * 获得细项名称
     *
     * @return string
     */
    public static function get_subitem_name( $category, $item ){

        return static::$types_map[ $category ][ 'subitems' ][ $item ];
    }

    /**
     * 获得分类以及细想名称
     *
     * @return array
     */
    public static function get_category_and_subitem_names( $category, $item ){

        return [
            'category'  => static::$types_map[ $category ][ 'name' ],
            'item'      => static::$types_map[ $category ][ 'subitems' ][ $item ]
        ];
    }

    /**
     * 生成主键时所用的前缀
     */
    protected static $id_prefix = 'fylx';

    /**
     * 获取用户费用
     */
    public function user_fee(){

        return $this->hasOne( 'UserFee', 'fee_type_id', 'id' );
    }

    /**
     * 获取对应费用明细
     */
    public function cost_details(){

        return $this->hasMany( 'CostDetail', 'fee_type_id', 'id' );
    }
}