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
     * 获得生成主键时所用的前缀
     */
    protected static function get_id_prefix(){

        return 'tzzx';
    }

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
}