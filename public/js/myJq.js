/**
 * Created by xuguanfeng on 2015/04/22.
 */
$(document).ready(function () {
    //电脑猜的初期化，把输入框和标签都隐藏
    $("[id^=pclabel]").hide();
    $("[name^=pcguessNum]").hide();

    //alert($("#mode").val());
    if ($("#mode").val() == "1") {
        //已经初始化，显示输入框,只显示认输link
        $("[id^=form]").show();
        $("#showAnswerLink").show();
        $("#newGameLink").hide();
    } else if ($("#mode").val() == "-1") {
        //已经认输，输入disable，只显示初始link
        $("[id^=btn]").attr("disabled", true);
        $("[name^=guessNum]").attr("disabled", true);
        $("#showAnswerLink").hide();
        $("#newGameLink").show();
    } else if ($("#mode").val() == "" || $("#mode").val() == "0") {
        //第一次访问，只显示初始link，不显示输入
        $("[id^=form]").hide();
        $("#showAnswerLink").hide();
        $("#newGameLink").show();
    }
    //id以btn开头的元素
    $("[id^=btn]").click(function () {
        var index = $("[id^=btn]").index(this);
        //alert(index);
        if (!isLegalNum($("[name^=guessNum]").eq(index).val())) {
            $("[id^=label]").eq(index).text("请重新输入");
            $("[name^=guessNum]").eq(index).css({"background-color": "#dff0d8"});
            //alert($("[name^=guessNum]").eq(index).val()+"非法");
            $("[name^=guessNum]").eq(index).focus();
            return;
        }
        ;
        var formParam = $("[id^=form]").eq(index).serialize();//序列化form内容为字符串
        //alert(formParam);
        //var formParam = $("#form0").serialize();//序列化表格内容为字符串
        $.ajax({
            type: 'post',
            url: '/guess/guessnumber',
            data: formParam,
            cache: false,
            dataType: 'json',
            success: function (data) {
                $("[id^=label]").eq(index).text(data.result);
                //alert(data.result);
                if (data.result == "4A0B") {
                    //猜对了
                    $("[id^=label]").eq(index).css({"background-color": "#98bf21", "color": "white"});
                    $("[id^=btn]").attr("disabled", true);
                    $("[name^=guessNum]").attr("disabled", true);
                    $("#answerDiv").text("恭喜你猜对了");
                    $("#showAnswerLink").hide();
                    $("#newGameLink").show();
                }
                $("[id^=btn]").eq(index).attr("disabled", true);
                $("[name^=guessNum]").eq(index).attr("disabled", true);
                $("[name^=guessNum]").eq(index + 1).focus();
            }
        });
    });

    //重新绑定回车提交的事件
    $('[name^=guessNum]').keypress(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var index = $("[name^=guessNum]").index(this);
            $("[id^=btn]").eq(index).trigger("click");
        }
    });

    function isLegalNum(num) {
        //alert(num);
        if (num.length != 4 || num.match(/\d{4,4}/) == null) {
            return false;
        }
        for (i = 0; i < num.length; i++) {
            var s = num.substr(i, 1);
            if (num.indexOf(s) != num.lastIndexOf(s)) {
                return false;
            }
        }
        return true;
    }

    //重新绑定回车提交的事件
    //电脑猜
    $("#finalAnswer").keypress(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $("#pcplay").trigger("click");
        }
    });
    /*
     用户指定数字，电脑来猜
     */
    $("#pcplay").click(function () {
        //初期化输入框和标签
        $("[id^=pclabel]").hide();
        $("[name^=pcguessNum]").hide();
        $("[id^=pclabel]").text("");
        $("[id^=pclabel]").css({"background-color": "#777777", "color": "white"});
        $("[name^=pcguessNum]").val("");
        //alert(index);
        if (!isLegalNum($("#finalAnswer").val())) {
            $("#illegalNum").text("请重新输入");
            $("#finalAnswer").css({"background-color": "#dff0d8"});
            //alert($("[name^=guessNum]").eq(index).val()+"非法");
            $("#finalAnswer").focus();
            return;
        } else {
            $("#illegalNum").text("");
            $("#finalAnswer").css("form-control-static");
        }
        //alert($("#finalAnswer").val());
        //var formParam = $("#form0").serialize();//序列化表格内容为字符串
        $.ajax({
            type: 'get',
            url: '/guess/autoguess',
            data: 'finalAnswer=' + $("#finalAnswer").val(),
            cache: false,
            dataType: 'json',

            error:function(){
                alert('error');
            },
            success: function (data) {
                for (i = 0; i < data.result.res.length; i++) {
                    $("[id^=pclabel]").eq(i).show();
                    $("[name^=pcguessNum]").eq(i).show();
                    $("[id^=pclabel]").eq(i).text(data.result.res[i]);
                    $("[name^=pcguessNum]").eq(i).val(data.result.num[i]);
                    $("[name^=pcguessNum]").eq(i).attr("disabled", true);
                    if(data.result.res[i]=="4A0B"){
                        $("[id^=pclabel]").eq(i).css({"background-color": "#98bf21", "color": "white"});
                        //for(j=i+1;j<20;j++){
                            //$("[id^=pclabel]").eq(j).hide();
                            //$("[name^=pcguessNum]").eq(j).hide();
                        //}
                        //i以后的输入框和标签全部隐藏
                        $("[id^=pclabel]:gt("+i+")").hide();
                        $("[name^=pcguessNum]:gt("+i+")").hide();
                        return;
                    }
                }
            }
        });
    });
});