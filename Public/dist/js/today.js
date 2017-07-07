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
            $(".ppd-balance").html(result.Balance[4].Balance);
        }else{
            $(".ppd-name").html("当前未绑定账户");
        }
    });

    $.getJSON("../api/historylist",function(result){
        if(result.Result == 0){
            var str = '';
            if(result.TotalRecord<=0){
                str = '<tr><td>当前用户暂无成交纪录</td><td></td><td></td><td></td><td></td><td></td></tr>';
            }else{
                $.each(result.BidList, function( index, item ) {
                    str = str + '<tr><td><a href="pages/examples/invoice.html">' + item.ListingId + '</a></td><td>' + item.Title + '</td><td><span class="label label-success">' + item.Months + '</span></td><td><span class="label label-warning">'+ item.Rate + '%</span></td><td><span class="label label-info">'+ item.Amount + '</span></td><td><span class="label label-info">'+ item.BidAmount + '</span></td></tr>';
                });
            }
            $(".tb-history").html(str);
        }else{
        }
    });

});
