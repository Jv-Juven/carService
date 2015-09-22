<?php

/*
 * Base Model
 */
class BaseModel extends Eloquent{

    /*
     * 子类中调用该方法前，需实现
     *      [public|private|protected] static function get_id_prefix();
     *      返回字符串
     */
    protected static function get_unique_id(){

        return str_replace('.', '', uniqid( self::get_id_prefix(), true ) );
    }
}