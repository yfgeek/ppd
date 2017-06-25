$(function () {
    var localad = location.href.lastIndexOf("/");
    if(localad>0){addnow = location.href.substring(localad+1,location.href.length);}
    $(".menu-"+addnow).addClass("active");
});
