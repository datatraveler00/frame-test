<?php
/***************************************************************************
 *
 * Copyright (c) 2015 Meilishuo.com, Inc. All Rights Reserved
 *
 **************************************************************************/



/**
 * @file   Connect.class.php
 * @author 荣小龙(xiaolongrong@meilishuo.com)
 * @date   2015/12/23
 * @brief  passport-connect-sdk
 *
 **/

namespace Services\Passport;

use \Services\Passport\Base\PassportClient;
use \Services\Passport\Base\ErrorCode;

class Connect {

    /***
     * 批量获取外站用户信息
     *
     * @param string      $channel     互联渠道(目前仅支持weixin)
     * @return data
     *                    2            参数错误
     *                    array        成功时返回外站用户信息
     **/
    public static function get_outsite_user_info($channel = '', $uids = '') {
        if ( empty($channel) || empty($uids) ) {
            return ErrorCode::get(ErrorCode::PARAM_ERROR);
        }

        if (is_array($uids)) {
            $uids = join(',', $uids);
        }
        $channel = (string)$channel;
        $uids = (string)$uids;

        $params = array(
            'channel' => $channel,
            'uids' => $uids
        );
        $result = PassportClient::post('connect/get_outsite_user_info', $params);
        return $result;
    }
}
/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */