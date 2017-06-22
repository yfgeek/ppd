<?php

$appid="5223d676d9dd48f5bf486b73d60e206c";
$appPrivateKey ="
-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC7luOu0RN4aC1uHxZUb7IYDe4yJAWoiR231vPbsWRoV0s3YYSxu9iluQv6DDoNK/Ja+KAZ2ooORk/W/3GIB9Zv9heJZ6Jt50/DCghkTAAIa3rGsD9SretvHu67vSl3usxbg7frafLrMbAQjch8QyYvbx9kashvKZWnGgwWffR24wIDAQABAoGAOHLCVtOxYTUwHogaRxRJajWe7NWsIjgIik6TmRN7XG6QQr0EmhslqVDSys6tFVOZHUjdnIoHqx37Xn4FouKA4zIJSs+P8sP/3HW/YkWtrthn4FauI0CupgsyCkJCKb+AMkFGAV43WH7nTjRo3P5up23hVyTCpJQ7k0DW2isUY6ECQQDlp8kpFiueG0v9HTq8quLqs/OlC1fEylMI7dTsxG1BZ9q+4Y4VberMhaHRlg8S/gA8AhbNjrwPVplsWpPTSJHRAkEA0RvD63wrzas1xg6PvwaUAoa20M7VFguQjeVPl+85eFeDGXHX/E3FUKUuKG6xRSOT8F5j2XXcz/duM1G/tGMWcwJBALJx5CmLs4qftTTQwHIW6kjqWLf2j1U2zLxUaK0sl6RJuTu2cTuPc/FFKI585eug97eo++TvMotMg9wgqVpzufECQQC7sUldMJp8xCXDPcTG+ReXYOXtbQmU/RJmWyLjRGX4X8yb5TSyEfh/F5Tj09+oKHQcuAy133Yw8W3oAIOrXZmDAkBv+ObNKExZ1ZKDYvUnPG1cKfEzIjD37twOzTOaxLOHMRcjmE0eYR9rx3hKrBqFzEptgvFFFyRtLJlGaKnYSy58
-----END RSA PRIVATE KEY-----
";
$appPublicKey ="
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC7luOu0RN4aC1uHxZUb7IYDe4yJAWoiR231vPbsWRoV0s3YYSxu9iluQv6DDoNK/Ja+KAZ2ooORk/W/3GIB9Zv9heJZ6Jt50/DCghkTAAIa3rGsD9SretvHu67vSl3usxbg7frafLrMbAQjch8QyYvbx9kashvKZWnGgwWffR24wIDAQAB
-----END PUBLIC KEY-----
";

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
         global  $appPrivateKey;
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
        global $appPublicKey;
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
       global $appPublicKey ;
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
        $timestap_sign = sign($appId. $timestamp);

        $requestSignStr = sortToSign($request);
        $request_sign = sign($requestSignStr);

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
            var_dump($result);
            return $result;
    }

    /**
     * 获取授权
     *
     * @param $appid: 应用ID
     * @param $code
     */
    function authorize($code) {
        global $appid;
        $request = '{"AppID": "'.$appid.'","Code": "'.$code.'"}';
        $url = "https://ac.ppdai.com/oauth2/authorize";
        return SendAuthRequest ( $url, $request );
    }

    /**
     * 刷新AccessToken
     *
     * @param $openid: 用户唯一标识
     * @param $openid: 应用ID
     * @param $refreshtoken: 刷新令牌Token
     */
    function refresh_token($openid, $refreshtoken) {
        global $appid;
        $request = '{"AppID":"' . $appid . '","OpenID":"' . $openid. '","RefreshToken":"' . $refreshtoken. '"}';
        $url = "https://ac.ppdai.com/oauth2/refreshtoken";
        return SendAuthRequest ( $url, $request );
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
        global $appid;
        global  $appPrivateKey;
         return SendRequest ( $url, $request, $appid, $accesstoken );
    }
    ?>
