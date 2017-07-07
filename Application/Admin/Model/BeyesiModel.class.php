<?php
/**
** 贝叶斯模型
*/
namespace Admin\Model;
use Think\Model;

class BeyesiModel extends Model {
    public static $pbad = 0.0320;
    public static $pgood = 0.968;
    //cellphone
    public static $plcellphonebad = array(0.5160, 0.4840);
    public static $plcellphonegood = array(0.4522, 0.5478);
    public static $pphonegood = 0.5457;
    public static $pphonebad = 0.4543;
    //hukou
    public static $plhukoubad = array(0.0504, 0.9496);
    public static $plhukougood = array(0.04, 0.96);
    public static $phukougood = 0.9597;
    public static $phukoubad = 0.0403;
    //shipin
    public static $plshipinbad = array(0.0907, 0.9093);
    public static $plshipingood = array(0.0717, 0.9283);
    public static $pshipingood = 0.0723;
    public static $pshipingbad = 0.9277;
    //xueli
    public static $plxuelibad = array(0.2298, 0.7702);
    public static $plxueligood = array(0.3578, 0.6422);
    public static $pxueligood = 0.3537;
    public static $pxuelibad = 0.6463;
    //zhengxin
    public static $plzhengxinbad = array(0.0449, 0.9551);
    public static $plzhengxingood = array(0.0350, 0.9650);
    public static $pzhengxingood = 0.0353;
    public static $pzhengxinbad = 0.9647;
    //gender
    public static $plMFbad = array(0.7751, 0.2249);
    public static $plMFgood = array(0.6891, 0.3109);
    public static $pM = 0.3109;
    public static $pF = 0.3081;
    //pingji
    public static $pabcdef = array(0.0355, 0.1083, 0.3921, 0.3906, 0.0681, 0.0053);
    public static $pabcdefbad = array(0.0193, 0.0828, 0.2813, 0.4672, 0.1332, 0.0161);
    public static $pabcdefgood = array(0.0360, 0.1091, 0.3958, 0.3881, 0.0660, 0.0050);
    //借款金额
    public static $minbad = 3961.0;
    public static $stdbad = 2424.9;
    public static $mingood = 3905.0;
    public static $stdgood = 2285.0;
    //年龄
    public static $ageminbad = 30.0919;
    public static $agestdbad = 7.1271;
    public static $agemingood = 29.1104;
    public static $agestdgood = 6.6349;
    
    public function getmappos($loan, $age, $cellphonetag, $hukoutag, $shipintag, $xuelitag, $zhengxintag, $gendertag, $pingjitag) {

        $pingjitag = $this->pingjiconvert($pingjitag);
        //MAP
        //坏账
        $pbadgg = $this->getpdfvalue($age, self::$ageminbad, self::$agestdbad) * $this->getpdfvalue($loan, self::$minbad, self::$stdbad) * self::$plcellphonebad[$cellphonetag] * self::$plhukoubad[$hukoutag] * self::$plshipinbad[$shipintag] * self::$plxuelibad[$xuelitag] * self::$plzhengxinbad[$zhengxintag] * self::$plMFbad[$gendertag] * self::$pabcdefbad[$pingjitag];

        $pgoodg = $this->getpdfvalue($age, self::$agemingood, self::$agestdgood) * $this->getpdfvalue($loan, self::$mingood, self::$stdgood) * self::$plcellphonegood[$cellphonetag] * self::$plhukougood[$hukoutag] * self::$plshipingood[$shipintag] * self::$plxueligood[$xuelitag] * self::$plzhengxingood[$zhengxintag] * self::$plMFgood[$gendertag] * self::$pabcdefgood[$pingjitag];

        // System.out.println("差值:"+(pgoodg-pbadgg));
        $possibilities[0] = $pbadgg;
        $possibilities[1] = $pgoodg;

        if($pgoodg>$pbadgg){
            return true;
        }else{
            return false;
        }
        // return $possibilities;
    }

    public function getpdfvalue($x, $min, $std) {
        $pdf = 0;
        $temp11 = pow($x - $min, 2);
        $temp111 = pow($std, 2);
        //System.out.println(temp11+" "+temp111);
        $temp1 = - $temp11 / (2 * $temp111);
        //System.out.println("temp1:"+temp1);
        $temp2 = exp($temp1);
        //System.out.println("temp2:"+temp2);
        $temp3 = 1 / sqrt(2 * M_PI * pow($std, 2));
        return $temp3 * $temp2;
    }

    public function renzhengconvert($convert) {
        if ($convert == "未成功认证") {
            return 1;
        } else {
            return 0;
        }
    }
    public function genderconvert($convert) {
        if ($convert == "男") {
            return 0;
        } else {
            return 1;
        }
    }
    public function pingjiconvert($convert) {
        if ($convert == "A") {
            return 0;
        } else if ($convert == "B") {
            return 1;
        } else if ($convert == "C") {
            return 2;
        } else if ($convert == "D") {
            return 3;
        } else if ($convert == "E") {
            return 4;
        } else if ($convert == "F") {
            return 5;
        }
        return -1;
    }
}
