<?php
/***************************************************************************
 *
 * Copyright (c) 2015 Meilishuo.com, Inc. All Rights Reserved
 *
 **************************************************************************/



/**
 * @file    Config.class.php
 * @author  李守岩(shouyanli@meilishuo.com)
 * @date    2015/12/23
 * @brief   passport sdk config
 *
 **/

namespace Services\Passport\Base;

class Config {

    private static $timeout_ms = null;

    /* 设置超时时间毫秒 */
    public static function setTimeOutMs($timeout) {
       if (!is_numeric($timeout)) {
            return false;    
       }

       self:$timeout_ms = $timeout < 10 ? 10 :$timeout;
       return true;
    }

    /* 获取超时时间 */
    public static function get() {

        $conf = \Frame\ConfigFilter::instance()->getConfig('passport');
        if (empty($conf)) return false;
        if (!empty(self::$timeout_ms)) {
            $conf['timeout_ms'] = self::$timeout_ms;
        } elseif ( empty($conf['timeout_ms']) || !is_numeric($conf['timeout_ms'])){
            $conf['timeout_ms'] = 500;
        } 
        return $conf;
    }
}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
