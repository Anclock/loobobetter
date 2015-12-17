<div class="clearfix" id="homeMain">
        <div class="homeManage">
			<h1>账号管理</h1>
        </div>
        <div class="leftBar">
            <p class="manageTag">
				<a class=""  href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=setting">修改资料</a>
				<a class="active"  href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=setting&n=avatar">设置头像</a>
				<a class=""  href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=setting&n=password">安全中心</a>
			</p>
        </div>
		
        <div class="homeListBox">
                <div class="auditTabs">
                    <a class="current" href="javascript:void(0)">已上线</a>
                </div>
                <div class="onlineList">
					<div class="setFormContent">
						<fieldset>
							<legend>基本资料：<?php if(isset($success_msg)){
								echo $success_msg;}else{echo '修改在运营笔记的个人头像'; };?>
							</legend>
						<div class="setFormRow">
							<img src="<?php bloginfo('url'); ?>/wp-content/uploads/avatars/<?php if($curauth->ID){ echo md5($curauth->ID); }?>.jpg" onerror="javascript:this.src='<?php bloginfo('url'); ?>/wp-content/uploads/avatars/avatar.jpg'" />
						</div>
						<form action="" enctype="multipart/form-data" method="post" onsubmit="return checkfile()" >
												<div class="setFormRow">
    <input type="file" name="uppic" class="setFormSubmit" id="uppic"/>	</div>
	<div class="setFormRow">
<button class="setFormSubmit" name="picSubmit" type="submit">确认修改头像</button>		</div>
</form>	</fieldset>
								</div>
				</div>
		</div>
</div>