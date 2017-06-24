<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        define('UID',is_login());
        if( !UID ){// 还没登录 跳转到登录页面
            $this->redirect('Public/login');
        }else{
			$this->redirect('Admin/index/today');
		}
    }
    public function today(){
        	$this->display(); // 输出模板
    }

    public function simulate(){
    $data = M('data'); // 实例化User对象
	$count      = $data->count();// 查询满足要求的总记录数
	$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
	$Page -> setConfig('first','首页');
	$Page -> setConfig('prev','上一页');
	$Page -> setConfig('next','下一页');
	$Page -> setConfig('link','indexpagenumb');//pagenumb 会替换成页码
	$show       = $Page->show();// 分页显示输出
	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
	$list = $data->where('AuditingTime = "2015-01-01"')->order('ListingId desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    $this->assign('list',$list);// 赋值数据集
    $this->assign('page',$show);// 赋值分页输出

    $user = M('user');
    $usermodel = $user->where('uid = '.session('user.uid'))->select();
    $this->assign('user',$usermodel[0]);

    $bid = M('bid');
    $bidmodel = $bid->where('uid = '.session('user.uid'))->select();
    $this->assign('bid',$bidmodel);
	$this->display(); // 输出模板
	}

    public function real(){
	$this->display();
    }
	public function social(){

		$this->display();
	}
	public function photo(){
		$this->display();
	}

}
?>
