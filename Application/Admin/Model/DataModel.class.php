<?php
namespace Admin\Model;
use Think\Model;
/*
** 数据层
** update函数用于更新缓存，所有以update开头的函数均为更新缓存函数
*/
class DataModel extends Model{

    public function update(){
        $ua = $this->updateamount();
        $ur = $this->updaterate();
        $uc =$this->updatecredit();
        $ucr = $this->updatecreditratio();
        if($data["success"] = $ua && $ur && $uc & $ucr){
            $data["content"] = "恭喜您，重建缓存成功！";
        }else{
            $data["content"] = "仅有部分项重建缓存成功";
        }
        return $data;
    }
    public function updateamount(){
        $sql = "select count(Amount) as y,case when Amount > 15000  then 15000 when Amount > 14000  then 14000 when Amount > 13000  then 13000 when Amount > 12000  then 12000 when Amount > 11000  then 11000 when Amount > 10000  then 10000 when Amount > 9000  then 9000 when Amount > 8000  then 8000 when Amount > 7000  then 7000 when Amount > 6000  then 6000 when Amount > 5000  then 5000 when Amount > 4000  then 4000 when Amount > 3000  then 3000 when Amount > 2000  then 2000 when Amount > 1000  then 1000 else 0 end as x from tp_data group by x";
        $datamodel = $this->query($sql);
        if($datamodel){
            F('amount',$datamodel);
            return true;
        }else{
            return false;
        }
    }

    public function updaterate(){
        $sql = "select CurrentRate as x, count(CurrentRate) as y from tp_data group by x";
        $datamodel = $this->query($sql);
        if($datamodel){
            F('rate',$datamodel);
            return true;
        }else{
            return false;
        }
    }

    public function updatecredit(){
        $sql = "select CreditCode as name, count(CreditCode) as value from tp_data group by name";
        $datamodel = $this->query($sql);
        if($datamodel){
            F('credit',$datamodel);
            return true;
        }else{
            return false;
        }

    }

    public function updatecreditratio(){
        $sql = "select CreditCode, round(sum(SuccessCount)/(sum(SuccessCount)+sum(OverdueCount)), 4) as Creditratio from tp_data where FirstSuccessBorrowTime = '0' group by CreditCode";
        $datamodel = $this->query($sql);
        if($datamodel){
            F('creditratio',$datamodel);
            return true;
        }else{
            return false;
        }
    }

}
