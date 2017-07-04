<?php
/**
** 控制层
** 共用控制器，用于跳转登录
*/
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller {
	public function _initialize(){
		// 获取当前用户ID
        define('UID',is_login());
        if( !UID ){// 还没登录 跳转到登录页面
            $this->redirect('public/login');
        }
	}
}
?>
