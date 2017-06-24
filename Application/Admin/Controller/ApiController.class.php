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
        $result = send($url, $request);
        echo $result;
    }

    public function deal($lid){
        $bid = M('bid');
        $bidmodel = $bid->where('uid = '.session('user.uid') . 'AND Listingid = '. $lid )->count();
        if($bidmodel==0){
            $row["uid"] = session('user.uid');
            $row["listingid"] = $lid;
            $row["share"] = "500";
            $row["biddate"] = time();
            $row["trandate"] = "NaN";
            if($bid->add($row)){
                $usrInfo = array('status'=>'success');

            }else{
                $usrInfo = array('status'=>'fail','content'=>'这个您已经投资过了');
            }
        }else{
            $usrInfo = array('status'=>'fail','content'=>'这个您已经投资过了');
        }
        echo $this->ajaxReturn($usrInfo);
    }

    public function listd(){
        $lid = I('get.lid');
        $data = M('data');
        $datamodel = $data->where('Listingid = '.$lid )->select();
        $usrInfo = $datamodel[0];
        echo $this->ajaxReturn($usrInfo);

    }

    public function amount(){
        $data = M('data');
        $sql = "select count(Amount) as y,case when Amount > 15000  then 15000 when Amount > 14000  then 14000 when Amount > 13000  then 13000 when Amount > 12000  then 12000 when Amount > 11000  then 11000 when Amount > 10000  then 10000 when Amount > 9000  then 9000 when Amount > 8000  then 8000 when Amount > 7000  then 7000 when Amount > 6000  then 6000 when Amount > 5000  then 5000 when Amount > 4000  then 4000 when Amount > 3000  then 3000 when Amount > 2000  then 2000 when Amount > 1000  then 1000 else 0 end as x from tp_data group by x";
        $datamodel = $data->query($sql);
        if($datamodel){
            echo $this->ajaxReturn($datamodel);
        }
    }

    public function rate(){
        $data = M('data');
        $sql = "select CurrentRate as x, count(CurrentRate) as y from tp_data group by x";
        $datamodel = $data->query($sql);
        if($datamodel){
            echo $this->ajaxReturn($datamodel);
        }
    }
}
?>
