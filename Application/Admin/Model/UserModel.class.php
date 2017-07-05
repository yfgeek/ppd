<?php
namespace Admin\Model;
use Think\Model;

class UserModel extends Model{
    /**
    ** 日期+1
    */
    public function day($uid){
        $sql = "update tp_user set tp_user.current_date = date_add(tp_user.current_date, interval 1 day) where uid='".$uid."'";
        $this->query($sql);
        return true;
    }
    /**
    ** 月份+1
    */
    public function month($uid){
        $sql = "update tp_user set tp_user.current_date = date_add(tp_user.current_date, interval 1 month) where uid='".$uid."'";
        $this->query($sql);
        return true;
    }
}
