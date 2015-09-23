<?php

/*
 * Base Model
 */
class BaseModel extends Eloquent{

    /**
     * 获得唯一id
     * 
     * @param   $prefix id前缀
     * 
     * @return  string
     */
    protected static function get_unique_id( $prefix ){

        return str_replace('.', '', uniqid( $prefix, true ) );
    }
}