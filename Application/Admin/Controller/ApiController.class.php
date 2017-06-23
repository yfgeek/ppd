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
    public function bid(){
    header("Content-type:text/html;charset=utf-8");
    $url = "http://gw.open.ppdai.com/invest/LLoanInfoService/LoanList";
    date_default_timezone_set("Etc/GMT-8");
    $dt = date("Y-m-d H:i:s");
    $dt = date("Y-m-d H:i:s",strtotime("$dt - 200second"));
    $request = '{
      "PageIndex": 1,
      "StartDateTime": "' . $dt . '.000"
    }';
    $Api = D('Admin/Api');
    $result = $Api->send($url, $request);
    echo $result;
    }


}
?>
