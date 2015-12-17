<div class="clearfix" id="homeMain">
        <div class="homeManage">
			<h1>内容管理</h1>
        </div>
        <div class="leftBar">
            <p class="manageTag">
				<a  href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=article">已发布</a>
				<a class="active"  href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=article&n=audit">审核箱</a>
				<a  href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=comment">评论箱</a>
			</p>
        </div>
        <div class="homeListBox">
                <div class="auditTabs">
                    <a class="current" href="javascript:void(0)">审核中</a>
                </div>
                <div class="onlineList">
					<ul>
					<?php global $wpdb;
	$pending_posts = $wpdb->get_results("SELECT * FROM {$wpdb->posts}  WHERE post_status = 'pending' and post_author='{$current_user->ID}' ORDER BY post_modified DESC");

	if($pending_posts){ //判断是否有待审文章
		foreach ($pending_posts as $pending_post){
			?>
				<li class="item">
							<span class="date"><?php echo date('Y-m-d', strtotime($pending_post->post_date)); ?></span>
							<a class="text" href="<?php echo $pending_post->guid; ?>"><?php echo $pending_post->post_title; ?></a>
						</li>
		
			<?php
		}
	}else echo '目前没有待审文章'; ?>
					</ul>
					<div class="navigation clear">
						<div class="prevPage"><?php previous_posts_link('上一页'); ?></div>
						<div class="nextPage"><?php next_posts_link('下一页'); ?></div>
					</div>
				</div>
		</div>
</div>