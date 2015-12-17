<div class="clearfix" id="homeMain">
        <div class="homeManage">
			<h1>内容管理</h1>
        </div>
        <div class="leftBar">
            <p class="manageTag">
				<a href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=article">已发布</a>
				<a href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=article&n=audit">审核箱</a>
				<a class="active" href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=comment">评论箱</a>
			</p>
        </div>
        <div class="homeListBox">
                <div class="auditTabs">
                    <a class="current" href="javascript:void(0)">已发表</a>
                </div>
                <div class="onlineList">
					<ol class="commentlist">
								<?php
								$show_comments = 10; //评论数量
								//$my_email = get_bloginfo ('admin_email'); //获取博主自己的email
								$my_id = $curauth->ID; 
								$i = 1;
								$comments = get_comments('number=200&status=approve&type=comment&user_id='.$my_id); //取得前200个评论，如果你每天的回复量超过200可以适量加大
								foreach ($comments as $rc_comment) {
										$comment_post_id= $rc_comment->comment_post_ID;
										
										//	if ($rc_comment->comment_author_email != $my_email) {
										?>
										<li class="comment"><?php echo get_avatar( $rc_comment->user_id, 32 ); ?>
											<span class="comment_author">
											<?php echo $rc_comment->comment_author; ?> says:<a href="<?php echo get_permalink($rc_comment->comment_post_ID); ?>"><?php echo get_post($rc_comment->comment_post_ID)->post_title;?></a></span>
											<a href="<?php echo get_permalink($rc_comment->comment_post_ID); ?>#comment-<?php echo $rc_comment->comment_ID; ?>">
											<section class="comment-content comment">
											<p>
											<?php if( $rc_comment->comment_parent > 0) {
													echo'@<a href="'.get_permalink($rc_comment->comment_post_ID).'#comment-' . $rc_comment->comment_parent . '">'.get_comment_author( $rc_comment->comment_parent ) . '</a> ' .convert_smilies($rc_comment->comment_content);
												} else { echo convert_smilies($rc_comment->comment_content);}?>
											</p>
											</section>
											</a></li>
										<?php
										if ($i == $show_comments) break; //评论数量达到退出遍历
										$i++;
								//	} // End if
								} //End foreach
								?>
								</ol>
				</div>
		</div>
</div>