<article class="excerpt">
	<a class="focus" href="<?php the_permalink(); ?>"><img src="<?php echo MBT_thumbnail(160,109);?>" class="thumb" alt="<?php the_title(); ?>"/></a>
    <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
    <p class="note"><?php echo mb_strimwidth( MBT_strip_tags( $post->post_content ), 0, "150","...");?></p>
    <p class="meta">
    <time><?php echo get_the_time('Y-m-d') ?></time>
    <?php $category = get_the_category();if($category[0]){echo '<a class="pc" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';}?>
    <a class="pc" href="<?php the_permalink(); ?>#comments">评论(<?php echo get_comments_number('0', '1', '%');?>)</a></p>
</article>
