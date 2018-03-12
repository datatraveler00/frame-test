<?php
/***************************************************************************
 *
 * Copyright (c) 2015 Meilishuo.com, Inc. All Rights Reserved
 *
 **************************************************************************/



/**
 * @file   User.class.php
 * @author 李守岩(shouyanli@meilishuo.com)
 * @date   2015/12/17
 * @brief  passport sdk user
 *
 **/

namespace Services\Passport;

use \Services\Passport\Base\PassportClient;
use \Services\Passport\Base\ErrorCode;

class User {

    /* 获取用户信息 */
    public static function infos($user_ids, $fields = '') {

        if (empty($user_ids)) {
            return ErrorCode::get(ErrorCode::PARAM_ERROR); 
        }

        if (is_array($user_ids)) {
            $user_ids = join(',', $user_ids);    
        }

        $param = array(
            'user_ids'   => $user_ids, 
            'fields'     => $fields,
            'hash'       => 1,
        );

        $result = PassportClient::post('user/infos', $param);
        
        return $result;
    }


}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
