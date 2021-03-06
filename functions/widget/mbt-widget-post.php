<?php
add_action( 'widgets_init', 'widget_ui_posts' );

function widget_ui_posts() {
	register_widget( 'widget_ui_posts' );
}

class widget_ui_posts extends WP_Widget {
	function widget_ui_posts() {
		$widget_ops = array( 'classname' => 'widget_ui_posts', 'description' => '图文展示（最新文章+热门文章+随机文章）' );
		$this->WP_Widget( 'widget_ui_posts', 'Mona-文章列表', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title        = apply_filters('widget_name', $instance['title']);
		$limit        = $instance['limit'];
		$cat          = $instance['cat'];
		$orderby      = $instance['orderby'];
		$img = $instance['img'];

		$style='';
		if( !$img ) $style = ' class="nopic"';
		echo $before_widget;
		echo $before_title.$mo.$title.$after_title; 
		echo '<ul'.$style.'>';
		echo mbtheme_posts_list( $orderby,$limit,$cat,$img );
		echo '</ul>';
		echo $after_widget;
	}

	function form( $instance ) {
?>
		<p>
			<label>
				标题：
				<input style="width:100%;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label>
				排序：
				<select style="width:100%;" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" style="width:100%;">
					<option value="comment_count" <?php selected('comment_count', $instance['orderby']); ?>>评论数</option>
					<option value="date" <?php selected('date', $instance['orderby']); ?>>发布时间</option>
					<option value="rand" <?php selected('rand', $instance['orderby']); ?>>随机</option>
				</select>
			</label>
		</p>
		<p>
			<label>
				分类限制：
				<a style="font-weight:bold;color:#f60;text-decoration:none;" href="javascript:;" title="格式：1,2 &nbsp;表限制ID为1,2分类的文章&#13;格式：-1,-2 &nbsp;表排除分类ID为1,2的文章&#13;也可直接写1或者-1；注意逗号须是英文的">？</a>
				<input style="width:100%;" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="text" value="<?php echo $instance['cat']; ?>" size="24" />
			</label>
		</p>
		<p>
			<label>
				显示数目：
				<input style="width:100%;" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" size="24" />
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['img'], 'on' ); ?> id="<?php echo $this->get_field_id('img'); ?>" name="<?php echo $this->get_field_name('img'); ?>">显示图片
			</label>
		</p>
		
	<?php
	}
}


function mbtheme_posts_list($orderby,$limit,$cat,$img) {
	$args = array(
		'order'            => DESC,
		'cat'              => $cat,
		'orderby'          => $orderby,
		'showposts'        => $limit,
		'caller_get_posts' => 1
	);
	query_posts($args);
	while (have_posts()) : the_post(); 
?>
<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if( $img ){echo '<span class="thumbnail"><img src="'.MBT_thumbnail(75,58).'" class="thumb" alt="'.get_the_title().'" /></span>'; }else{$img = '';} ?><h4><?php the_title(); ?></h4></a></li>
<?php
	
    endwhile; wp_reset_query();
}

?>