$(function () {
    $.getJSON("../api/ppdname", {'openid': $(".ppd-name").attr("data-openid")},function(result){
        if(result.status == 1){
            $(".ppd-name").html(result.name);
        }else{
            $(".ppd-name").html("当前未绑定账户");
        }
    });
});
