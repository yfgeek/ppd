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
	$this->display(); // 输出模板
	}

    public function commit(){
	$commit = M('commit'); // 实例化User对象
	$count      = $commit->count();// 查询满足要求的总记录数
	$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
	$Page -> setConfig('header','共%TOTAL_ROW%条');
	$Page -> setConfig('first','首页');
	$Page -> setConfig('prev','上一页');
	$Page -> setConfig('next','下一页');
	$Page -> setConfig('end','尾页');
	$Page -> setConfig('last','尾页');
	$Page -> setConfig('link','indexpagenumb');//pagenumb 会替换成页码
	$show       = $Page->show();// 分页显示输出
	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
	$list = $commit->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
	// var_dump ($list);
	$Ip = new \Org\Net\IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
	$listcount =count($list);
	for ($i=0;$i<$listcount;$i++){
		$area[$i] = $Ip->getlocation($list[$i]["CInfo"]); // 获取某个IP地址所在的位置
		$location[$i+1] = $area[$i]["country"] . " " .$area[$i]["area"];
	}
	$this->assign('location',$location);
	$this->assign('list',$list);// 赋值数据集
	$this->assign('page',$show);// 赋值分页输出
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
