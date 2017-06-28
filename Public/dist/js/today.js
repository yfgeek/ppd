$(function () {
    $.getJSON("../api/ppdname",function(result){
        if(result.status == 1){
            $(".ppd-name").html(result.name);
        }else{
            $(".ppd-name").html("当前未绑定账户");
        }
    });
    $.getJSON("../api/ppdbalance",function(result){
        if(result.Balance){
            $(".ppd-blance").html(result.Balance[4].Balance);
        }else{
            $(".ppd-name").html("当前未绑定账户");
        }
    });
});
