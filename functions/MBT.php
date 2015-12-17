<?php 
	remove_action( 'wp_head',   'feed_links_extra', 3 ); 
	remove_action( 'wp_head',   'rsd_link' ); 
	remove_action( 'wp_head',   'wlwmanifest_link' ); 
	remove_action( 'wp_head',   'index_rel_link' ); 
	remove_action( 'wp_head',   'start_post_rel_link', 10, 0 ); 
	remove_action( 'wp_head',   'wp_generator' ); 
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter('the_content', 'wptexturize');
	wp_deregister_script( 'l10n' ); 
	
	add_filter( 'pre_option_link_manager_enabled', '__return_true' );
	
	function hide_admin_bar($flag) {
		return false;
	}
	add_filter('show_admin_bar','hide_admin_bar');
	
	function MBT_remove_open_sans() {
		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );
		wp_enqueue_style('open-sans', '');
	}
	add_action( 'init', 'MBT_remove_open_sans' );
	
	function MBT_scripts() {
		$dir = get_bloginfo('template_directory');
		wp_enqueue_style('style', get_bloginfo('stylesheet_url'), array(), theme_ver, 'screen');
		wp_enqueue_script( 'jquery.min', $dir . '/static/js/jquery.min.js', false, theme_ver, true);
		if(is_singular()){
			wp_enqueue_script( 'comment', $dir . '/static/js/comment.js', false, theme_ver, true);
		}
	}
	add_action('wp_enqueue_scripts', 'MBT_scripts');
	
	function MBT_title( $title, $sep ) {
		global $paged, $page;
		if ( is_feed() )
			return $title;
		$title .= get_bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";
	
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( '第%s页', 'mobantu' ), max( $paged, $page ) );
		return $title;
	}
	add_filter( 'wp_title', 'MBT_title', 10, 2 );

	
	function MBT_keywords() {
	  global $s, $post;
	  $keywords = '';
	  if ( is_single() ) {
		if ( get_the_tags( $post->ID ) ) {
		  foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
		}
		foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
		$keywords = substr_replace( $keywords , '' , -2);
	  } elseif ( is_home () )    { $keywords = get_bloginfo("name");
	  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
	  } elseif ( is_category() ) { $keywords = single_cat_title('', false);
	  } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
	  } else { $keywords = trim( wp_title('', false) );
	  }
	  if ( $keywords ) {
		echo "<meta name=\"keywords\" content=\"$keywords\">\n";
	  }
	}
	
	function MBT_description() {
	  global $s, $post;
	  $description = '';
	  $blog_name = get_bloginfo('name');
	  if ( is_singular() ) {
		if( !empty( $post->post_excerpt ) ) {
		  $text = $post->post_excerpt;
		} else {
		  $text = $post->post_content;
		}
		$description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
		if ( !( $description ) ) $description = $blog_name . "-" . trim( wp_title('', false) );
	  } elseif ( is_home () )    { $description = get_bloginfo("description");
	  } elseif ( is_tag() )      { $description = $blog_name . "'" . single_tag_title('', false) . "'";
	  } elseif ( is_category() ) { $description = trim(strip_tags(category_description()));
	  } elseif ( is_archive() )  { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
	  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
	  } else { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
	  }
	  $description = mb_substr( $description, 0, 220, 'utf-8' );
	  echo "<meta name=\"description\" content=\"$description\">\n";
	}
	
	if (function_exists('register_nav_menus')){
		register_nav_menus( array(
			'main' => __('顶部菜单')
		));
	}
	
	if (function_exists('register_sidebar')){
		register_sidebar(array(
			'name'          => '全站右侧栏',
			'id'            => 'sidebar',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		));
	}
	
	if ( ! function_exists( 'MBT_views' ) ) :
	function Mobantu_record_visitors(){
		if (is_singular()) 
		{
		  global $post;
		  $post_ID = $post->ID;
		  if($post_ID) 
		  {
			  $post_views = (int)get_post_meta($post_ID, 'views', true);
			  if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
			  {
				add_post_meta($post_ID, 'views', 1, true);
			  }
		  }
		}
	}
	add_action('wp_head', 'Mobantu_record_visitors');  
	
	function MBT_views($after=''){
	  global $post;
	  $post_ID = $post->ID;
	  $views = (int)get_post_meta($post_ID, 'views', true);
	  echo $views, $after;
	}
	endif;
	
	function MBT_strip_tags($content){
		if($content){
			$content = preg_replace("/\[.*?\].*?\[\/.*?\]/is", "", $content);
		}
		return strip_tags($content);
	}
	
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(220, 150, true); 
	function MBT_thumbnail($width=220, $height=150, $echo=1){
		global $post;
		$title = $post->post_title;
		$dir = get_bloginfo('template_directory');
		$siteurl = get_bloginfo('url');
		$post_img = '';
		if( has_post_thumbnail() ){
			$timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'thumbnail');
			$src = $timthumb_src[0];
			$post_img_src = "$dir/timthumb.php?src=$src&w=$width&h=$height&zc=1&q=100";
		}else{
			ob_start();
			ob_end_clean();
			$output = preg_match_all('/\<img.+?src="(.+?)".*?\/>/is',$post->post_content,$matches ,PREG_SET_ORDER);
			$cnt = count( $matches );
			if($cnt>0){
				$src = $matches[0][1];
			}else{ 
				$src = "{$dir}/static/img/thumbnail.png";
			}
			$post_img_src = "$dir/timthumb.php?src=$src&w=$width&h=$height&zc=1&q=100";
		}
		$post_img =$post_img_src;
		return $post_img;
		
	}
	
	function MBT_paging() {
		$p = 3;
		if ( is_singular() ) return;
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return; 
		echo '<div class="pagination"><ul>';
		if ( empty( $paged ) ) $paged = 1;
		echo '<li class="prev-page">'; previous_posts_link('上一页'); echo '</li>';
	
		if ( $paged > $p + 1 ) m_link( 1, '<li>第一页</li>' );
		if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><span>{$i}</span></li>" : m_link( $i );
		}
		if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
		if ( $paged < $max_page - $p ) m_link( $max_page, '&raquo;' );
		echo '<li class="next-page">'; next_posts_link('下一页'); echo '</li>';
		echo '</ul></div>';
	}
	
	function m_link( $i, $title = '' ) {
		if ( $title == '' ) $title = "第 {$i} 页";
		echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$i}</a></li>";
	}
	
	function MBT_comment_list($comment, $args, $depth) {  
		echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';
		echo '<div class="comt-avatar">'.MBT_get_the_avatar($comment->comment_author_email,'36').'</div>';
		echo '<div class="comt-main" id="div-comment-'.get_comment_ID().'">';
		echo str_replace(' src=', ' data-original=', convert_smilies(get_comment_text()));
		if ($comment->comment_approved == '0'){
			echo '<span class="comt-approved">您的评论正在排队审核中，请稍后！</span><br />';
		}
		echo '<div class="comt-meta">';
		echo '<span class="comt-author">'.get_comment_author_link().'</span>';
		echo get_comment_time("m-d H:i"); 
		if ($comment->comment_approved !== '0'){ 
			echo comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
			echo edit_comment_link(__('(编辑)'),' - ','');
		} 
		echo '</div>';
		echo '</div>';
	}
	
	add_filter('the_content', 'MBT_post_copyright');
	function MBT_post_copyright($content) {
		if ( !is_page()) {
			$content .= '<p class="post-copyright">转载请注明出处：<a href="' . get_bloginfo('url') . '">' . get_bloginfo('name') . '</a> &raquo; <a href="' . get_permalink() . '">' . get_the_title() . '</a></p>';
		}
		return $content;
	}
	
	add_filter('get_avatar', 'MBT_duoshuo_get_avatar', 10, 3);
	function MBT_duoshuo_get_avatar($avatar) {
		$avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "gravatar.duoshuo.com", $avatar);
		return $avatar;
	}
	
	function MBT_get_the_avatar($user_email = '', $size = 50) {
		$avatar = get_avatar($user_email, $size);
		return $avatar;
	}
	

?>