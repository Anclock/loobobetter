<?php
/*
by loobo.me
*/ 
$themename = "Mona";
$themefolder = "mona";
define ('theme_name', $themename );
define ('theme_ver' , 1.0);
define( 'MTHEME_NOTIFIER_THEME_FOLDER_NAME', $themefolder );
define( 'MTHEME_NOTIFIER_CACHE_INTERVAL', 1 );
include (TEMPLATEPATH . '/functions/MBT.php');
include (TEMPLATEPATH . '/functions/widget/loader.php');
// WordPress 3.8测试有效
function keep_id_continuous(){
  global $wpdb;
  // 删掉自动草稿和修订版
  $wpdb->query("DELETE FROM `$wpdb->posts` WHERE `post_status` = 'auto-draft' OR `post_type` = 'revision'");
  // 自增值小于现有最大ID，MySQL会自动设置正确的自增值
  $wpdb->query("ALTER TABLE `$wpdb->posts` AUTO_INCREMENT = 1");  
}
add_filter( 'load-post-new.php', 'keep_id_continuous' );
add_filter( 'load-media-new.php', 'keep_id_continuous' );
add_filter( 'load-nav-menus.php', 'keep_id_continuous' );
//禁用谷歌字体
    function remove_open_sans() {
        wp_deregister_style( 'open-sans' );
        wp_register_style( 'open-sans', false );
        wp_enqueue_style('open-sans','');
    }
    add_action( 'init', 'remove_open_sans' );
    //取消工具栏
		add_filter( 'show_admin_bar', '__return_false' );	
  
    /*自定义登出之后的重定向链接
    */
    add_action('wp_logout','auto_redirect_after_logout');   
    function auto_redirect_after_logout(){   
      wp_redirect( home_url() );   
      exit();   
    }  
	
    /*  
    *自定义登陆之后的重定向链接
    */  
    function soi_login_redirect($redirect_to, $request, $user)   
    {   
        return (is_array($user->roles) && in_array('administrator', $user->roles)) ? admin_url() : site_url();   
    }    
    add_filter('login_redirect', 'soi_login_redirect', 10, 3);  
	
	    /**

     * 重置非管理员用户到首页

     */

    function redirect_non_admin_users() {

    	if ( ! current_user_can( 'edit_others_posts' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {

    		wp_redirect( home_url() );

    		exit;

    	}
    }
    add_action( 'admin_init', 'redirect_non_admin_users' );
	//wp-login.php做跳转
	function redirect_logged_user() {
  if(is_user_logged_in() && (empty($_GET['action']) || $_GET['action'] == 'login'|| $_GET['action'] == 'register')) {
		wp_redirect( home_url() );
    exit;
  }elseif(empty($_GET['action']) || $_GET['action'] == 'login'|| $_GET['action'] == 'register'){
	  wp_redirect( home_url().'/login' );
    exit;
  }
}
add_action( 'login_init', 'redirect_logged_user' );


/////////
function email_address_login($username) {
$user = get_user_by_email($username);
if(!empty($user->user_login))
$username = $user->user_login;
return $username;
}
add_action('wp_authenticate','email_address_login');

///////////////
function artCatalog($atts,$content=null)
{		
    return '<h3 class="bookCatalogTitle" id="catalog">'.get_the_title().' - 目录预览</h3>';
}
add_shortcode('artCatalog',artCatalog);
function artDownload($atts,$content=null)
{		
    return '<h3 class="bookCatalogTitle" id="download">'.get_the_title().' - 下载链接</h3>';
}
add_shortcode('artDownload',artDownload);
function divNoneStart($atts,$content=null)
{
    return '<div class="bookCatalog" style="display: none;">';
}
add_shortcode('divNoneStart',divNoneStart);
function divNoneEnd($atts,$content=null)
{
    return '</div>';
}
add_shortcode('divNoneEnd',divNoneEnd);
function downloadLink($atts,$content=null){
	extract(shortcode_atts(array('url'=>'0'), $atts));
	return '<a class="downloadLink" target="_blank" href="'.$url.'">'.$content.'</a>';
}
add_shortcode('downloadLink',downloadLink);
function linkPage($atts,$content=null){
	extract(shortcode_atts(array('url'=>'0'), $atts));
	return '<a class="linkPage" href="'.$url.'" title="" target="_blank" ><img src="'.$url.'/favicon.ico" onerror="javascript:this.src=\'/favicon.ico\'" /><span>'.$content.'</span></a>';
}
add_shortcode('linkPage',linkPage);


//获取第一张图片
function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];
 
  if(empty($first_img)){ //Defines a default image
    $first_img = "/wp-content/themes/H5/images/default.jpg";
  }
  return $first_img;
}

//根据作者ID获取该作者的文章数量
 function num_of_author_posts($authorID=''){ //根据作者ID获取该作者的文章数量
     if ($authorID) {
         $author_query = new WP_Query( 'posts_per_page=-1&author='.$authorID );
         $i=0;
         while ($author_query->have_posts()) : $author_query->the_post(); ++$i; endwhile; wp_reset_postdata();
         return $i;
     }
     return false;
 }
 function mun_of_author_comment($authorID=''){
	 if ($authorID) {
	$args = array(
    'user_id' => $authorID, // use user_id
        'count' => true //return only the count
	 );
	 $comments = get_comments($args);
	 return $comments;
	 }
     return false;
 }
if ( !is_admin() )
{
    function add_scripts() {
        wp_deregister_script( 'jquery' ); 
        wp_register_script( 'jquery', 'http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js'); 
        wp_enqueue_script( 'jquery' ); 
    } 
  
    add_action('wp_enqueue_scripts', 'add_scripts');
}
/**
 *Load Scripts and Styles 
 */
function janezen_scripts_styles() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'janezen_scripts_styles' );


/**
 *文章点击次数
 */
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count.' ';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/*
*面包屑
*/
    function get_breadcrumbs()
    {
    global $wp_query;

    if ( !is_home() ){

    // Start the UL
    echo '<div id="crumbs"><ul class="breadcrumbs">';
	echo '<li>当前位置：</li>';
    // Add the Home link
    echo '<li><a href="'. get_settings('home') .'">运营笔记</a> &raquo; </li>';

    if ( is_category() )
    {
    $catTitle = single_cat_title( "", false );
    $cat = get_cat_ID( $catTitle );
    echo "<li>". get_category_parents( $cat, FALSE, FALSE ) ."</li>";
	
    }
    elseif ( is_author() && !is_category() )
    {
     echo '<li>"'.wp_title('','', FALSE) .'"的个人主页</li>';
    }
    elseif ( is_search() ) {

    echo "<li>Search Results</li>";
    }
    elseif ( is_404() )
    {
    echo "<li>404 Not Found</li>";
    }
    elseif ( is_single() )
    {
    $category = get_the_category();
    $category_id = get_cat_ID( $category[0]->cat_name );

    echo '<li>'. get_category_parents( $category_id, TRUE, " &raquo; " );
    echo '<li>'.the_title('','', FALSE) ."</li>";
    }
    elseif ( is_page() )
    {
    $post = $wp_query->get_queried_object();

    if ( $post->post_parent == 0 ){

    echo "<li>".the_title('','', FALSE)."</li>";

    } else {
    $title = the_title('','', FALSE);
    $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
    array_push($ancestors, $post->ID);

    foreach ( $ancestors as $ancestor ){
    if( $ancestor != end($ancestors) ){
    echo '<li><a href="'. get_permalink($ancestor) .'">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</a> &raquo; </li>';
    } else {
    echo '<li>'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</li>';
    }
    }
    }
    }

    // End the UL
    echo "</ul></div>";
    }
    }
//
/**
* WordPress集成Auto-highslide图片灯箱（按需加载&无需插件）
*/
add_filter('the_content', 'addhighslideclass_replace');
function addhighslideclass_replace ($content)
{   global $post;
 $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
    $replacement = '<a$1href=$2$3.$4$5 class="highslide-image" onclick="return hs.expand(this);"$6>$7</a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
//评论添加验证码
   /* 评论必须有中文和禁止某些字段出现 */    
   function lianyue_comment_post( $incoming_comment ) {    
   $pattern = '/[一-龥]/u';    
   $http = '/[<|=|.|友|夜|KTV|ッ|の|ン|優|業|グ|貿|]/u';  
    // 禁止全英文评论  
   if(!preg_match($pattern, $incoming_comment['comment_content'])) {  
  wp_die( "您的评论中必须包含汉字，否则将被视为发贴机!" );  
  }elseif(preg_match($http, $incoming_comment['comment_content'])) {  
  wp_die( "万恶的发贴机，这里不允许放链接，如需交换链接请联系站长!" );    
  }    
   return( $incoming_comment );    
  }    
  add_filter('preprocess_comment', 'lianyue_comment_post');   
/*get avatar

add_filter( 'get_avatar' , 'my_custom_avatar' , 1 , 5 );
function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt) {
	$user_id  = (int) $id_or_email;
    $file = "/upload/".md5($user_id).".jpg";
	if(file_exists($file))
{  
		$avatar = "/upload/".md5($user_id).".jpg";
    }else{
		$avatar = "http://www.ccoooo.com/wp-content/themes/focustime/images/avatar.jpg";
       
    }
    $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

    return $avatar;
}
*/
add_filter( 'get_avatar' , 'my_custom_avatar' , 1 , 5 );
function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt) {
	$user_id  = (int) $id_or_email;
    $file ="/wp-content/uploads/avatars/".md5($user_id).".jpg";
	
    return '<img src="'.$file.'" onerror="javascript:this.src=\'/wp-content/uploads/avatars/avatar.jpg\'"  height='.$size.' width='.$size.' class="avatar"/>';
}

//function get_ssl_avatar($avatar) {
//	$avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="http://www.janezen.com/wp-content/themes/coo/images/avatar.jpg" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
//	return $avatar;
//}
//	add_filter('get_avatar', 'get_ssl_avatar');

//去除分类标志代码
    add_action( 'load-themes.php',  'no_category_base_refresh_rules');
    add_action('created_category', 'no_category_base_refresh_rules');
    add_action('edited_category', 'no_category_base_refresh_rules');
    add_action('delete_category', 'no_category_base_refresh_rules');
    function no_category_base_refresh_rules() {
        global $wp_rewrite;
        $wp_rewrite -> flush_rules();
    }
    // register_deactivation_hook(__FILE__, 'no_category_base_deactivate');
    // function no_category_base_deactivate() {
    //  remove_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    //  // We don't want to insert our custom rules again
    //  no_category_base_refresh_rules();
    // }
    // Remove category base
    add_action('init', 'no_category_base_permastruct');
    function no_category_base_permastruct() {
        global $wp_rewrite, $wp_version;
        if (version_compare($wp_version, '3.4', '<')) {
            // For pre-3.4 support
            $wp_rewrite -> extra_permastructs['category'][0] = '%category%';
        } else {
            $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
        }
    }
    // Add our custom category rewrite rules
    add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    function no_category_base_rewrite_rules($category_rewrite) {
        //var_dump($category_rewrite); // For Debugging
        $category_rewrite = array();
        $categories = get_categories(array('hide_empty' => false));
        foreach ($categories as $category) {
            $category_nicename = $category -> slug;
            if ($category -> parent == $category -> cat_ID)// recursive recursion
                $category -> parent = 0;
            elseif ($category -> parent != 0)
                $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
            $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
			$category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
        }
        // Redirect support from Old Category Base
        global $wp_rewrite;
        $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
        $old_category_base = trim($old_category_base, '/');
        $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
        //var_dump($category_rewrite); // For Debugging
		return $category_rewrite;
    }
    // Add 'category_redirect' query variable
    add_filter('query_vars', 'no_category_base_query_vars');
    function no_category_base_query_vars($public_query_vars) {
        $public_query_vars[] = 'category_redirect';
        return $public_query_vars;
    }
    // Redirect if 'category_redirect' is set
    add_filter('request', 'no_category_base_request');
    function no_category_base_request($query_vars) {
        //print_r($query_vars); // For Debugging
        if (isset($query_vars['category_redirect'])) {
            $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
			status_header(301);
            header("Location: $catlink");
            exit();
        }
        return $query_vars;
    }
add_filter('user_contactmethods', 'my_user_contactmethods');

function my_user_contactmethods($user_contactmethods){
  $user_contactmethods['user_qq'] = 'QQ帐号';
  $user_contactmethods['user_weibo'] = '新浪微博';
  return $user_contactmethods;
}	
	
     /*
    *给评论作者的链接新窗口打开
    */
    //function yundanran_get_comment_author_link($url)
   // {
  ///  $return=$url;
  ///  $p1="/^<a .*/i";
  ///  $p2="/^<a ([^>]*)>(.*)/i";
  //  if(preg_match($p1,$return))
  //  {
   /// $return=preg_replace($p2,"<a $1 target='_blank'>$2",$return);
   /// }
  //  return $return;
  //  }
  //  add_filter('get_comment_author_link','yundanran_get_comment_author_link');


if ( ! function_exists( 'janezen_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own janezen_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function janezen_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'janezen' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'janezen' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-meta comment-author vcard">
				
				<?php
				if($comment->user_id!=0){
					$author_posts_url=get_author_posts_url($comment->user_id);
					$author_posts_url='<a style="background: #cecece none repeat scroll 0 0;border-radius: 3px;padding:0 2px;" target=\'_blank\' href="'.$author_posts_url.'">';
				}else{
					$author_posts_url='<a>';
				}
					echo get_avatar( $comment->user_id, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						$author_posts_url.get_comment_author( $commentdata['comment_parent'] ).'</a>',
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( '本文作者', 'janezen' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'janezen' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'janezen' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'janezen' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '回复', 'janezen' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;
	
	
	/*
	*
	评论添加@，by Ludou
	*/
function ludou_comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }

  return $comment_text;
}
add_filter( 'comment_text' , 'ludou_comment_add_at', 20, 2);


/* comment_mail_notify v1.0 by janezen. (所有回复都发邮件) */



//smtp
add_action('phpmailer_init', 'mail_smtp');
function mail_smtp( $phpmailer ) {
$phpmailer->FromName = '运营笔记(系统)'; //发信人名称
$phpmailer->Host = 'smtp.exmail.qq.com'; //smtp服务器
$phpmailer->Port = 465;  //端口
$phpmailer->Username = 'service@xxxxx.com';//邮箱帐号  
$phpmailer->Password = 'xxxxxx';//邮箱密码
$phpmailer->From = 'service@xxxxxxx.com'; //邮箱帐号
$phpmailer->SMTPAuth = true;  
$phpmailer->SMTPSecure = 'ssl'; //tls or ssl （port=25留空，465为ssl）
$phpmailer->IsSMTP();
}
//评论回复邮件
function comment_mail_notify($comment_id){
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $spam_confirmed = $comment->comment_approved;
    if(($parent_id != '') && ($spam_confirmed != 'spam')){
    $wp_email = 'webmaster@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '你在 [' . get_option("blogname") . '] 的留言有了回应';
    $message = '
    <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-style: solid; border-width: 1;" bordercolor="#85C1DF" width="700" height="251" id="AutoNumber1" align="center">
          <tr>
            <td width="520" height="28" bgcolor="#F5F9FB"><font color="#1A65B6" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<b>留言回复通知 | <a href="http://www.ccoooo.com" targe="blank">运营笔记(www.ccoooo.com)</a></b></font></td>
          </tr>
          <tr>
            <td width="800" height="210" bgcolor="#FFffff" valign="top" style=" padding:8px;">&nbsp;&nbsp;<span class="STYLE2"><strong >' . trim(get_comment($parent_id)->comment_author) . '</strong>, 你好!</span>
              <p>&nbsp;&nbsp;<span class="STYLE2">你曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />&nbsp;&nbsp;--->'
        . trim(get_comment($parent_id)->comment_content) . '<br /><br />
              &nbsp;&nbsp; ' . trim($comment->comment_author) . ' 给你的回复:<br />&nbsp;&nbsp;--->'
        . trim($comment->comment_content) . '</span></p>
        <p > &nbsp;&nbsp;<Strong>你可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回复完整内容</a></Strong></p>
              <p><span class="STYLE2"> &nbsp;&nbsp;<strong>感谢你对 <a href="' . get_option('home') . '" target="_blank">' . get_option('blogname') . '</a> 的关注！</p>
            </td>
          </tr>
          <tr>
            <td width="800" height="16" bgcolor="#85C1DF" bordercolor="#008000"><div align="center"><font color="#fff"><a href="http://www.ccoooo.com">运营笔记(www.ccoooo.com)</a></font></div></td>
          </tr>
  </table>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
  }
}
add_action('comment_post', 'comment_mail_notify');
 // 自定义菜单
    register_nav_menus(
    array(
    'header-menu' => __( '导航自定义菜单' ),
    )
    ); 
	
//更改作者前缀 
add_action('init', 'change_author_base');
function change_author_base() {
global $wp_rewrite;
$author_slug = 'u'; // 这里是作者路径前缀
$wp_rewrite->author_base = $author_slug;
}
//点赞
    add_action('wp_ajax_nopriv_specs_zan', 'specs_zan');
    add_action('wp_ajax_specs_zan', 'specs_zan');
    function specs_zan(){
        global $wpdb,$post;
        $id = $_POST["um_id"];
        $action = $_POST["um_action"];
        if ( $action == 'ding'){
            $specs_raters = get_post_meta($id,'specs_zan',true);
            $expire = time() + 99999999;
            $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
            setcookie('specs_zan_'.$id,$id,$expire,'/',$domain,false);
            if (!$specs_raters || !is_numeric($specs_raters)) {
                update_post_meta($id, 'specs_zan', 1);
            } 
            else {
                update_post_meta($id, 'specs_zan', ($specs_raters + 1));
            }
            echo get_post_meta($id,'specs_zan',true);
        } 
        die;
    }

// 注册公告文章类型
function create_bulletin_post_type() {
    register_post_type( 'bulletin',
        array(
            'labels' => array(
                'name' => _x( '公告', 'taxonomy general name' ),
                'singular_name' => _x( '公告', 'taxonomy singular name' ),
                'add_new' => __( '添加公告', 'um' ),
                'add_new_item' => __( '添加新公告', 'um' ),
                'edit' => __( '编辑', 'um' ),
                'edit_item' => __( '编辑公告', 'um' ),
                'new_item' => __( '新公告', 'um' ),
                'view' => __( '浏览', 'um' ),
				'all_items' => __( '所有公告', 'um' ),
                'view_item' => __( '浏览公告', 'um' ),
                'search_items' => __( '搜索公告', 'um' ),
                'not_found' => __( '未找到公告', 'um' ),
                'not_found_in_trash' => __( '回收站未找到公告', 'um' ),
                'parent' => __( '父级公告', 'um' ),
				'menu_name' => __( '站点公告', 'um' ),
            ),
 
            'public' => true,
            'menu_position' => 19,
            'supports' => array( 'title', 'author', 'editor', 'comments', 'excerpt', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'menu_icon' => 'dashicons-info',
            'has_archive' => false,
			'rewrite'	=> array('slug'=>'bulletin')
        )
    );
}
add_action( 'init', 'create_bulletin_post_type' );

//微博登录
function do_post($url, $data) {
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt ( $ch, CURLOPT_POST, TRUE );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $ret = curl_exec ( $ch );
    curl_close ( $ch );
    return $ret;
}
function get_url_contents($url) {
    if (ini_get ( "allow_url_fopen" ) == "1")
        return file_get_contents ( $url );
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    $result = curl_exec ( $ch );
    curl_close ( $ch );
    return $result;
}
add_action( 'init', 'signup_social' );
function signup_social(){

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
       
        if (isset($_GET['code']) && isset($_GET['type']) && $_GET['type'] == 'sina')
        {
            $code = $_GET['code'];
            $url = "https://api.weibo.com/oauth2/access_token";
            $data = "client_id=your_sina_appkey&4221439169_client_secret=sina_client_secret&4211a1b7d19c1f33c568368dc9927d18_type=authorization_code&redirect_uri=".urlencode (home_url())."&code=".$code;//替换成你自己的appkey和appsecret
            $output = json_decode(do_post($url,$data));
            $sina_access_token = $output->access_token;
            $sina_uid = $output->uid;
            if(empty($sina_uid)){
                wp_redirect(home_url('/?3'));//获取失败的时候直接返回首页
                exit;
            }
            if(is_user_logged_in()){
            
            $this_user = wp_get_current_user();
            update_user_meta($this_user->ID ,"sina_uid",$sina_uid);
            update_user_meta($this_user->ID ,"sina_access_token",$sina_access_token);
            wp_redirect(home_url('/me/setting?4'));//已登录用户授权
            }else{
            $user_fb = get_users(array("meta_key "=>"sina_uid","meta_value"=>$sina_uid));
            if(is_wp_error($user_fb) || !count($user_fb)){
                $get_user_info = "https://api.weibo.com/2/users/show.json?uid=".$sina_uid."&access_token=".$sina_access_token;
                $data = get_url_contents ( $get_user_info );
                $str  = json_decode($data , true);
                $username = $str['screen_name'];
                $login_name = wp_create_nonce($sina_uid);
                $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
                $userdata=array(
                    'user_login' => $login_name,
                    'display_name' => $username,
                    'user_pass' => $random_password,
                    'nick_name' => $username
                );
                $user_id = wp_insert_user( $userdata );
                wp_signon(array("user_login"=>$login_name,"user_password"=>$random_password),false);
                update_user_meta($user_id ,"sina_uid",$sina_uid);
                update_user_meta($user_id ,"sina_access_token",$sina_access_token);
                wp_redirect(home_url('/?1'));//创建帐号成功

            }else{
                update_user_meta($user_fb[0]->ID ,"sina_access_token",$sina_access_token);
                wp_set_auth_cookie($user_fb[0]->ID);
                
                wp_redirect(home_url('/?2'));//已绑定，直接登录。
            }
            }
        }
    }

}
function sina_login(){

    return  "https://api.weibo.com/oauth2/authorize?client_id=4221439169&response_type=code&redirect_uri=" . urlencode (home_url('/?type=sina'));//替换成你的appkey

}

/* 部分内容输入密码可见（短代码）*/
function e_secret($atts, $content=null){
    extract(shortcode_atts(array('key'=>null), $atts));
    if(isset($_POST['e_secret_key']) && $_POST['e_secret_key']==$key){
        return '
<div class="e-secret">'.$content.'</div>
';
    }
    else{
        return '
<form class="e-secret" action="'.get_permalink().'" method="post" name="e-secret"><label>输入密码查看加密内容：</label>
<input type="password" name="e_secret_key" class="euc-y-i" maxlength="50"><input type="submit" class="euc-y-s" value="确定">
<div class="euc-clear"></div>
</form>
';
    }
}
add_shortcode('secret','e_secret');
//文章内容回复可见

function reply_to_read($atts, $content=null) {

extract(shortcode_atts(array("notice" => '<center><p class="reply-to-read"><b><span style="color: #ff0000;"><特别提醒：因内容只分享给有品位的人，待您</span></b><a href="#respond" title="回复本文"><b>回复本文</b></a><b><span style="color: #ff0000;">后刷新即可查看，请谅解！>　　</span></b></p><center>'), $atts));

$email = null;

$user_ID = (int) wp_get_current_user()->ID;

if ($user_ID > 0) {

$email = get_userdata($user_ID)->user_email;

//对博主直接显示内容

$admin_email = "loobome@qq.com"; //<span style="color: #0000ff;">管理员Email</span>

if ($email == $admin_email) {

return $content;

}

} else if (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) {

$email = str_replace('%40', '@', $_COOKIE['comment_author_email_' . COOKIEHASH]);

} else {

return $notice;

}

if (empty($email)) {

return $notice;

}

global $wpdb;

$post_id = get_the_ID();

$query = "SELECT `comment_ID` FROM {$wpdb->comments} WHERE `comment_post_ID`={$post_id} and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";

if ($wpdb->get_results($query)) {

return do_shortcode($content);

} else {

return $notice;

}

}

add_shortcode('reply', 'reply_to_read');
//**登录可见**//
add_shortcode('hide','loginvisible');
function loginvisible($atts,$content=null){
	if(is_user_logged_in() && !is_null($content) && !is_feed())
	return $content;
	return '';
}

?>