<div class="clearfix" id="homeMain">
        <div class="homeManage">
			<h1>内容管理</h1>
        </div>
        <div class="leftBar">
            <p class="manageTag">
				<a class="active"  href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=article">已发布</a>
				<a  href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=article&n=audit">审核箱</a>
				<a  href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=comment">评论箱</a>
			</p>
        </div>
        <div class="homeListBox">
                <div class="auditTabs">
                    <a class="current" href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=article">文章</a><a class="" href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=article&n=ask">问题</a>
                </div>
                <div class="onlineList">
					<ul>
					<?php if ( have_posts() ) : ?>
					<?php $posts = query_posts($query_string . '&cat=-103'); ?>
					<?php while(have_posts()) : the_post(); ?>
						<li class="item">
							<span class="date"><?php the_time('Y-m-d') ?></span>
							<a class="text" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<span class="re"><?php comments_popup_link('0 条评论', '1 条评论', '% 条评论', '', '0 条评论'); ?></span>
						</li>
					<?php endwhile; ?>
					<?php else : ?>暂无发表文章<?php endif; ?>
					</ul>
					<div class="navigation clear">
						<div class="prevPage"><?php previous_posts_link('上一页'); ?></div>
						<div class="nextPage"><?php next_posts_link('下一页'); ?></div>
					</div>
				</div>
		</div>
</div>