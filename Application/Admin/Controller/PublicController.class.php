<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 后台公共控制器
 */
class PublicController extends Controller {
	/**
     * 后台用户登录
     */
    public function login($username = null,$password = null, $verify = null){
        if(IS_POST){
            $db = M('user');
			$map['username'] = $username;
			$map['status'] = 1;
			$user = $db->where($map)->find();
			if($user['password'] != md5($password)){
				$this->error('密码错误，请重新输入');
			}

			$data = array(
				'uid'              => $user['uid'],
				'login'           => array('exp', '`login`+1'),
				'last_login_time' => NOW_TIME,
				'last_login_ip'   => get_client_ip(),
			);
			$db->save($data);

			/* 记录登录SESSION和COOKIES */
			$auth = array(
				'uid'             => $user['uid'],
				'username'        => $user['nickname'],
				'last_login_time' => $data['last_login_time'],
			);
			session('user', $auth);
			$this->redirect('Index/today');

        } else {
            if(is_login()){
                $this->redirect('Index/today');
            }else{
                $this->display();
            }
        }
    }
	/* 退出登录 */
    public function logout(){
        if(is_login()){
			session('user', null);
            session('[destroy]');
            $this->redirect('login');
        } else {
            $this->redirect('login');
        }
    }

    public function verify(){
		ob_end_clean();
        $verify = new \Think\Verify();
        $verify->entry();
    }
}
?>
