<?php get_header();?>
<section class="container">
<div class="content-wrap">
	<div class="content">
		<?php while (have_posts()) : the_post(); ?>
		<div class="article-header">
			<h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
            <div class="article-meta">
				<span class="item"><?php echo get_the_time('Y-m-d')?> / <?php $category = get_the_category();echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';?></span>
				<span class="item post-views">阅读(<?php MBT_views(''); ?>)</span>
				<span class="item"><?php edit_post_link('[编辑]'); ?></span>
			</div>
		</div>
		<article class="article-content">
			<?php the_content(); ?>
		</article>
		<?php endwhile;  ?>
        <div class="article-footer">
			<?php the_tags('<div class="article-tags">标签：','',' </div>'); ?>
			<div class="article-share">
			 <div class="bdShare">
				  <div data-bd-bind="1438369216034" class="bdsharebuttonbox bdshare-button-style0-16" data-tag="share_1">
				    <a title="分享到新浪微博" class="bds_tsina" data-cmd="tsina"></a>
					<a title="分享给QQ好友" class="bds_sqq" data-cmd="sqq"></a>
					<a title="分享到腾讯微博" class="bds_tqq" data-cmd="tqq"></a>
					<a title="分享到微信" class="bds_weixin" data-cmd="weixin"></a>
					<a title="分享到QQ空间" class="bds_qzone" data-cmd="qzone"></a>
					<a title="邮件分享" class="bds_mail" data-cmd="mail"></a>
				  </div>
				</div>
			</div>
            <nav class="article-nav">
                <span class="article-nav-prev"><?php previous_post_link('上一篇 %link'); ?></span>
                <span class="article-nav-next"><?php next_post_link('%link 下一篇'); ?></span>
            </nav>
        </div>
		<div class="relates">
			<h4 class="title">猜你喜欢</h4>
			<?php include( 'functions/related.php' ); ?>
		</div>
		<?php comments_template('', true); ?>
	</div>
</div>
<?php get_sidebar();  get_footer(); ?>
