<?php
namespace Admin\Controller;
use Think\Controller;
class ApiController extends CommonController {
    public function index(){
        define('UID',is_login());
        if( !UID ){
            $this->redirect('Public/login');
        }else{
			$this->redirect('Admin/index/commit');
		}
    }
	public function getweibo(){
		$url = "http://weibo.com/2260161101/like";
		$re = '/(.*?)/';
		$weibolist = $this->getUrlContent($url);
		echo $weibolist;
	}
	public function getmusic(){
		$url = "http://music.163.com/#/user/songs/rank?id=133978433";
		$re = '/.*?<div.*?id="m-record".*?>(.*?)<\/div>.*?/';
		$musiclist = $this->getUrlContent($url);
		echo $musiclist;
	}
	public function getzhihu(){
		// $re = '/.*?<span.*?class="zm-profile-setion-time.*?zg-gray.*?zg-right">(.*?)<\/span>.*?/ism';
		// $re2 = '/.*?<span.*?class="zm-profile-setion-time.*?zg-gray.*?zg-right">(.*?)<\/span>/ism';
		$re = '/<span class=\"zm-profile-setion-time zg-gray zg-right\">(.*?)<\/span>\n.*?\n.*?\n.*?\n\n(<a.*?class=\"question_link\".*?target=\"_blank\".*?href=".*?">.*?<\/a>)/si';
		$userzhihu = "jin-xi-78-75";
		$url = "http://www.zhihu.com/people/" . $userzhihu;
		// $zhihulist = $this->getUrlContent($url);
		$zhihulist = $this->crawler($url,$re);
		echo $this->ajaxReturn($zhihulist);
		// $this->assign('zhihulist',$zhihulist);
	}
	public function getshanbay(){
		 $url='https://www.shanbay.com/api/v1/team/41602/thread/?page=1&_=1460982725875';  
         $json = file_get_contents($url);  
         $de_json = json_decode($json,TRUE);
         $count_json = count($de_json);
         for ($i = 0; $i < 10; $i++){
                $data = $de_json['data']['objects'][$i]['title'];
                $url = $de_json['data']['objects'][$i]['absolute_url'];
				$latest_post_time = $de_json['data']['objects'][$i]['latest_post_time'];
				$contentStr[$i]['url']='https://www.shanbay.com'.$url;
				$contentStr[$i]['data']=$data;
				$contentStr[$i]['time'] = $latest_post_time;
		 }
		 ;
		echo $this->ajaxReturn($contentStr);
	}
	private function getUrlContent($url) {
    $handle = fopen($url, "r");
    if ($handle) {
        $content = stream_get_contents($handle, 1024 * 1024);
        return $content;
    } else {
        return false;
    } 
	}
	private function filterUrl($web_content,$reg_tag_a) {
    $result = preg_match_all($reg_tag_a, $web_content, $match_result);
    // var_dump($match_result);
    if ($result) {
        return $match_result[0];
    }else {
		return '未匹配';
	} 
	}
	public function crawler($url,$re) {
    $content = $this->getUrlContent($url);
    if ($content) {
        $url_list =$this->filterUrl($content,$re);
        if ($url_list) {
            return $url_list;
        } else {
            return ;
        } 
    } else {
        return ;
    } 
	}   
    public function getmail(){
    $id=$_GET["id"];
    $mail = M('mail');
    $result = $mail->where("id='$id'")->find();
	if($result){
		$row = mysql_fetch_array($result);
		$usrInfo = array('status'=>'success','html'=>base64_decode($result['CConntent']));
	    echo $this->ajaxReturn($usrInfo);	
	}else
	{
		$usrInfo = array('status'=>'fail','html'=>'');
	    echo $this->ajaxReturn($usrInfo);	
	}
    }
    public function editcon(){
    	$action = addslashes($_GET['action']);
		$id = $_GET['id'];
		$pass = $_GET['pass'];
		$ppp = '09230923';
		$content = addslashes($_GET['editcon']);
		switch ($action) {
		  case 'edit':
		    if ($pass == $ppp){
		    $edit = M('commit');
		    $data['CConntent'] = $content;
   		    $result = $edit->where("id='$id'")->save($data);
		    if($result){
		    $usrInfo = array('status'=>'success');
		    echo $this->ajaxReturn($usrInfo);
		    }else{
		    $usrInfo = array('status'=>'fail');
		    echo $this->ajaxReturn($usrInfo);  
		    } 
		    }else{
		    $usrInfo = array('status'=>'ep');
		    echo $this->ajaxReturn($usrInfo);     
		    }
		    break;
		  case 'del':
		    if ($pass == $ppp){
			    $del = M('commit');
			    $data['CConntent'] = $content;
			    $result= $del->where("id='$id'")->delete();
			    if($result){
			    $usrInfo = array('status'=>'success');
			    echo $this->ajaxReturn($usrInfo);
			    }else{
			    $usrInfo = array('status'=>'fail');
			    echo $this->ajaxReturn($usrInfo);  
			    } 
		    }else{
		    $usrInfo = array('status'=>'ep');
		    echo $this->ajaxReturn($usrInfo);     
		    }
		    break;
		  default:
		    echo "Error:错误的参数传递！";
		    break;
    	}
    }
}
?>