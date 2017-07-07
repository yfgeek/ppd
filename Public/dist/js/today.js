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
            result.BidList.each(function(item){
                alert(item.Title);
            });
            // <tr>
            // <td><a href="pages/examples/invoice.html">1718801</a></td>
            //     <td>01</td>
            //     <td>12</td>
            //     <td><span class="label label-warning">进行中</span></td>
            //     <td>
            //         <div class="sparkbar" data-color="#00a65a" data-height="20">2017-06-25</div>
            //     </td>
            // </tr>
            // $(".tb-history").html(result.Balance[4].Balance);
        }else{
        }
    });

});
