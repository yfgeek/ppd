<?php
/**
** 控制层
** 主要负责界面展示与VIEW层沟通的控制器
*/
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    /**
    ** Index/index
    ** 该页面用于判断首次登录是否已授权，如果未取得API授权则跳转到授权页面
    */
    public function index(){
        // define('UID',is_login());
        // if( !UID ){
        //     $this->redirect('Public/login');
        // }else{
        //     $user = M('user');
        //     $usermodel = $user->where('uid = '.session('user.uid'))->find();
        //     if(!$usermodel["token"]){
        //         $this->redirect('index/ppdapi');
        //     }else{
        //         $this->redirect('index/today');
        //     }
        // }
         $this->redirect('index/today');
    }
    /**
    ** Index/today
    ** 大厅页面
    */
    public function today(){
        if(I('code')){
            //去拿token
            $authorizeResult = authorize(I('code'));
            $user = D('user');
            $userdata["token"] = json_decode($authorizeResult)->AccessToken;
            $userdata["tokentime"] = json_decode($authorizeResult)->ExpiresIn;
            $userdata["openid"] = json_decode($authorizeResult)->OpenID;
            $userdata["lasttokentime"] = NOW_TIME;
            $user->where('uid = '.session('user.uid'))->save($userdata);
            $this->redirect('index/today');
        }
        $user = M('user');
        $usermodel = $user->where('uid = '.session('user.uid'))->find();
        if(!$usermodel["token"]){
            $this->redirect('index/ppdapi');
        }
        $this->assign('user',$usermodel);
        $this->display();
    }

    /**
    ** Index/simulate
    ** 模拟投资页面
    */
    public function simulate(){
        date_default_timezone_set('Asia/Shanghai');
        $user = M('user');
        $usermodel = $user->where('uid = '.session('user.uid'))->find();
        $data = M('data');
        $list = $data->where('AuditingTime = "' . $usermodel["current_date"] . '"')->order('ListingId desc')->select();

        $this->assign('list',$list);
        $this->assign('user',$usermodel);

        $bid = M('bid');
        $bidmodel = $bid->where('uid = '.session('user.uid'))->select();
        $this->assign('bid',$bidmodel);
        $this->assign('currentdate',$usermodel["current_date"]);

        $this->display();


    }

    /**
    ** Index/setting
    ** 设置页面
    */
    public function setting(){
        if(I('code')){
            //去拿token
            $authorizeResult = authorize(I('code'));
            $user = D('user');
            $userdata["token"] = json_decode($authorizeResult)->AccessToken;
            $userdata["tokentime"] = json_decode($authorizeResult)->ExpiresIn;
            $userdata["openid"] = json_decode($authorizeResult)->OpenID;
            $userdata["lasttokentime"] = NOW_TIME;
            $user->where('uid = '.session('user.uid'))->save($userdata);
            $this->redirect('index/setting');
        }
        $user = M('user');
        $usermodel = $user->where('uid = '.session('user.uid'))->find();
        $this->assign('user',$usermodel);
        $this->display();
    }

    /**
    ** Index/real
    ** 真实投资页面
    */
    public function real(){
        $user = M('user');
        $usermodel = $user->where('uid = '.session('user.uid'))->find();
        $this->assign('user',$usermodel);
        $this->display();
    }
    /**
    ** Index/ppdapi
    ** 用于跳转到拍拍贷API
    ** 该页面为临时方案
    */
    public function ppdapi(){
        $this->display();
    }
}
?>
