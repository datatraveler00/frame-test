<?php
namespace Libs\Util;

class HuodongUtils {

    const	CLIENT_URL = '//share.meilishuo/?json_params=';
    const	WAP_URL = 'http://m.meilishuo.com/';

    /**
     * 给指定连接加r参数
     * @param string $str eg：meilishuo://twitter_single.meilishuo?json_params=%7B%22twitter_info%22%3A%7B%22twitter_id%22%3A%221111%22%7D%7D
     * @param string $r 统计参数
     * @return string
     */
    public static function addStatParam($str, $r, $type = 'wap2client') {
        if (empty($r)) {
            return $str;
        }
        if ($type == 'wap2client') {
            $arr = parse_url($str);
            $query = explode('=', $arr['query']);
            $content = json_decode(urldecode($query[1]), TRUE);
            $twitter_id = !empty($content['twitter_info']['twitter_id']) ? $content['twitter_info']['twitter_id'] : '';
            $r = $r . '.' . self::getRequestUrlParams() . (isset($twitter_id) ? ':twitter_id=' . $twitter_id : ''); 
            $content['r'] = $r;
            return $arr['scheme'] . '://' . $arr['host'] . '?json_params=' . urlencode(json_encode($content));
        }
        return $str;
    }

    /**
     * 获取请求url的path及query,供r参数使用
     * 1_m-   :   m.meilishuo.com
     * 2_mapp-   :   mapp.meilishuo.com
     */
    public static function getRequestUrlParams() {
        $request_url = $_SERVER['HTTP_REQURL'];
        $arr = parse_url($request_url);
        $query_arr = self::convertUrlQuery($arr['query']);
        unset($query_arr['r']);
        unset($query_arr['app_version']);
        if (isset($query_arr['hdtrc']) ) {
            unset($query_arr['hdtrc']);
        }
        if (isset($arr['path']) && !empty($arr['path'])) {
            $path =  rtrim(ltrim($arr['path'], '/'), '/');
            $path_str = str_replace('/', '_', $path);
        }
        else {
            $path_str = 'main';
        }
        return '1_m-' . $path_str . ':' . http_build_query($query_arr, '', ':');
    }

    /** 
     * Returns the url query as associative array 
     * 
     * @param    string    query 
     * @return    array    params 
     */ 
    private static function convertUrlQuery($query) { 
        $queryParts = explode('&', $query); 
        
        $params = array(); 
        foreach ($queryParts as $param) { 
            $item = explode('=', $param); 
            $params[$item[0]] = $item[1]; 
        } 
        
        return $params; 
    }

    /**
     * 获取设备Scheme
     */
    public static function getDeviceScheme() {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if (stripos($agent, 'iPad') !== false) {
            $prex = 'meilishuohd:';
        } elseif (stripos($agent, 'iPhone') !== false){
            $prex = 'meilishuo:';
        } elseif (stripos($agent, 'Android') !== false){
            $prex = 'meilishuo:';
        } else {
            $prex = 'meilishuo:';
        }
        return $prex;
    }

    /**
     * 得到客户端单宝链接
     * @param int $twitter_id 推id
     * @param string $r 统计参数
     * @return string
     */
    public static function getClientTwitterUrl($twitter_id, $r, $in_app=true) {
        if ($in_app) {
            $params = array(
                'twitter_info' => array('twitter_id' => $twitter_id),
                'r' => $r,
            );
            return self::getDeviceScheme() . '//twitter_single.meilishuo/?json_params=' . urlencode(json_encode($params));
        }else{
            return self::WAP_URL . 'share/' . $twitter_id;
        }
    }

    public static function getClientTwitterUrlDoota($twitter_id, $isDoota, $r, $in_app=true) {
        if ($in_app) {
            $params = array(
                'twitter_info' => array('twitter_id' => $twitter_id, 'is_doota' => $isDoota),
                'r' => $r,
            );
            return self::getDeviceScheme() . '//twitter_single.meilishuo/?json_params=' . urlencode(json_encode($params));
        }else{
            return self::WAP_URL . 'share/item/' . $twitter_id;
        }
    }

    /**
     * 获取客户端单宝链接
     * @param array $params
     * @return string
     */
    public static function getClientUrl($params) {
        return self::getDeviceScheme() . self::CLIENT_URL . urlencode(json_encode($params));
    }


    /**
     *
     * shop没有wap页
     *
     */
    public static function getClientShopUrl($shop_id, $r) {
        $params = array(
            'shop_id' => $shop_id,
            'r' => $r,
        );
        return self::getDeviceScheme() . '//shop.meilishuo/?json_params=' . urlencode(json_encode($params));
    }
}
