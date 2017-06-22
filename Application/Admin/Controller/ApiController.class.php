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
        $url = "http://gw.open.ppdai.com/invest/LLoanInfoService/LoanList";
    $request = '{
      "PageIndex": 1,
      "StartDateTime": "2016-11-11 12:00:00.000"
    }';
    $Api = D('Admin/Api');
    $result = $Api->send($url, $request);
    var_dump($result);
    }


}
?>
