$(function(){
    $(".loadingsb").show();
        $.getJSON("../api/bid",function(result){
         $(".zhcon").html("");
         j = 0;
         $.each(result.LoanInfos, function(i, item){
          $(".zhcon").append("<tr class='list"  + item.ListingId + "' data-amount='" + item.Amount + "' data-months='"+ item.Months +"' data-code='" + item.CreditCode + "'><td>"+ item.ListingId +"</td><td>" + item.Amount + "</td><td>" +item.Months+ "</td><td>"+item.Rate + "%</td><td>" +item.CreditCode+ "</td><td><button type='button' class='btn btn-block btn-success btn-sm' data-toggle='modal' data-lid='" + item.ListingId + "' data-target='#modal-analysis' >分析</button></td><td><button type='button' class='btn btn-block btn-info btn-sm' data-toggle='modal' data-lid='" + item.ListingId + "' data-target='#modal-deal' >投资</button></td></tr>");
        });
         $(".loadingsb").hide();
         $('#example2').DataTable({
           "paging": true,
           "lengthChange": false,
           "searching": false,
           "ordering": true,
           "info": true,
           "autoWidth": false
         });
      });
});
