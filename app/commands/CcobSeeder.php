<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CcobSeeder extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ccob_seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '插入随机数据';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected static $seconds_per_day   = 86400;
    protected static $seconds_per_month = 2419200;
    protected static $seconds_per_year  = 29030400;

    protected static $RANDOM_NUM        = 0x01;
    protected static $RANDOM_ALPHA      = 0x10;
    protected static $RANDOM_ALPHA_NUM  = 0x11;

    protected static $ALPHA_LOWER       = 'abcdefghijklmnopqrstuvwxyz';
    protected static $ALPHA_UPPER       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    protected static $NUMBER            = '0123456789';
    protected static $TELEPHONE_PREFIX  = [
        '130','131','132','133','134','135','136','137','138','139',
        '180','181','182','183','184','185','186','187','188','189',
        '150','151','152','153','155','156','157','158','159',
        '175','176','177','178','179'
    ];

    protected function get_random_timestamp_offset(){
        $offset_year = rand( 0, 2 ) - 1;
        $offset_month = rand( 0, 4 ) - 2;
        $offset_day = rand( 0, 7 ) - 3;

        return  $offset_year * self::$seconds_per_year + 
                $offset_month * self::$seconds_per_month + 
                $offset_day * self::$seconds_per_day;
    }

    protected function get_random_datetime(){

        return date( 'Y-m-d H:i:s', time() + $this->get_random_timestamp_offset() );
    }

    protected function get_random_date(){   
        
        return date( 'Y-m-d', time() + $this->get_random_timestamp_offset() );
    }

    protected function get_random_time(){

        return date( 'H:i:s', time() + $this->get_random_timestamp_offset() );
    }

    protected function get_random( $flag, $min, $max ){

        $bs = '';

        if ( $flag & self::$RANDOM_ALPHA ){
            $bs .= self::$ALPHA_UPPER.self::$ALPHA_LOWER;
        }

        if ( $flag & self::$RANDOM_NUM ){
            $bs .= self::$NUMBER;
        }

        $i = 0;
        $rstr = '';
        $bs_count = strlen( $bs );

        while( $i < $max ){

            $rstr .= $bs[ rand( 0, $bs_count - 1 ) ];

            if ( $this->stop() && $i >= $min ){
                return $rstr;
            }

            ++$i;
        }

        return $rstr;
    }

    protected function stop(){

        return rand( 0, 1 );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        DB::transaction(function(){
            $this->create_users();
            $this->create_agency_orders();
            $this->create_refund_records();
            $this->create_fee_types();
            $this->create_user_fee();
            $this->create_cost_details();
            $this->create_notices();
            $this->create_user_read_notice();
            $this->create_feedbacks();
        });
    }

    /**
     * 插入随机数据
     */
    protected function create_users( $total = 20 ){

        echo 'Creating users...';

        for ( $i = 0; $i < $total; ++$i ){
            Sentry::createUser([
                'login_account' => $this->get_random( static::$RANDOM_ALPHA_NUM, 12, 12 ),
                'password'      => '123456',
                'status'        => '22',
                'user_type'     => rand( 0, 2 ) ? '0' : '1',
                'activated'     => true
            ]);
        }

        $users = User::with( 'business_info' )->get();

        foreach ( $users as $user ){
            if ( $user->user_type == '1' && !isset( $user->business_info ) ){
                $business_info = new BusinessUser();
                $business_info->user_id = $user->user_id;
                // $app_config = BusinessController::get_appkey_appsecret_from_remote( $user->user_id );
                // $business_info->app_key = $app_config['appkey'];
                // $business_info->app_secret = $app_config['secretkey'];
                $business_info->save();
            }
        }

        echo 'Done'.PHP_EOL;
    }

    /**
     * 插入随机数据
     */
    protected function create_agency_orders( $total = 200 ){

        echo 'Creating agency_orders...';

        $users = User::all();

        for ( $i = 0; $i < $total; ++$i ){

            $user = $users[ rand( 0, $users->count() - 1 ) ];

            //DB::transaction(function() use ( $user ){
                $order_id = AgencyOrder::get_unique_id( );
                $agency_order = new AgencyOrder();
                $agency_order->order_id = $order_id;
                $agency_order->user_id = $user->user_id;
                $agency_order->pay_platform = rand( 0, 1 ) ? '0': '1';
                $agency_order->pay_time = $this->get_random_datetime();
                $agency_order->pay_trade_no = uniqid( 'ptn', true );
                $agency_order->car_plate_no = '粤A12N12';
                $agency_order->capital_sum = (float)( rand( 500, 1000 ) / 10 );
                $agency_order->late_fee_sum = (float)( rand( 500, 1000 ) / 20 );
                $agency_order->service_charge_sum = (float)( rand( 500, 1000 ) / 10 );
                if($i % 5 == 0)
                    $agency_order->process_status = '4';
                else if($i % 5 == 1)
                    $agency_order->process_status = '3';
                else if($i % 5 == 2)
                    $agency_order->process_status = '2';
                else if($i % 5 == 3)
                    $agency_order->process_status = '1';
                else
                    $agency_order->process_status = '0';
                $agency_order->car_type_no = '01';
                $agency_order->agency_no = rand( 1, 3 );

                if ( $agency_order->save() ){
                    for ( $j = 0; $j < $agency_order->agency_no; ++$j ){
                        $traffic_info = new TrafficViolationInfo;
                        $traffic_info->order_id = $order_id;
                        $traffic_info->req_car_plate_no = '粤A12N12';
                        $traffic_info->req_car_engine_no = '123123';
                        $traffic_info->car_type_no = 'AAA';
                        $traffic_info->req_car_frame_no = '123123';
                        $traffic_info->rep_event_time = $this->get_random_datetime();
                        $traffic_info->rep_event_addr = '番禺区大学城';
                        $traffic_info->rep_violation_behavior = 'Fuck a dog';
                        $traffic_info->save();
                    }
                }
            //});
        }

        echo 'Done'.PHP_EOL;
    }

    /**
     * 插入随机数据
     */
    protected function create_refund_records( $total = 50 ){

        echo 'Creating refund_records...';

        $orders = AgencyOrder::limit( $total )->get();

        foreach( $orders as $order ){
            $refund_record = new RefundRecord();
            $refund_record->order_id = $order->order_id;
            $refund_record->user_id = $order->user_id;
            if ( rand( 0, 1 ) ){
                $refund_record->approval_at = $this->get_random_datetime();
                $refund_record->comment = 'hhhhhhhhhhhh';
                $refund_record->status = '2';
            }else{
                $refund_record->status = '0';
            }
            $refund_record->save();
        }

        echo 'Done'.PHP_EOL;
    }

    /**
     * 插入随机数据
     */
    protected function create_fee_types( ){
        
        if ( FeeType::all()->count() == 0 ){
            FeeType::create([
                'category' => '10',
                'item'  => '0',
                'number' => 15,
                'flow_direction' => 1,
                'user_type' => 0
            ]);
            FeeType::create([
                'category' => '20',
                'item'  => '0',
                'number' => 15,
                'flow_direction' => 1,
                'user_type' => 0
            ]);

            FeeType::create([
                'category' => '20',
                'item'  => '1',
                'number' => 20,
                'flow_direction' => 1,
                'user_type' => 1
            ]);

            FeeType::create([
                'category' => '30',
                'item'  => '0',
                'number' => 15,
                'flow_direction' => 1,
                'user_type' => 0
            ]);

            FeeType::create([
                'category' => '30',
                'item'  => '1',
                'number' => 20,
                'flow_direction' => 1,
                'user_type' => 1
            ]); 
        }
    }

    /**
     * 插入随机数据
     */
    protected function create_user_fee( $total = 5 ){
        // ...
    }

    /**
     * 插入随机数据
     */
    protected function create_cost_details( $total = 300 ){
        
        echo 'Creating cost_details...';

        $c_user_fee = FeeType::whereIn( 'user_type', ['0', '1'] )->get();
        $b_user_fee = FeeType::where( 'user_type', '1' )->get();

        $users = User::all();

        foreach ($users as $user ) {
            for ( $i = 0; $i < $total; ++$i ){
                //$user           = $users[ rand( 0, $users->count() - 1 ) ];
                $fee_type       = $user->user_type == '0' ? 
                    $c_user_fee[rand( 0, $c_user_fee->count() - 1 )] : $b_user_fee[rand( 0, $b_user_fee->count() - 1 )];
                
                $cost_detail                = new CostDetail();
                $cost_detail->user_id       = $user->user_id;
                $cost_detail->fee_type_id   = $fee_type->id;
                $cost_detail->number        = $fee_type->number;
                $cost_detail->created_at    = $this->get_random_datetime();
                $cost_detail->save();
            }
        }

        echo 'Done'.PHP_EOL;
    }

    /**
     * 插入随机数据
     */
    protected function create_notices( $total = 50 ){

        echo 'Creating notices...';

        for ( $i = 0; $i < 50; ++$i ){
            $notice = new Notice();
            $notice->title      = $this->get_random( self::$RANDOM_ALPHA, 32, 32 );
            $notice->content    = $this->get_random( self::$RANDOM_ALPHA_NUM, 50, 100 );
            $notice->created_at = $this->get_random_datetime();
            $notice->save();
        }

        echo 'Done'.PHP_EOL;
    }

    /**
     * 插入随机数据
     */
    protected function create_user_read_notice(){

        echo 'Creating user_read_notice...';

        $users = User::all();
        $notices = Notice::all();

        foreach ( $users as $user ){
            foreach ( $notices as $notice ){
                if ( rand( 0, 2 ) ){
                    $user_read_notice = new UserReadNotice();
                    $user_read_notice->user_id = $user->user_id;
                    $user_read_notice->notice_id = $notice->id;
                    $user_read_notice->save();
                }
            }
        }

        echo 'Done'.PHP_EOL;
    }

    /**
     * 插入随机数据
     */
    protected function create_feedbacks(){

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
        );
    }

}
