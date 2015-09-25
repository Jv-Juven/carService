<?php 

class Notice extends BaseModel{
    
    protected $table        = 'notices';
    protected $primaryKey   = 'notice_id';

    protected $hidden       = [];
    protected $fillable     = [
        'notice_id',
        'title',
        'content'
    ];

    /*
     * 生成主键时所用的前缀
     */
    protected static $id_prefix = 'tzzx';

    /* 
     * 获取读过该通知的用户
     */
    public function users_read(){

        return $this->hasManyThrough( 'User', 'UserReadNotice', 'notice_id', 'user_id' );
    }

    /* 
     * 获取读过该通知的用户id
     */
    public function users_read_id(){

        return $this->hasMany( 'UserReadNotice', 'notice_id', 'notice_id' );
    }

    /*
    *每条通知是否被读过
    */
    public function notice_user_id(){

        return $this->belongsTo( 'UserReadNotice', 'notice_id', 'notice_id' );
    }
    /**
     * 监听创建事件
     */
    public static function boot(){

        parent::boot();

        self::creating(function( $notice ){
            $notice->notice_id = self::get_unique_id( self::$id_prefix );
            return true;
        });
    }
}