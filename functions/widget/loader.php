<?php  
/*
powered by Mobantu.com
*/
include('mbt-widget-banner.php');
include('mbt-widget-post.php');
include('mbt-widget-comment.php');
include('mbt-widget-tags.php');

add_action('widgets_init','unregister_mbt_widget');
function unregister_mbt_widget(){
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Nav_Menu_Widget');
}

?>