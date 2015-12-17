<?php
$current_user = wp_get_current_user();
if(isset($_GET['u'])) :
$u=$_GET['u'];
else :
$u='';
endif;
if(isset($_GET['n'])) :
$n=$_GET['n'];
else :
$n='';
endif;

include_once("u/functions.php");

if(isset($_GET['author_name'])) :
$curauth = get_userdatabylogin($author_name);
else :
$curauth = get_userdata(intval($author));
endif;
?>

<?php get_header(); ?>
<div class="userfocusbanner">
	<div class="container">	
		<h2 style="font-size:30px;text-align:center;">会员中心</h2>
	</div>
</div>
<section class="container" id="jaxcontainer">

	<div class="content-wrap">
		<div class="content" id="contentframe">
			
	<?php if(($u=='article'&&$n==''&&is_user_logged_in()&&$curauth->ID == $current_user->ID)||
	($u=='article'&&$n=='audit'&&is_user_logged_in()&&$curauth->ID == $current_user->ID)||
	($u=='article'&&$n=='ask'&&is_user_logged_in()&&$curauth->ID == $current_user->ID)||
	($u=='comment'&&is_user_logged_in()&&$curauth->ID == $current_user->ID)||
	($u=='setting'&&$n==''&&is_user_logged_in()&&$curauth->ID == $current_user->ID)||
	($u=='setting'&&$n=='password'&&is_user_logged_in()&&$curauth->ID == $current_user->ID)||
	($u=='setting'&&$n=='avatar'&&is_user_logged_in()&&$curauth->ID == $current_user->ID)||
	($u=='contribute'&&$n==''&&is_user_logged_in()&&$curauth->ID == $current_user->ID)||
	($u=='contribute'&&$n=='ask'&&is_user_logged_in()&&$curauth->ID == $current_user->ID)){?>
		<?php include_once("u/index.php"); ?>
		<?php }else{?>
    <div class="profile-right">
        <div class="dashboard-main">
            <div class="grid">
        <?php if ( have_posts() ) : ?>
            <ul>
        <?php while(have_posts()) : the_post(); ?>
                <li class="group">
                    <div class="item">
                        <div class="thumb">
                             <a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <img width="240" height="180" src="<?php echo catch_that_image() ?>" class="attachment-medium wp-post-image" alt="<?php the_title(); ?>" /></a>
                        </div>
                        <div class="meta">
                            <div class="extra"> <?php the_title(); ?><span></span></div>
                        </div>
                    </div>
	            </li>
	<?php endwhile;?>  
            </ul>
    <?php
    endif;
    ?>
    <?php
$pagination = paginate_links( array(
	'base' => add_query_arg( 'pagenum', '%#%' ),
	'format' => '',
	'prev_text' => '上一页',
	'next_text' => '下一页',
	'total' => $dashboard_query->max_num_pages,
	'current' => $pagenum
	)
);
if ( $pagination ) {
	echo $pagination;
}
?>  
	         </div>
        </div>
    </div>
	<?php } ?>
		</div>
	</div>
  </div>
</div>
	<aside class="sidebar">
		<div class="usermenus">	
			<ul class="usermenu">
				<li><a href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>">我的文章</a></li>
				<li><a href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=contribute">发表文章</a></li>
				<li><a href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=setting">修改资料</a></li>
				<li><a href="<?php bloginfo('url'); ?>/u/<?php echo $current_user->user_login;?>?u=setting&n=password">修改密码</a></li>
			</ul>
			<ul class="usermenu">
				<li><a href="#" onclick="javascript:alert('亲！功能正在开发哟^-^')">我的工单</a></li>
				<li><a href="#" onclick="javascript:alert('都告诉你了正在开发中，怎么不听话呢？')">提交新工单</a></li>
			</ul>
			<ul class="usermenu">
				<li><a href="<?php echo wp_logout_url( get_permalink() ); ?>">注销</a></li>
			</ul>
		</div>
	</aside>

</section>

<?php get_footer(); ?>
	