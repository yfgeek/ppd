<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0064)http://www.17sucai.com/preview/137615/2015-01-15/demo/index.html -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">

<HEAD>
	<META content="IE=11.0000" http-equiv="X-UA-Compatible">

	<html>

	<head>
		<title>用户登录</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<script type="text/javascript" src="/ppd/Public//jquery.min.js"></script>
		<STYLE>
			body {
				background: #ebebeb;
				font-family: "Helvetica Neue", "Hiragino Sans GB", "Microsoft YaHei", "\9ED1\4F53", Arial, sans-serif;
				color: #222;
				font-size: 12px;
			}
			
			* {
				padding: 0px;
				margin: 0px;
			}
			
			.top_div {
				background: #008ead;
				width: 100%;
				height: 300px;
			}
			
			.ipt {
				border: 1px solid #d3d3d3;
				padding: 10px 10px;
				width: 80%;
				border-radius: 4px;
				padding-left: 35px;
				-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
				box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
				-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
				-o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
				transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s
			}
			
			.ipt:focus {
				border-color: #66afe9;
				outline: 0;
				-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
				box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6)
			}
			
			.u_logo {
				background: url("/ppd/Public//img/username.png") no-repeat;
				padding: 10px 10px;
				position: absolute;
				top: 43px;
				left: 40px;
			}
			
			.p_logo {
				background: url("/ppd/Public//img/password.png") no-repeat;
				padding: 10px 10px;
				position: absolute;
				top: 12px;
				left: 40px;
			}
			
			a {
				text-decoration: none;
			}
			
			.tou {
				background: url("/ppd/Public//img/tou.png") no-repeat;
				width: 97px;
				height: 92px;
				position: absolute;
				top: -87px;
				left: 110px;
			}
			
			.left_hand {
				background: url("/ppd/Public//img/left_hand.png") no-repeat;
				width: 32px;
				height: 37px;
				position: absolute;
				top: -38px;
				left: 90px;
			}
			
			.right_hand {
				background: url("/ppd/Public//img/right_hand.png") no-repeat;
				width: 32px;
				height: 37px;
				position: absolute;
				top: -38px;
				right: -34px;
			}
			
			.initial_left_hand {
				background: url("/ppd/Public//img/hand.png") no-repeat;
				width: 30px;
				height: 20px;
				position: absolute;
				top: -12px;
				left: 70px;
			}
			
			.initial_right_hand {
				background: url("/ppd/Public//img/hand.png") no-repeat;
				width: 30px;
				height: 20px;
				position: absolute;
				top: -12px;
				right: -82px;
			}
			
			.left_handing {
				background: url("/ppd/Public//img/left-handing.png") no-repeat;
				width: 30px;
				height: 20px;
				position: absolute;
				top: -24px;
				left: 139px;
			}
			
			.right_handinging {
				background: url("/ppd/Public//img/right_handing.png") no-repeat;
				width: 30px;
				height: 20px;
				position: absolute;
				top: -21px;
				left: 210px;
			}
		</STYLE>
	</head>

	<body>

		<SCRIPT type="text/javascript">
$(function(){
	//得到焦点
	$("#password").focus(function(){
		$("#left_hand").animate({
			left: "130px",
			top: " -38px"
		},{step: function(){
			if(parseInt($("#left_hand").css("left"))>140){
				$("#left_hand").attr("class","left_hand");
			}
		}}, 2000);
		$("#right_hand").animate({
			right: "-34px",
			top: "-38px"
		},{step: function(){
			if(parseInt($("#right_hand").css("right"))> -70){
				$("#right_hand").attr("class","right_hand");
			}
		}}, 2000);
		$(".check-tips").text("睁一只眼，闭一只眼");
	});
	//失去焦点
	$("#password").blur(function(){
		$("#left_hand").attr("class","initial_left_hand");
		$("#left_hand").attr("style","left:70px;top:-12px;");
		$("#right_hand").attr("class","initial_right_hand");
		$("#right_hand").attr("style","right:-82px;top:-12px");
	});
});
</SCRIPT>
</HEAD>

<BODY>
	<DIV class="top_div"></DIV>
	<DIV style="background: rgb(255, 255, 255); margin: -94px auto auto; border: 1px solid rgb(231, 231, 231); border-image: none; width:320px; height: 150px; text-align: center;">
		<DIV style="width: 165px; height: 96px; position: absolute;">
			<DIV class="tou"></DIV>
			<DIV class="initial_left_hand" id="left_hand"></DIV>
			<DIV class="initial_right_hand" id="right_hand"></DIV>
		</DIV>
		<form class="form-horizontal" action="<?php echo U('login','','');?>" role="form" method="post">
			<P style="position: relative;    margin-top: 25px;">
				<INPUT class="ipt" id="password" type="password" name="password" placeholder="请输入密码" value="">
			</P>
			<DIV style="height: 50px; line-height: 50px; margin-top: 30px; border-top-color: rgb(231, 231, 231); border-top-width: 1px; border-top-style: solid;">
				<P style="margin: 0px 35px 20px 45px;">
					<SPAN style="float: left;"><A class="check-tips" style="color: rgb(0, 142, 173);" 
href="#">二凡就是不告诉你密码</A></SPAN>
					<SPAN style="float: right;">
           <button style="background: rgb(0, 142, 173); padding: 7px 10px; border-radius: 4px; border: 1px solid rgb(26, 117, 152); border-image: none; color: rgb(255, 255, 255); font-weight: bold;cursor: pointer;margin-top:8px"   id="submit" type="submit" class="btn btn-primary btn-login">登录</button>
           </SPAN> </P>
			</DIV>
		</form>
	</DIV>
	<script>
	//表单提交
	$(document)
		.ajaxStart(function(){
			$("button:submit").attr("disabled", true);
		})
		.ajaxStop(function(){
			$("button:submit").attr("disabled", false);
		});

	$("form").submit(function(){
		var self = $(this);
		$.post(self.attr("action"), self.serialize(), success, "json");
		return false;

		function success(data){
			if(data.status){
				window.location.href = data.url;
			} else {
				self.find(".check-tips").text(data.info);
			}
		}
	});
	$(function(){
		//初始化选中用户名输入框
		$("#login").find("input[name=password]").focus();
	});
</script>


</body>

</html>