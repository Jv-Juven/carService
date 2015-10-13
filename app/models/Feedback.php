<?php 

class Feedback extends Eloquent{
    
    protected $table        = 'feedbacks';
    protected $primaryKey   = 'feedback_id';

    protected $hidden       = [];
    protected $fillable     = [
        'feedback_id',
        'user_id',
        'type',
        'title',
        'content'
    ];

    /*
     * 获取用户信息
     */
    public function user(){

        return $this->belongsTo( 'User', 'user_id', 'user_id' );
    }
}