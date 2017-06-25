<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller {
	public function _initialize(){
		// 获取当前用户ID
        define('UID',is_login());
        if( !UID ){// 还没登录 跳转到登录页面
            $this->redirect('public/login');
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
}
?>
