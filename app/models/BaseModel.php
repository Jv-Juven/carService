<?php

/*
 * Base Model
 */
class BaseModel extends Eloquent{

    /**
     * 获得模型对应表的主键
     * 
     * @return  mixed
     */
    public function get_primary_key(){

        return $this->primaryKey;
    }

    /**
     * 获得唯一id
     * 
     * @param   $prefix id前缀
     * 
     * @return  string
     */
    public static function get_unique_id( $prefix ){

        return str_replace('.', '', uniqid( $prefix, true ) );
    }

    /**
     * 获得生成唯一id时的前缀
     * 
     * @return  string
     */
    public static function get_id_prefix(){

        return static::$id_prefix;
    }

    /**
     * 监听模型事件
     * 
     * @param   $prefix id前缀
     * 
     */
    public static function boot(){

        parent::boot();

        self::creating(function( $record ){
            
            $primary_key = $record->get_primary_key();

            if ( !isset( $record[ $primary_key ] ) ){
                $record[ $primary_key ] = static::get_unique_id( $record->get_id_prefix() );
            }

            return true;
        });
    }
}
