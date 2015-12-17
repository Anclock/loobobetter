<?php
/*
Template Name: 注册页面模板
*/
?><?php
//用户注册
global $wpdb, $user_ID; //glocal全局变量   
if (!$user_ID) { //如果存在$user_ID变量，则用户已经登录   
   //接下来的代码都添加在这里.     
}else{   
   wp_redirect( home_url() ); exit; //如果已经登录，重定向到站点首页   
}  
if(isset($_POST['registerSubmit'])){
	
	$user_name = username_exists($_POST['uname']);
	$user_email = email_exists($_POST['uemail']);
//	if($_POST['ukey'] == '549107'){
		if(!($_POST['uname'] == '')){
			if (!(preg_match("/[\x7f-\xff]/", $_POST['uname']))) { 
				if(!($_POST['upassword'] == '')){
					if(!($_POST['uemail'] == '')){
						if(strlen($_POST['uname'])>5 && strlen($_POST['uname'])<19){
							if(strlen($_POST['upassword'])>5 && strlen($_POST['upassword'])<19){
								if(preg_match('/(.*)@(.*)\.(.*)/i', $_POST['uemail'])){
									if(!$user_name){
										if(!$user_email){
											$creat = wp_create_user($_POST['uname'], $_POST['upassword'], $_POST['uemail']);
											if($creat){
												$art=array(
												  'ID' => $creat,
												  'nickname'=> strip_tags(trim($_POST["udisplayname"])),
												  'display_name' => strip_tags(trim($_POST["udisplayname"]))
												  
												);
												wp_update_user($art);
												$msg = '注册成功，请登录！';
											}
										}else{
											$msg = '已存在邮箱'.$_POST['uemail'];
										}
									}else{
										$msg = '已存在用户名'.$_POST['uname'];
									}
								}else{
									$msg = '邮箱格式不符合规范';
								}
							}else{
								$msg = '密码不符合规范';
							}
						}else{
							$msg = '用户名须大于5字少于19字';
						}
					}else{
						$msg = '邮箱不能为空';
					}
				}else{
					$msg = '密码不能为空！';
			}
			}else{
				$msg = '用户名不能为中文';
			}
		}else{
			$msg = '用户名不能为空！';
		}
	//}else{
	//		$msg = '邀请码不正确，请联系QQ1217561765';
	//	}
}
?>
<?php get_header(); ?>
<div class="focusbanner"></div>
<div id="main">
				<section class="container" style="margin-top:-20px;">
								<div class="sign-form">
								<h1>用户注册</h1>
									<?php //get_option('users_can_register')获取是否允许注册   
                                     if(get_option('users_can_register')) {   
                                     ?> 
								<?php if(isset($msg)){?>
								<div class="msgText"><?php echo $msg;?></div>
								<?php }else{?>
								<?php };?>

								<div class="acountFrom">
									<form method="post" id="registerForm">
									    <label>用户名</label>
										<input type="text" name="uname" class="ipt" placeholder="用户名(用于登陆和找回密码)">
										<label>昵称</label>
										<input type="text" name="udisplayname" class="ipt" placeholder="昵称(用于显示个性名称)">
										<label>邮箱</label>
										<input type="text" name="uemail" class="ipt" placeholder="邮箱(用于登陆和找回密码)">
										<label>密码</label>
										<input type="password" name="upassword" class="ipt" placeholder="登陆密码">
										<div class="sign-submit">
										<input type="submit" name="registerSubmit" value="注册" style="margin-top:15px;" class="btn btn-primary btn-block signsubmit-loader">
										</div>
									</form>
								</div>
								
								<?php }else{   ?>
								<div class="msgText">对不起暂时不开放注册，请以后再试.</div>
								<?php   } ?>
							</div>
							<aside class="sign-sidebar">
				<h2>第三方账号登录</h2>
				<h3>免去注册烦恼,第三方账号一键登录</h3>
				<a class="btn btn-primary" href="/login">本站登陆</a>
				<a class="btn btn-danger" href="<?php echo sina_login();?>">新浪登录</a>
				<a class="btn btn-success" href="#">微信登录</a>
			</aside>
		</section>		
</div>
<?php get_footer(); ?>