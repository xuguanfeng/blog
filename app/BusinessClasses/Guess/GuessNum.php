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

    public function __construct()
    {
        $this->allNumMap = $this->initMap();
        $this->finalAnswer = $this->randomAnswer();
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

    //生成一个4位随机数（没有重复）
    public function matchAnswer($finalAnswer,$guessNum){
        $a=0;
        $b=0;
        for($i=0;$i<4;$i++){
            $subNum=substr($guessNum,$i,1);
            if(strpos($finalAnswer,$subNum) === false){
                continue;
            }
            strpos($finalAnswer,$subNum) ===$i?$a++:$b++;
//            if(strpos($this->finalAnswer,$subNum)){
//
//            }else{
//
//            }
        }
        return $a."A".$b."B";
    }
}

$g = new GuessNum();
//var_dump($g->finalAnswer);
//echo $g->matchAnswer($g->finalAnswer,1234);
//var_dump($g->isDuplicated("1234"));
//var_dump($g->initMap());
//var_dump($g->randomAnswer());