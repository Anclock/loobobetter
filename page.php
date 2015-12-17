<?php get_header();?>
<section class="container">
<div class="content-wrap">
	<div class="content">
		<?php while (have_posts()) : the_post(); ?>
		<div class="article-header">
			<h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
            <div class="article-meta">
				<span class="item"><?php echo get_the_time('Y-m-d')?></span>
				<span class="item post-views">阅读(<?php MBT_views(''); ?>)</span>
				<span class="item"><?php edit_post_link('[编辑]'); ?></span>
			</div>
		</div>
		<article class="article-content">
			<?php the_content(); ?>
		</article>
		<?php endwhile;  ?>
		<?php comments_template('', true); ?>
	</div>
</div>
<?php get_sidebar();  get_footer(); ?>
