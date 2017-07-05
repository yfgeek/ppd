<?php
namespace Admin\Model;
use Think\Model;

class BidModel extends Model{
    /**
    ** 重建评级比率函数
    */
    public function month(){
        $sql = "update tp_bid set biddate = case when biddate is not null then biddate = date_add(biddate, interval 1 month) else biddate = date_add(biddate, interval 1 month) end";
        $datamodel = $this->query($sql);
        if($datamodel){
            return true;
        }else{
            return false;
        }
    }
}
