$(function () {
    $(".btn-refresh").click(function(){
        $.getJSON("../api/update", function(json){
            alert(json.content);
        });
    });
    $(".btn-clear").click(function(){
        $.getJSON("../api/cleartoken", function(json){
            alert(json.content);
        });
    });
    $(".btn-login").click(function(){
        window.location.href="https://ac.ppdai.com/oauth2/login?AppID=5223d676d9dd48f5bf486b73d60e206c&ReturnUrl=http://ppd.yfgeek.com/index/setting";
    });
});
