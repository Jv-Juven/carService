<?php 

class BusinessUser extends Eloquent{
    
    protected $table        = 'business_users';
    protected $primaryKey   = 'user_id';

    protected $hidden       = [];
    protected $fillable     = [
        'user_id',
        'balance',
        'app_key',
        'app_secret',
        'business_name',
        'business_licence_no',
        'business_licence_scan_path',
        'operational_name',
        'operational_card_no',
        'operational_phone',
        'bank_account',
        'deposit_bank',
        'bank_outlets',
        'id_card_front_scan_path',
        'id_card_front_scan_path',
        'id_card_front_scan_path'
    ];

    /*
     * 获得所属用户
     */
    public function user(){

        return $this->belongsTo( 'User', 'user_id', 'user_id' );
    }
}