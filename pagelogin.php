<?php
/*
Template Name: 登陆页面模板
*/
?><?php
//用户注册
global $wpdb, $user_ID; //glocal全局变量   
if (!$user_ID) { //如果存在$user_ID变量，则用户已经登录   
   //接下来的代码都添加在这里.     
}else{   
   wp_redirect( home_url() ); exit; //如果已经登录，重定向到站点首页   
}  
$creds = array(
	'user_login'	=> '',
	'user_password'	=> '',
	'remember'	=> ''
);
if(isset($_POST['loginSubmit'])){
	if($_POST['uname'] == '' || $_POST['upassword'] == ''){
		$msg = '用户或者密码不能为空';
	}else{
		$creds['user_login'] = $_POST['uname'];
		$creds['user_password'] = $_POST['upassword'];
		$creds['remember'] = $_POST['rememberme'];
		$user = wp_signon( $creds, false );
		if(is_wp_error($user)){
			$msg = '用户名或者密码错误';
		}elseif(current_user_can('manage_options')){
			header('location:/wp-admin/');
		}elseif(isset($_GET['redirect_to'])){
			header('location:'.$_GET['redirect_to']);
		}else{
			
			wp_redirect( home_url() ); exit;
		}
	}
}
?>
<?php get_header(); ?>
<div class="focusbanner"></div>
<div id="main">
	<section class="container" style="margin-top:-20px;">
		<div class="sign-form">
			<h1>用户登录</h1>
				<?php if(isset($msg)){?>
			<div class="msgText"><?php echo $msg;?></div>
				<?php }else{?>
				<?php };?>
								
	<div class="acountFrom">
	<form method="post" id="formLogin">
		<div>
		    <label>用户名或邮箱</label>
			<input type="text" placeholder="用户名/邮箱" class="ipt" name="uname">
		</div>
		<div>
		    <label>用户密码</label>
			<input type="password" placeholder="密码" class="ipt" name="upassword">
		</div>
		<div class="sign-submit">
			<input type="submit" name="loginSubmit"  value="登录" style="margin-top:15px;" class="btn btn-primary btn-block signsubmit-loader">
		</div>								
		<div class="findPassword">
			<input <?php if($creds['remember']) echo 'checked="checked"';?> type="checkbox" name="rememberme">记住我的登录信息
		<a href="/resetpassword">忘记密码?</a>
		</div>
	</form>
    </div>
</div>
<aside class="sign-sidebar">
				<h2>第三方账号登录</h2>
				<h3>免去注册烦恼,第三方账号一键登录</h3>
				<a class="btn btn-primary" href="/register">本站注册</a>
				<a class="btn btn-danger" href="<?php echo sina_login();?>">新浪登录</a>
				<a class="btn btn-success" href="#">微信登录</a>
			</aside>
</section>
</div>
<?php get_footer(); ?>