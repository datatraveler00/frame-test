<?php
/***************************************************************************
 *
 * Copyright (c) 2015 Meilishuo.com, Inc. All Rights Reserved
 *
 **************************************************************************/



/**
 * @file    PassportLog.class.php
 * @author  李守岩(shouyanli@meilishuo.com)
 * @date    2015/12/17
 * @brief   passport sdk log
 *
 **/

namespace Services\Passport\Base;

use \Libs\Log\ProxyLogWriter;
use \Libs\Log\ScribeLogCollector;

class PassportLog {
    
    public static function logger($name, $str) {
        $scribe = new ScribeLogCollector(); 
        $logger = new ProxyLogWriter($scribe);
        $logger->write($name, "[". date('Y-m-d H:i:s') ."]\t" . $str . "\t[" . $_SERVER['REQUEST_URI'] . "]");
    }
}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
