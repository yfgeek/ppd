$(function(){
    $(".loadingsb").show();
        $.getJSON("../api/bid",function(result){
         $(".zhcon").html("");
         j = 0;
         $.each(result.LoanInfos, function(i, item){
         $(".zhcon").append("<tr><td>"+ item.ListingId +"</td><td>" + item.Amount + "</td><td>" +item.Months+ "</td><td>"+item.Rate + "%</td><td>" +item.CreditCode+ "</td><td><button type='button' class='btn btn-block btn-success btn-sm'>分析</button></td><td><button type='button' class='btn btn-block btn-info btn-sm'>投资</button></td></tr>");

         j++;
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
