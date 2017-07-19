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
            $password =  $_POST["password"];
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
            $this->redirect('index/index');

        } else {
            if(is_login()){
                $this->redirect('index/today');
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
    /* 显示注册页面 */
    public function reg(){
        $this->display();
    }

    public function logging(){
        if(I('code')){
            //去拿token
            $User =  M("user");
            $authorizeResult = authorize(I('code'));
            $userdata["token"] = json_decode($authorizeResult)->AccessToken;
            $userdata["tokentime"] = json_decode($authorizeResult)->ExpiresIn;
            $userdata["openid"] = json_decode($authorizeResult)->OpenID;
            $userdata["lasttokentime"] = NOW_TIME;
            // header("Content-type:text/html;charset=utf-8");
            // $url = "http://gw.open.ppdai.com/open/openApiPublicQueryService/QueryUserNameByOpenID";
            // date_default_timezone_set("Etc/GMT-8");
            // $request = '{
            //   "OpenID": "'. $userdata["openid"] .'"
            // }';
            // $result = send($url, $request);
            // if($username = json_decode($result)->UserName){
                // $realname = decrypt($realname);
                // $map['username'] = $realname;
                // $map['status'] = 1;
                // $finduser = $User->where($map)->find();
                // if($finduser){
                //     $auth = array(
                //         'uid'             => $finduser['uid'],
                //         'username'        => $realname
                //     );
                //     session('user', $auth);
                //     $this->redirect('index/today');
                // }else{
                    $realname = "游客" . rand(0,1000);
                    $data['balance'] = 50000;
                    $data['current_date'] = '2015-01-01';
                    $data['status'] = 1;
                    $data["username"] = $realname;
                    $data["nickname"] = $realname;
                    $data["token"] = $userdata["token"];
                    $data["tokentime"] = $userdata["tokentime"];
                    $data["openid"] = $userdata["openid"];

                    $userreturn  = $User->add($data);
                    $auth = array(
                        'uid'             => $userreturn,
                        'username'        => $realname
                    );
                    session('user', $auth);
                    $this->redirect('index/today');
                // }

            // }else{
            //     $this->redirect('public/login');
            // }

        }

    }
    /* 用户注册 */
    function regging()
    {
         header('Content-Type:text/html; charset=utf-8');
        $User =  M("user");

        $data['username'] = $_POST["username"];
        $data['nickname'] = $_POST["nickname"];
        $data['password'] = md5($_POST["password"]);
        $data['passwordcheck'] = md5($_POST["passwordcheck"]);
        $data['balance'] = 50000;
        $data['current_date'] = '2015-01-01';
        $data['status'] = 1;

        if($data['username'] == "" || $data['nickname'] == "" || $data['password'] == ""|| $data['passwordcheck'] == "")
        {
            echo "<script>alert('请填写完整！');history.back(); </script>";  //js程序，弹出对话框显示信息，并返回上个页面
        }
        else
        if($data['password'] == $data['passwordcheck'])     //密码和确认密码是否一致
        {
            mysql_query("set names utf8");
            $sql = "select username from tp_user where username = '" . $data['username'] ."'";
            $result = $User ->query($sql);
            if($result)    //如果为真，则已存在
            {
                echo "<script>alert('用户名已存在');history.back();</script>";
            }
            else
            {
                $User->add($data);
                if($User)
                echo "<script>alert('注册成功！');window.location.href='login';</script>";
                else
                throw_exception("数据库添加失败");
            }
        }
        else
        {
            echo "<script>alert('密码不一致！');history.back();</script>";
        }
    }
}
?>
