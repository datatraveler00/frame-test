<?php
/***************************************************************************
 *
 * Copyright (c) 2015 Meilishuo.com, Inc. All Rights Reserved
 *
 **************************************************************************/



/**
 * @file    Constants.class.php
 * @author  陈益杰(yijiechen@meilishuo.com)
 * @date    2015/12/18
 * @brief   passport sdk 配置常量 
 *
 **/

namespace Services\Passport\Base;

class Constants {

    const ONLINE_URL = 'http://passport.mlservice.meilishuo.com/';
    const NEWLAB_URL = 'http://passport.mlservice.newlab.meilishuo.com/';
    const DEVLAB_URL = 'http://passport.mlservice.passport.rdlab.meilishuo.com/';
 

    public static $env = array(
        'online' => self::ONLINE_URL,
        'newlab' => self::NEWLAB_URL,
        'devlab' => self::DEVLAB_URL,
    );

}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
