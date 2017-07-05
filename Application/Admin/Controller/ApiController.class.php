<?php
/**
** 控制层
** 该层充当API的角色，返回数据最好为标准的json格式，供前端ajax使用
*/
namespace Admin\Controller;
use Think\Controller;
class ApiController extends CommonController {

    /**
    ** Api/index
    ** 该页面用于判断首次登录是否已授权，如果未取得API授权则跳转到授权页面
    */
    public function index(){
        define('UID',is_login());
        if( !UID ){
            $this->redirect('Public/login');
        }else{
            $user = M('user');
            $usermodel = $user->where('uid = '.session('user.uid'))->find();
            if(!$usermodel["token"]){
                $this->redirect('index/ppdapi');
            }else{
                $this->redirect('index/today');
            }
        }
    }

    /**
    ** Api/bid
    ** 获得批量散标数据 API，无需用户登录
    ** 返回格式为JSON
    */
    public function bid(){
        header("Content-type:text/html;charset=utf-8");
        $url = "http://gw.open.ppdai.com/invest/LLoanInfoService/LoanList";
        date_default_timezone_set("Etc/GMT-8");
        $dt = date("Y-m-d H:i:s");
        $dt = date("Y-m-d H:i:s",strtotime("$dt - 500second"));
        $request = '{
            "PageIndex": 1,
            "StartDateTime": "' . $dt . '.000"
        }';
        $result = send($url, $request);
        echo $result;
    }

    /**
    ** Api/bidd
    ** 获得具体标的API，无需用户登录
    ** 需要请求：lid 是listing id
    ** 返回格式为JSON
    */
    public function bidd($lid){
        header("Content-type:text/html;charset=utf-8");
        $url = "http://gw.open.ppdai.com/invest/LLoanInfoService/BatchListingInfos";
        date_default_timezone_set("Etc/GMT-8");
        $request = '{
            "ListingIds": [' . $lid . ']
        }';
        $result = send($url, $request);
        echo $result;
    }


    /**
    ** Api/ppdname
    ** 获得具体用户名的API，利用openid获取用户名字
    ** 需要请求：openid
    ** 返回格式为JSON
    */
    public function ppdname(){
        $user = M('user');
        $usermodel = $user->where('uid = '.session('user.uid'))->find();
        if($usermodel){
            header("Content-type:text/html;charset=utf-8");
            $url = "http://gw.open.ppdai.com/open/openApiPublicQueryService/QueryUserNameByOpenID";
            date_default_timezone_set("Etc/GMT-8");
            $request = '{
              "OpenID": "'. $usermodel["openid"] .'"
            }';
            $result = send($url, $request);
            if($username = json_decode($result)->UserName){
                $data["status"] = 1;
                $data["name"] = decrypt($username);
                echo $this->ajaxReturn($data);
            }else{
                $data["status"] = 0;
                echo $this->ajaxReturn($data);
            }
        }
        else{
                $data["status"] = 0;
                echo $this->ajaxReturn($data);
        }
    }

    /**
    ** Api/ppdbalance
    ** 获得具体用户金额的API，利用openid获取用户名字
    ** 需要请求：openid
    ** 返回格式为JSON
    */
    public function ppdbalance(){
        $user = M('user');
        $usermodel = $user->where('uid = '.session('user.uid'))->find();
        if($usermodel){
            header("Content-type:text/html;charset=utf-8");
            $url = "http://gw.open.ppdai.com/balance/balanceService/QueryBalance";
            date_default_timezone_set("Etc/GMT-8");
            $accessToken=$usermodel["token"];
            $request = '{
            }';
            $result = send($url, $request,$accessToken);
            echo $result;
        }else{
            $data["status"] = 0;
            echo $this->ajaxReturn($data);
        }
    }

    /**
    ** Api/deal
    ** 用于模拟投资
    ** @param lid 是listing id
    ** 返回格式为JSON，投资结果，正确与否
    */
    public function deal($lid,$share){
        $user = M('user');
        $usermodel = $user->where('uid = '.session('user.uid'))->find();

        $bid = M('bid');
        $bidmodel = $bid->where('uid = '.session('user.uid') . 'AND Listingid = '. $lid )->count();

        $data = M('data');
        $datamodel = $data->where('Listingid = '.$lid )->find();

        if($bidmodel==0){
            if($datamodel["Amount"]>=$share){
                if($usermodel["balance"]>=$share){
                    $row["uid"] = session('user.uid');
                    $row["listingid"] = $lid;
                    $row["share"] = $share;
                    $row["biddate"] = date('Y-m-d');
                    $row["current_date"] = date('Y-m-d');
                    $row["trandate"] = "NaN";
                    if($bid->add($row)){
                        $usrInfo = array('status'=>'success');
                        $userdata["balance"] = $usermodel["balance"] - $share;
                        $user->where('uid = '.session('user.uid'))->save($userdata);
                    }else{
                        $usrInfo = array('status'=>'fail','content'=>'数据更新异常');
                    }
                }else{
                    $usrInfo = array('status'=>'fail','content'=>'您用户余额不足');
                }
            }else{
                $usrInfo = array('status'=>'fail','content'=>'不得超过可投金额');
            }

        }else{
            $usrInfo = array('status'=>'fail','content'=>'这个您已经投资过了');
        }
        echo $this->ajaxReturn($usrInfo);
    }

    /**
    ** Api/listd
    ** 用于返回模拟投资的具体信息
    ** 需要请求 lid 是listing id
    ** 返回格式为JSON
    */
    public function listd($lid){
        $data = M('data');
        $datamodel = $data->where('Listingid = '.$lid )->find();
        echo $this->ajaxReturn($datamodel);
    }

    /**
    ** Api/update
    ** 用于更细缓存
    ** 调用模型层的update方法
    ** 返回格式为JSON
    */
    public function update(){
        $data = D('Data');
        echo $this->ajaxReturn($data->update());
    }


    public function test(){
        $data = M('data');
        $datamodel = $data->limit(3000)->select();
        foreach($datamodel as $n => $item){
            if($this->beyes($item["ListingId"])){
                echo $item["ListingId"];
            }
        }

    }
    /**
    ** Api/beyes
    ** 贝叶斯模型
    ** 输入：$lid
    ** loan, age, cellphonetag, hukoutag, shipintag, xuelitag,  zhengxintag, gendertag, pingjitag
    ** 返回格式为JSON
    */
    public function beyes($lid){
        $data = M('data');
        $datamodel = $data->where('ListingId = '.$lid )->find();
        $data = D('Beyesi');
        $result["status"] =  $data->getmappos($datamodel["Amount"],$datamodel["Age"],$datamodel["PhoneValidate"],$datamodel["NciicIdentityCheck"],$datamodel["VideoValidate"],$datamodel["EducateValidate"],$datamodel["CreditValidate"],$datamodel["Gender"],$datamodel["CreditCode"]);
        return $this->ajaxReturn($result);
    }

    /**
    ** Api/amount
    ** 从缓存中读取 金额 数据
    ** 返回格式为JSON
    */
    public function amount(){
        echo $this->ajaxReturn(F('amount'));
    }

    /**
    ** Api/rate
    ** 从缓存中读取 比率 数据
    ** 返回格式为JSON
    */
    public function rate(){
        echo $this->ajaxReturn(F('rate'));
    }

    /**
    ** Api/credit
    ** 从缓存中读取 评级 数据
    ** 返回格式为JSON
    */
    public function credit(){
        echo $this->ajaxReturn(F('credit'));
    }

    /**
    ** Api/credit
    ** 从缓存中读取 评级比率 数据
    ** 返回格式为JSON
    */
    public function creditratio(){
        echo $this->ajaxReturn(F('creditratio'));
    }

    /**
    ** Api/cleartoken
    ** 清空该用户的token值
    ** 返回格式为JSON
    */
    public function cleartoken(){
        $user = D('user');
        $userdata["token"] = "";
        $userdata["tokentime"] = "";
        $user->where('uid = '.session('user.uid'))->save($userdata);
        $data["content"] = "清除授权成功";
        echo $this->ajaxReturn($data);
    }

    /**
    ** Api/aftermonth
    ** 后延一个月
    ** 返回格式为JSON
    */
    public function aftermonth(){
        $data = D('Bid');
        echo $this->ajaxReturn($data->month());
    }
}
?>
