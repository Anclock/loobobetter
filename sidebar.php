<aside class="sidebar">
    <?php 
	if(is_page()){
		if (function_exists('dynamic_sidebar') && dynamic_sidebar('page_sidebar')) : endif; 
	}else{
		if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar')) : endif; 
	}
	?>
</aside>