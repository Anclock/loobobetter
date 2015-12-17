<?php
defined('ABSPATH') or die('This file can not be loaded directly.');

global $comment_ids; $comment_ids = array();
foreach ( $comments as $comment ) {
	if (get_comment_type() == "comment") {
		$comment_ids[get_comment_id()] = ++$comment_i;
	}
} 

if ( !comments_open() ) return;

$my_email = get_bloginfo ( 'admin_email' );
$str = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_approved = '1' AND comment_type = '' AND comment_author_email";
$count_t = $post->comment_count;

date_default_timezone_set(PRC);
$closeTimer = (strtotime(date('Y-m-d G:i:s'))-strtotime(get_the_time('Y-m-d G:i:s')))/86400;
?>

<div class="title" id="comments">
  <h3><b><?php echo $count_t; ?></b> 条评论</h3>
</div>
<div id="respond" class="no_webshot">
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) { ?>
	<div class="comment-signarea">
		<h3 class="text-muted">请先<a href="/login">登录</a>后评论！</h3>
	</div>
	<?php }elseif( get_option('close_comments_for_old_posts') && $closeTimer > get_option('close_comments_days_old') ) { ?>
  	<h3 class="title">
		<strong>评论已关闭！</strong>
	</h3>
  <?php }else{ ?>
  <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
    <div class="comt">
      <div class="comt-title">
        <?php 
			global $current_user;
			get_currentuserinfo();
			echo MBT_get_the_avatar($current_user->user_email,'28');	
			if ( is_user_logged_in() ) {
				printf('<p>'.$user_identity.'</p>');
			}else{
				if( get_option('require_name_email') && !empty($comment_author_email) ){
					printf('<p>'.$comment_author.'</p>');
				}else{
					printf('发表我的观点');
				}
			}
		?>
        <p><a id="cancel-comment-reply-link" href="javascript:;">取消</a></p>
      </div>
      <div class="comt-box">
        <textarea placeholder="你的评论..." class="input-block-level comt-area" name="comment" id="comment" cols="100%" rows="3" tabindex="1" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
        <div class="comt-ctrl">
          <div class="comt-tips">
            <?php comment_id_fields(); do_action('comment_form', $post->ID); ?>
          </div>
          <button type="submit" name="submit" id="submit" tabindex="5"> 提交评论</button>
        </div>
      </div>
      <?php if ( !is_user_logged_in() ) { ?>
		  <?php if( get_option('require_name_email') ){ ?>
          <div class="comt-comterinfo" id="comment-author-info">
            <ul>
              <li class="form-inline">
                <label class="hide" for="author">昵称</label>
                <input class="ipt" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" tabindex="2" placeholder="昵称">
              </li>
              <li class="form-inline">
                <label class="hide" for="email">邮箱</label>
                <input class="ipt" type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="3" placeholder="邮箱">
              </li>
              <li class="form-inline">
                <label class="hide" for="url">网址</label>
                <input class="ipt" type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" tabindex="4" placeholder="网址">
              </li>
            </ul>
          </div>
          <?php } ?>
      <?php } ?>
    </div>
  </form>
  <?php } ?>
</div>
<?php  

if ( have_comments() ) { 
?>
<div id="postcomments">
  <ol class="commentlist">
    <?php wp_list_comments('type=comment&callback=MBT_comment_list') ?>
  </ol>
  <div class="pagenav">
    <?php paginate_comments_links('prev_next=0');?>
  </div>
</div>
<?php 
} 
?>
