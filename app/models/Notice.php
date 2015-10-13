<?php   

class Notice extends Eloquent{
    
    protected $table        = 'notices';

    protected $hidden       = [];
    protected $fillable     = [
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

        return $this->hasMany( 'UserReadNotice', 'notice_id', 'id' );
    }
}