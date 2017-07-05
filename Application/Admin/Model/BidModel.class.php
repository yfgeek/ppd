<?php
namespace Admin\Model;
use Think\Model;

class BidModel extends Model{
    /**
    ** 日期+1
    */
    public function day(){
        $sql = "update tp_bid set tp_bid.`current_date` = date_add(tp_bid.`current_date`, interval 1 day)";
        $this->query($sql);
        return true;
    }
    /**
    ** 月份+1
    */
    public function month(){
        $sql = "update tp_bid set tp_bid.`current_date` = date_add(tp_bid.`current_date`, interval 1 month)";
        $this->query($sql);
        return true;
    }
}
