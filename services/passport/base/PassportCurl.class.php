<?php
/***************************************************************************
 *
 * Copyright (c) 2015 Meilishuo.com, Inc. All Rights Reserved
 *
 **************************************************************************/



/**
 * @file    PassportCurl.class.php
 * @author  李守岩(shouyanli@meilishuo.com)
 * @date    2015/12/17
 * @brief   passport curl
 *
 **/

namespace Services\Passport\Base;

use \Services\Passport\Base\PassportLog;

class PassportCurl {
    
    var $userAgent = "Passport Libs SDK/1.0()";
    var $cookie = false;
    var $proxy = "";
    var $ch = NULL;
    var $url = '';

    var $haveHeader = TRUE;

    var $followLocation = TRUE;
    var $freshConnect = TRUE;

    var $encodingMethod = 'gzip';

    var $timeOut = 30;

    var $timeOutMs = 0;

    var $addHeader = array();

    function __construct() {
        $this->initialize();
    }

    /**
     * 初始化，来开启一个curl
     * @param NULL
     * @return TRUE
     */
    private function initialize() {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);

        return TRUE;
    }

    /**
     * 一坨opt set
     * @param NULL
     * @return TRUE
     */
    private function setOpt() {
        //curl_setopt($this->ch, CURLOPT_HEADER, $this->haveHeader);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);//$this->haveHeader);
        curl_setopt($this->ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, $this->followLocation);
        curl_setopt($this->ch, CURLOPT_FRESH_CONNECT, $this->freshConnect);
        curl_setopt($this->ch, CURLOPT_ENCODING, $this->encodingMethod);
        curl_setopt($this->ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
    
        //兼容老的curl版本
        defined('CURLOPT_TIMEOUT') || define('CURLOPT_TIMEOUT', 1);
        defined('CURLOPT_CONNECTTIMEOUT') || define('CURLOPT_CONNECTTIMEOUT', 7);
        defined('CURLOPT_TIMEOUT_MS') || define('CURLOPT_TIMEOUT_MS', 155);
        defined('CURLOPT_CONNECTTIMEOUT_MS') || define('CURLOPT_CONNECTTIMEOUT_MS', 156);

        if ($this->timeOutMs) {
            curl_setopt($this->ch, CURLOPT_NOSIGNAL, 1);
            curl_setopt($this->ch, CURLOPT_TIMEOUT_MS, $this->timeOutMs);
            curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT_MS, $this->timeOutMs);
        } else {
            curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeOut);
        }

        if (!empty($this->addHeader)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->addHeader);
        }

        return TRUE;
    }

    /**
     * 超时时间(ms)设置
     * @param int
     * @return TRUE
     */
    public function setTimeOut($timeOut = 1) {
        //return curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeOutMs);
        return $this->timeOut = $timeOut;
    }

    public function setTimeOutMs($timeOutMs = 200) {
        return $this->timeOutMs = $timeOutMs;
    }

    /**
     * 被ban的时候用代理
     * @param string
     * @return TRUE
     */
    public function setProxy($proxy) {
        curl_setopt($this->ch, CURLOPT_PROXY, $this->proxy);
        return TRUE;
    }

    /*
     * 是否输出头信息
     * */
    public function setNeedHeader($need_header = FALSE) {
        $this->haveHeader = (bool)$need_header;
        return TRUE;
    }

    /**
     * 设置cookie时候用
     * @param string
     * @return TRUE
     * @todo cookie 用file实现
     */
    public function cookie($cookie) {
        curl_setopt($this->ch, CURLOPT_COOKIE, $cookie);
    }

    /**
     * to curl
     * @param string
     * @return string
     */
    private function curl($url = '') {
        $this->setOpt();
        curl_setopt($this->ch, CURLOPT_URL, $url);

        //超时重试
        $retry = 0;
        $result = array();
        while ($retry <= 1) {
            $ret      = curl_exec($this->ch);
            $curl_errno  = curl_errno($this->ch);
            $curl_errmsg = curl_error($this->ch);
            
            if ($curl_errno === 0) {
                $result = json_decode($ret,true);
                break;
            } else {
                $errmsg = "Curl Error curl_errno:$curl_errno, curl_errmsg:$curl_err";
                return ErrorCode::get(ErrorCode::CURL_RPC_ERROR,$errmsg);
            }
            
            $info = curl_getinfo($this->ch);
          
            PassportLog::logger('passport.'.$this->params_tmp['app_id'], 
                "[curl_errno:$curl_errno]\t[curl_errmsg:$err]\t[retry:$retry]\t[$url]\t[{$info['http_code']}]\t[" . 
                json_encode($this->params_tmp). "]" );
            
            $retry++;
        }
        curl_close($this->ch);
        return $result;
    }

    /**
     * post method
     * @param string
     * @param array
     * @return array
     */
    public function post($url = '', $params = array()) {
        $checkPos = strpos($url , "#");
        if ( $checkPos !== false ) {
            $url = substr( $url , 0 , $checkPos );
        }
        if (trim($url) == '') {
            return TRUE;
        }
        curl_setopt($this->ch, CURLOPT_POST, TRUE);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $this->params_tmp = $params;
        
        return $this->curl($url);
    }

    /**
     * post method
     * @param string
     * @param array
     * @return array
     */
    public function get($url, $referer = '') {
        $checkPos = strpos( $url , "#");
        if ( $checkPos !== false ) {
            $url = substr( $url , 0 , $checkPos );
        }
        if (trim($url) == '') {
            return TRUE;
        }
        return $this->curl($url);
    }

    /**
     * post method
     * @param string
     * @param array
     * @return array
     */
    public function setAgent($userAgent) {
        if(!empty($userAgent)) {
            $this->userAgent = $userAgent;
        }
        return TRUE;
    }


    public function addHeader($headers) {
        if (empty($headers)) {
            return TRUE;
        }
        $this->addHeader = $headers;
    }

}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
