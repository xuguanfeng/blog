<?php  namespace App\BusinessClasses\Guess;
use PhpParser\Node\Expr\Cast\Array_;

/**
 * Created by PhpStorm.
 * User: xuguanfeng
 * Date: 2015/04/21
 * Time: 10:40
 */

class GuessNum {

    public $allNumMap;
    public $finalAnswer;
    public $autoPlayRecord;

    public function __construct()
    {
        $this->allNumMap = $this->initMap();
        $this->finalAnswer = $this->randomAnswer();
        $this->autoPlayRecord=Array();
    }

    //判定是否有重复数字
    public function isDuplicated($num){
        if($num == null || strlen($num) !== 4){
            return true;
        }
        for ($i = 0; $i < 4; $i++) {
            $array[substr($num,$i,1)]="";
        }
        return count(array_keys($array)) < 4;
    }

    //初始化5020个候选
    public function initMap(){
        for($i = 123; $i < 9877; $i++){
            $num = $i < 1000 ? "0".$i : $i;
            if(!$this->isDuplicated($num)){
                $array[$num]="";
            }
        }
        return $array;
    }

    //生成一个4位随机数（没有重复）
    public function randomAnswer(){
        $array[rand(0,9)]="";
        while(count($array)<4){
            $array[rand(0,9)]="";
        }
        $rtnStr="";
        foreach($array as $key=>$val){
            $rtnStr .=$key;
        }
        return $rtnStr;
    }

    //匹配?A?B
    public function matchAnswer($finalAnswer,$guessNum){
        $a=0;
        $b=0;
        for($i=0;$i<4;$i++){
            $subNum=substr($guessNum,$i,1);
            if(strpos($finalAnswer,$subNum) === false){
                continue;
            }
            strpos($finalAnswer,$subNum) ===$i?$a++:$b++;
        }
        return $a."A".$b."B";
    }

    /*
     * 根据数字和提示自动算出最终答案
     * 一共有5040种答案的排列组合，每一个都和数字进行匹配，剔除和提示不同的排列组合
     */
    public function autoPlay($finalAnswer,$allNumMap){
        //随机选择一组数字
        $rdmNum=array_keys($allNumMap)[rand(0,count($allNumMap)-1)];
        //随机数字的答案
        $tmpResult=$this->matchAnswer($finalAnswer,$rdmNum);
        //记录过程
        $this->autoPlayRecord[$rdmNum]=$tmpResult;
        //如果猜中了则返回
        if($tmpResult=="4A0B"){
            return ;
        }
        //排除所有和随机数字答案不一样的排列组合
        foreach($allNumMap as $k=>$v){
            if($this->matchAnswer($k,$rdmNum) !=$tmpResult){
                unset($allNumMap[$k]);
            }
        }
        //递归
        $this->autoPlay($finalAnswer,$allNumMap);
    }
}

//$g = new GuessNum();
//$g->autoPlay(1234,$g->allNumMap);
//var_dump($g->autoPlayRecord);
//echo $g->matchAnswer($g->finalAnswer,1234);
//var_dump($g->isDuplicated("1234"));
//var_dump($g->initMap());
//var_dump($g->randomAnswer());