<?php
/***************************************************************************
 *
 * Copyright (c) 2015 Meilishuo.com, Inc. All Rights Reserved
 *
 **************************************************************************/



/**
 * @file    ErroCode.class.php
 * @author  李守岩(shouyanli@meilishuo.com)
 * @date    2015/12/17
 * @brief   passport sdk session
 *
 **/

namespace Services\Passport\Base;

class ErrorCode {
    /* Local Basic Error */
    const CONF_ERROR                    = 1;
    const PARAM_ERROR                   = 2;
    const CURL_RPC_ERROR                = 3;

    /* RPC Error  */
    const API_PARAM_ERROR               = 40001;
    const API_RETURN_ERROR              = 40004;

    const API_LOGIN_PASS_ERROR          = 1001;
    const API_MOBLE_EXIST_ERROR         = 1003;


    public static $codes = array(
         1     => 'Can not get correct configuration from passport config file',/* 无法获取正确配置 */
         2     => 'Param Error',/* 输入参数错误 */
         3     => 'Remote Service Call Failed',/* 后端服务调用失败  */
         40001 => 'Api Param Error',/* 接口发现参数错误 */
         40004 => 'Api cannot get return data',/* 数据库中未找到对应记录 */
         1001  => 'User Login Password Failed',/* 数据库中未找到对应记录 */
         1003  => 'User Login Mobile not exists',/* 数据库中未找到对应记录 */
    );

    public static function get($errno, $errmsg='') {
        $message = self::$codes[$errno];
        if (!empty($errmsg)) {
            $message = $errmsg;
        }
        return array(
            'error_code'  => $errno,
            'message'     => $message,
            'data'        => false,
        );
    }
}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
