<?php
/***************************************************************************
 *
 * Copyright (c) 2015 Meilishuo.com, Inc. All Rights Reserved
 *
 **************************************************************************/



/**
 * @file    PassportClient.class.php
 * @author  李守岩(shouyanli@meilishuo.com)
 * @date    2015/12/17
 * @brief   passport sdk client
 *
 **/

namespace Services\Passport\Base;

use \Services\Passport\Base\Constants;
use \Services\Passport\Base\ErrorCode;
use \Services\Passport\Base\PassportCurl;
use \Services\Passport\Base\Config;

class PassportClient {
    
    public static function post($api, $params) {
        
        //$conf = \Frame\ConfigFilter::instance()->getConfig('passport');
        $conf = Config::get();
        if (empty($conf)) return ErrorCode::get(ErrorCode::CONF_ERROR);
        
        $params['app_id']  = $conf['app_id'];
        $params['app_key'] = $conf['app_key'];


        $service = Constants::$env[$conf['env']];
        if (!$service) { return ErrorCode::get(ErrorCode::CONF_ERROR); }
       
        $curl = new PassportCurl();
        $curl->setTimeOutMs($conf['timeout_ms']);
        $res = $curl->post($service.$api, $params);	
        return $res; 
    }
   
    /*
        设置超时时间，返回调用的类名
    */ 
    public static function setTimeout($timeout) {
        Config::setTimeOutMs($timeout);     
        $class = get_called_class();
        return $class;
    } 
    
}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
