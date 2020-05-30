<?php
/**
 * WP_REMOTE方法的易用封装
 * @author Yetu <admin@azimiao.com>
 */
    class WPNetwork{
        public static function http_get_contents($_url,$_getHeader = array())
        {
            $m_req = wp_remote_get($_url,array("headers"=>$_getHeader));
            $m_res = wp_remote_retrieve_body($m_req);
            return $m_res;
        }
        //post获取内容
        public static function http_post_contents($_url,$_postHeader = array(),$_postBody  = array())
        {
            $m_req = wp_remote_post($_url,array('headers'=>$_postHeader,'body' => $_postBody));
            $m_res = wp_remote_retrieve_body($m_req);
            return $m_res;
        }
    }

?>