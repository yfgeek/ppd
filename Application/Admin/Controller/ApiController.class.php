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
    public function bidd(){
        header("Content-type:text/html;charset=utf-8");
        $url = "http://gw.open.ppdai.com/invest/LLoanInfoService/BatchListingInfos";
        date_default_timezone_set("Etc/GMT-8");
        $request = '{
            "ListingIds": [' .I('lid') . ']
        }';
        $result = send($url, $request);
        echo $result;
    }


    /**
    ** Api/getppdname
    ** 获得具体标的API，利用openid获取用户名字
    ** 需要请求：openid
    ** 返回格式为JSON
    */
    public function ppdname(){
        header("Content-type:text/html;charset=utf-8");
        $url = "http://gw.open.ppdai.com/open/openApiPublicQueryService/QueryUserNameByOpenID";
        date_default_timezone_set("Etc/GMT-8");
        $request = '{
          "OpenID": "'. I('openid') .'"
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

    /**
    ** Api/deal
    ** 用于模拟投资
    ** @param lid 是listing id
    ** 返回格式为JSON，投资结果，正确与否
    */
    public function deal($lid){
        $bid = M('bid');
        $bidmodel = $bid->where('uid = '.session('user.uid') . 'AND Listingid = '. $lid )->count();
        if($bidmodel==0){
            $row["uid"] = session('user.uid');
            $row["listingid"] = $lid;
            $row["share"] = "500";
            $row["biddate"] = time();
            $row["trandate"] = "NaN";
            if($bid->add($row)){
                $usrInfo = array('status'=>'success');

            }else{
                $usrInfo = array('status'=>'fail','content'=>'这个您已经投资过了');
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
    public function listd(){
        $lid = I('get.lid');
        $data = M('data');
        $datamodel = $data->where('Listingid = '.$lid )->select();
        echo $this->ajaxReturn($datamodel[0]);
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
}
?>
