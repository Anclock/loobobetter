<?php get_header();?>
<div class="focusbanner">
	<div class="container">
		<?php
		$current_user = wp_get_current_user();
		if ( 0 == $current_user->ID ) {
	?>
		<a class="btn btn-primary" href="/login">登录 loob.me</a>
		<a class="btn btn-whrite" href="/register">快速注册</a>
	<?php
		} else {
	?>
	<?php global $current_user;
	get_currentuserinfo();?>
		<a class="btn btn-primary" href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>">会员中心</a>
	<?php
		if( $current_user->roles[0] == 'administrator'|| $current_user->roles[0] == 'editor') {
	?>
		<a class="btn btn-primary" href="<?php bloginfo('url'); ?>/wp-admin">高级管理</a>
	<?php
		}
	?>
		<a class="btn btn-primary" href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Logout">注销</a>
	<?php
		}
	?> 
	</div>
</div>
<section class="container">
<?php 
		$args= array('post_type' => array('bulletin'), 'showposts' => 4, 'orderby' => 'date' , 'order' => 'desc');
		$bulletins = new wp_query( $args );
	?>
	<?php if ($bulletins->have_posts()): ?>
	<section id="notice">
		<div class="container">
				<ul class="ebox">
					<?php while ($bulletins->have_posts()) : $bulletins->the_post(); ?>
					<li class="ebox-i ebox-01">
					<h4><?php the_title(); ?></h4>
					<p>
					    <?php 
						if ($post->post_excerpt) {
						_e(wp_trim_words( $post->post_excerpt, 40,'......' ));
						} else {
						_e(wp_trim_words( $post->post_content, 40,'......' )); 
						}
						?>
					</p>
					<a class="btn btn-sm btn-primary" target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">继续阅读</a></li>
					<?php endwhile; wp_reset_query(); ?>
					<?php endif; ?>
					<li class="ebox-i ebox-100" style="background-color:#FF8966">
			          <h4 style="color:#fff">有任何需要请联系我们</h4>
					  <p style="color:#fff">您可以通过微博或者QQ找到我们</p>
			          <a class="btn btn-sm btn-whrite" target="_blank" href="#">关注微博</a>
					  <a class="btn btn-sm btn-whrite" target="_blank" href="#">在线咨询</a>
		            </li>
				</ul>
				
		</div>
	</section>
	
  <div class="content-wrap">
    <div class="content">
      <?php while ( have_posts() ) : the_post();get_template_part( 'content', get_post_format() );endwhile; wp_reset_query();?>
      <?php MBT_paging();?>
    </div>
  </div>
<?php get_sidebar(); get_footer();?>
