/**
 * Created by xuguanfeng on 2015/04/22.
 */
$(document).ready(function(){

    //以btn开头的元素
    $("[id^=btn]").click(function(){
        var index = $("[id^=btn]").index(this);
        //alert(index);
        if(!isLegalNum($("[name^=guessNum]").eq(index).val())){
            alert($("[name^=guessNum]").eq(index).val()+"非法");
            $("[name^=guessNum]").eq(index).focus();
            return;
        };
        var formParam = $("[id^=form]").eq(index).serialize();//序列化form内容为字符串
        //alert(formParam);
        //var formParam = $("#form0").serialize();//序列化表格内容为字符串
        $.ajax({
            type:'post',
            url:'/guess/guessnumber',
            data:formParam,
            cache:false,
            dataType:'json',
            success:function(data){
                $("[id^=label]").eq(index).text(data.result);
                //alert(data.result);
            }
        });
    });

    function isLegalNum(num){
        //alert(num);
        if(num.length !=4 || num.match(/\d{4,4}/) == null){
            return false;
        }
        for(i =0; i < num.length;i++){
            var s = num.substr(i,1);
            if(num.indexOf(s) != num.lastIndexOf(s)){
                return false;
            }
        }
        return true;
    }
});