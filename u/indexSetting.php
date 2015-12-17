<?php
if(isset($_POST['submit_personal'])){
	if ( is_user_logged_in() ) {
		$art=array(
			  'ID' => $current_user->ID,
			  'nickname'=> strip_tags(trim($_POST["displayName"])),
			  'display_name' => strip_tags(trim($_POST["displayName"])),
			  'user_email' => strip_tags(trim($_POST["userEmail"])),
			  'user_url' => strip_tags(trim($_POST["userUrl"])),
			  'user_qq' => strip_tags(trim($_POST["userQq"])),
			  'user_weibo' => strip_tags(trim($_POST["userWeibo"])),
			  'description' => strip_tags(trim($_POST["description"]))
			  
			);
			$user_id=wp_update_user($art);
		if($user_id){
			$success_msg = '个人信息更新成功！';
			//echo "<script language=\"JavaScript\">alert(\"个人信息更新成功！\");</script>"; 
		}else{
			$success_msg = '个人信息更新失败！';
		}
	}else{
		wp_redirect( home_url() ); exit; 
	}
}
?>

<div class="clearfix" id="homeMain">
        <div class="homeListBox" style="padding:20px 20px;background:#fff;">
                <div class="onlineList">
					<div class="setFormContent" style="width:300px;margin-left:auto;margin-right:auto;">
										<form action="" method="post" name="authorInfoMeta">
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">昵称</label>:</div>
											<div class="setFormWidget">
												<input title="请输入昵称" placeholder="请输入昵称" value="<?php if($curauth->display_name){ echo $curauth->display_name; } ?>" name="displayName" class="ipt">
											</div>
										</div>
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">邮箱</label></div>
											<div class="setFormWidget">
												<input title="请输入用户邮箱" placeholder="请输入用户邮箱"  value="<?php if($curauth->user_email){ echo $curauth->user_email; } ?>" name="userEmail" class="ipt">
											</div>
										</div>
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">网址</label></div>
											<div class="setFormWidget">
												<input title="请输入个人网站或博客" placeholder="请输入个人网站或博客" value="<?php if($curauth->user_url){ echo $curauth->user_url; } ?>" name="userUrl" class="ipt">
											</div>
										</div>
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">QQ</label></div>
											<div class="setFormWidget">
												<input title="请输入个人QQ" placeholder="请输入个人QQ"  value="<?php if($curauth->user_qq){ echo $curauth->user_qq; } ?>" name="userQq" class="ipt">
											</div>
										</div>
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">微博地址</label></div>
											<div class="setFormWidget">
												<input title="请输入微博个性域名" placeholder="请输入微博个性域名"   value="<?php if($curauth->user_weibo){ echo $curauth->user_weibo; } ?>" name="userWeibo"class="ipt">
											</div>
										</div>
										<div class="setFormRow">
											<div class="setFormLabel"><label for="field1">个人介绍</label></div>
											<div class="setFormWidget">
												<textarea placeholder="请输入个人介绍" name="description" class="ipt"><?php if($curauth->description){ echo $curauth->description; } ?></textarea>
											</div>
										</div>
										<div class="setFormRow">
										<button type="submit" name="submit_personal" class="btn btn-primary" style="width:300px;margin-top:5px;">确认修改资料</button>
												</div>
										</form>
								</div>
				</div>
		</div>
</div>