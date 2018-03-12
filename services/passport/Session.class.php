<?php
/***************************************************************************
 *
 * Copyright (c) 2015 Meilishuo.com, Inc. All Rights Reserved
 *
 **************************************************************************/



/**
 * @file   Session.class.php
 * @author 李守岩(shouyanli@meilishuo.com)
 * @date   2015/11/27
 * @brief  passport sdk session
 *
 **/


namespace Services\Passport;

use \Services\Passport\Base\PassportClient;
use \Services\Passport\Base\ErrorCode;

class Session {

    /* 获取mob session*/ 
    public static function get_web($access_token) {
        return self::get($access_token, 'web');    
    }
   
    /* 获取mob session */ 
    public static function get_mob($access_token) {
        return self::get($access_token, 'mob');    
    }

    public static function get($access_token, $source = '') {
        if (empty($access_token) || mb_strlen($access_token) != 32) {
            return ErrorCode::get(ErrorCode::PARAM_ERROR); 
        }

        $param = array(
            'session_id'   => $access_token, 
            'source'       => $source,
        );

        $result = PassportClient::post('user/is_login', $param);
        
        return $result;
    }

}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
