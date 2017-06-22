$(function(){
$.getJSON("/Fan/Admin/Api/editcon", {'action':'del','id':id,'pass':pass,'editcon':''}, function(json){
			if(json.status == 'success'){
			listname='.list'+id;
			$("#myModal").modal('hide');
			$(listname).hide();
			}
			else if(json.status == 'ep'){
			$(".alert1").show();
			}
			else{
			alert("删除失败！");
			};
			});
});
