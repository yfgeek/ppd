<?php

namespace Admin\Model;

use Think\Model;

class ApiModel extends Model{

    /**
     * 排序Request至待签名字符串
     *
     * @param $request: json格式Request
     */
    function sortToSign($request){
        $obj = json_decode($request);
        $arr = array();
        foreach ($obj as $key=>$value){
            if(is_array($value)){
                continue;
            }else{
                $arr[$key] = $value;
            }
        }
        ksort($arr);
        $str = "";
        foreach ($arr as $key => $value){
            $str = $str.$key.$value;
        }
        $str = strtolower($str);
        return $str;
    }


    /**
     * RSA私钥签名
     *
     * @param $signdata: 待签名字符串
     */
    function sign($signdata){
        $appPrivateKey = C('APPPVK');
        if(openssl_sign($signdata,$sign,$appPrivateKey))
            $sign = base64_encode($sign);
        return $sign;
    }


    /**
     * RSA公钥验签
     *
     * @param $signdata: 待签名字符串
     * @param $signeddata: 已签名字符串
     */
    function verify($signdata,$signeddata){
        $appPublicKey = C('APPPBK');
        $signeddata = base64_decode($signeddata);
        if (openssl_verify($signdata, $signeddata, $appPublicKey))
            return true;
        else
            return false;
    }


    /**
     * RSA公钥加密
     *
     * @param $encryptdata: 待加密字符串
     */
    function encrypt($encryptdata){
        $appPublicKey = C('APPPBK');
        openssl_public_encrypt($encryptdata,$encrypted,$appPublicKey);
        return base64_encode($encrypted);
    }


    /**
     * RSA私钥解密
     *
     * @param $decryptdata: 待解密字符串
     */
    function decrypt($encrypteddata){
         $appPrivateKey = C('APPPVK');
        openssl_private_decrypt(base64_decode($encrypteddata),$decrypted,$appPrivateKey);
        return $decrypted;
    }


    function SendAuthRequest($url, $request) {
    	$curl = curl_init ( $url );
    	$header = array ();
    	$header [] = 'Content-Type:application/json;charset=UTF-8';

    	curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header );
    	curl_setopt ( $curl, CURLOPT_POST, 1 );
    	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $request );
    	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
    	curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    	curl_setopt($curl, CURLOPT_TIMEOUT, 30);

    	$result = curl_exec ( $curl );
    	curl_close ( $curl );

    // 	$auth = json_decode ( $result, true );
    // 	if ($auth == NULL || $auth == false) {
    // 		return $result;
    // 	}
    // 	return $auth;

    	return $result;
    }


    // 包装好的发送请求函数
    function SendRequest ( $url, $request, $appId, $accessToken ){
        $curl = curl_init ( $url );

        $timestamp = gmdate ( "Y-m-d H:i:s", time ()); // UTC format
        $timestap_sign = $this-> sign($appId. $timestamp);

        $requestSignStr = $this->  sortToSign($request);
        $request_sign = $this-> sign($requestSignStr);

        $header = array ();
        $header [] = 'Content-Type:application/json;charset=UTF-8';
        $header [] = 'X-PPD-TIMESTAMP:' . $timestamp;
        $header [] = 'X-PPD-TIMESTAMP-SIGN:' . $timestap_sign;
        $header [] = 'X-PPD-APPID:' . $appId;
        $header [] = 'X-PPD-SIGN:' . $request_sign;
        if ($accessToken!= null)
            $header [] = 'X-PPD-ACCESSTOKEN:' . $accessToken;
            curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header );
            curl_setopt ( $curl, CURLOPT_POST, 1 );
            curl_setopt ( $curl, CURLOPT_POSTFIELDS, $request );
            curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
            $result = curl_exec ( $curl );
            curl_close ( $curl );
    //         $j = json_decode ( $result, true );
            return $result;
    }


    /**
     * 获取授权
     *
     * @param $appid: 应用ID
     * @param $code
     */
    function authorize($code) {
    	$appid = C('APPID');
    	$request = '{"AppID": "'.$appid.'","Code": "'.$code.'"}';
    	$url = "https://ac.ppdai.com/oauth2/authorize";
    	return $this-> SendAuthRequest ( $url, $request );
    }

    /**
     * 刷新AccessToken
     *
     * @param $openid: 用户唯一标识
     * @param $openid: 应用ID
     * @param $refreshtoken: 刷新令牌Token
     */
    function refresh_token($openid, $refreshtoken) {
    	$appid = C('APPID');
    	$request = '{"AppID":"' . $appid . '","OpenID":"' . $openid. '","RefreshToken":"' . $refreshtoken. '"}';
    	$url = "https://ac.ppdai.com/oauth2/refreshtoken";
    	return $this-> SendAuthRequest ( $url, $request );
    }

    /**
     * 向拍拍贷网关发送请求
     * Url 请求地址
     * Data 请求报文
     * AppId 应用编号
     * Sign 签名信息
     * AccessToken 访问令牌
     *
     * @param unknown $url
     * @param unknown $data
     * @param string $accesstoken
     */
    function send($url, $request, $accesstoken = '') {
    	$appid = C('APPID');
    	$appPrivateKey = C('APPPVK');
    	return $this-> SendRequest ( $url, $request, $appid, $accesstoken );
    }




}
