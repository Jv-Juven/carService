<?php 

class UserReadNotice extends Eloquent{
    
    protected $table        = 'user_read_notice';

    protected $hidden       = [];
    protected $fillable     = [
        'user_id',
        'notice_id'
    ];

    /*
     * 获取相应用户
     */
    public function user(){

        return $this->belongsTo( 'User', 'user_id', 'user_id' );
    }

    /*
     * 获取相应通知
     */
    public function notice(){

        return $this->belongsTo( 'Notice', 'notice_id', 'id' );
    }
}