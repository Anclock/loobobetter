<div class="clearfix" id="homeMain">
		<div class="homeListBox" style="padding:20px 20px;background:#fff;">
            <div class="onlineList">
				<div class="setFormContent" style="width:708px;margin-left:auto;margin-right:auto;">
							<form action="" method="post" name="authorInfoMeta">
								<div class="setFormRow">
									<div class="setFormLabel"><label for="field1">昵称</label>:*</div>
									<div class="setFormWidget">
										<input value="<?php if($curauth->user_login){ echo $curauth->user_login; } ?>" name="contributeAuthorName" class="ipt">
									</div>
								</div>
								<div class="setFormRow">
									<div class="setFormLabel"><label for="field1">E-Mail</label></div>
									<div class="setFormWidget">
										<input value="<?php if($curauth->user_email){ echo $curauth->user_email; } ?>" name="contributeAuthorEmail" class="ipt">
									</div>
								</div>
								<div class="setFormRow">
									<div class="setFormLabel"><label for="field1"></label></div>
									<div class="setFormWidget">
										<input title="请输入文章标题" placeholder="请输入文章标题" name="contributeArtTitle" class="ipt">
									</div>
								</div>
								<div class="setFormRow">
									<div class="setFormLabel"><label for="field1"></label></div>
									<div class="setFormWidget">
										<input title="是否原创/否则填写地址" placeholder="是否原创/否则填写地址" name="contributeArtCopy" class="ipt">
									</div>
								</div>
								<div class="setFormRow">
									<div class="setFormLabel"><label for="field1"></label></div>
									<div class="setFormWidget">
										<textarea rows="15" cols="55" placeholder="请输入文章内容" id="contributeArtContent" name="contributeArtContent" class="setFormRequired"></textarea>
									</div>
								</div>
								<div class="setFormRow">
										<?php global $wpdb;
										$pending_posts = $wpdb->get_results("SELECT * FROM {$wpdb->posts}  WHERE post_status = 'pending' and post_author='{$current_user->ID}' ORDER BY post_modified DESC");
										if($pending_posts){ //判断是否有待审文章
										?>
										<button type="button" name="" class="setFormSubmit">目前有文章待审，暂不能发表新文章，认证请联系我们</button>
										<?php
										}else{?>
										<button type="submit" name="submit_contribut" class="btn btn-primary" style="width:708px;margin-top:5px;">发布文章</button>
										<?php } ?>
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
						'bold', 'italic','strikethrough','insertunorderedlist','insertorderedlist','hr','justifyleft', 'justifycenter', 'justifyright', 'link','unlink' , 'image']
				});
				
			});
								</script>
				</div>
			</div>
		</div>
</div>