<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        define('UID',is_login());
        if( !UID ){
            $this->redirect('Public/login');
        }else{
            $this->redirect('Admin/index/today');
        }
    }
    public function today(){
        $this->display();
    }

    public function simulate(){
        $data = M('data');
        $list = $data->where('AuditingTime = "2015-01-01"')->order('ListingId desc')->select();
        $this->assign('list',$list);


        $user = M('user');
        $usermodel = $user->where('uid = '.session('user.uid'))->select();
        $this->assign('user',$usermodel[0]);

        $bid = M('bid');
        $bidmodel = $bid->where('uid = '.session('user.uid'))->select();
        $this->assign('bid',$bidmodel);
        $this->display();
    }
    public function setting(){
        if(I('code')){
            //去拿token
            $authorizeResult = authorize(I('code'));
            if(S('token',json_decode($authorizeResult)->AccessToken,$authorizeResult)->ExpiresIn)){
                echo 获取缓存并且缓存缓存成功！
            };
        }
        $user = M('user');
        $usermodel = $user->where('uid = '.session('user.uid'))->select();
        $this->assign('user',$usermodel[0]);
        $this->display();
    }
    public function real(){
        $user = M('user');
        $usermodel = $user->where('uid = '.session('user.uid'))->select();
        $this->assign('user',$usermodel[0]);
        $this->display();
    }
}
?>
