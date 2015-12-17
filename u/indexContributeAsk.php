<div class="clearfix" id="homeMain">
        <div class="homeManage">
			<h1>发布内容</h1>
        </div>
		<div class="leftBar">
            <p class="manageTag">
				<a href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=contribute">发表文章</a>
				<a class="active" href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=contribute&n=ask">发表问题</a>
			</p>
        </div>
		<div class="homeListBox">
            <div class="auditTabs">
                <a class="current" href="javascript:void(0)">发布问题</a>
            </div>
            <div class="onlineList">
				<div class="setFormContent">
					<fieldset>
						<legend>发布文章：<?php if(isset($success_msg)){echo $success_msg;}else{echo '发布在运营笔记的文章'; };?></legend>
							<form action="" method="post" name="authorInfoMeta">
								<div class="setFormRow">
									<div class="setFormLabel"><label for="field1">文章标题</label>:*</div>
									<div class="setFormWidget">
										<input title="请输入文章标题" placeholder="请输入文章标题" name="contributeArtTitle" class="setFormRequired">
									</div>
								</div>
								<div class="setFormRow">
									<div class="setFormLabel"><label for="field1">选择分类</label>:</div>
									<div class="setFormWidget">
										<select name="contributeAsk">  
											 <option value="交互体验">交互体验</option>  
											 <option value="推广营销">推广营销</option>  
											 <option value="运营管理">运营管理</option>  
											 <option value="其他问题">其他问题</option>  
										</select>
									</div>
								</div>
								<div class="setFormRow">
									<div class="setFormLabel"><label for="field1">文章内容</label>:*</div>
									<div class="setFormWidget">
										<textarea rows="15" cols="55" placeholder="请输入文章内容" id="contributeArtContent" name="contributeArtContent" class="setFormRequired"></textarea>
									</div>
								</div>
								<div class="setFormRow">
										<button type="submit" name="submit_contributAsk" class="setFormSubmit">发布文章</button>
								</div>
							</form>
								<link href="<?php bloginfo('template_url'); ?>/edit/themes/default/default.css" rel="stylesheet">
								<link href="http://app.chinaz.com/js/kindeditor/themes/cz/style.css" rel="stylesheet">
								<script src="<?php bloginfo('template_url'); ?>/edit/kindeditor-min.js" charset="utf-8"></script>
								<script src="<?php bloginfo('template_url'); ?>/edit/lang/zh_CN.js" charset="utf-8"></script>
								<script>
											var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="contributeArtContent"]', {
					themeType : 'cz',
					resizeType : 1,
					minWidth:708,
					minHeight:500,
					allowPreviewEmoticons : false,
					allowImageUpload : true,
					formatUploadUrl:false,
					uploadJson :'<?php bloginfo('template_url'); ?>/edit/php/upload_json.php',
					afterBlur: function(){this.sync();},
					items : [
						'bold', 'italic','strikethrough','insertunorderedlist','insertorderedlist','hr','justifyleft', 'justifycenter', 'justifyright', 'link','unlink' , 'code']
				});
				
			});
								</script>
					</fieldset>
				</div>
			</div>
		</div>
</div>