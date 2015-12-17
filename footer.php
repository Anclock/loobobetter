</section>
<footer class="footer">
  <div class="container">
    <p>&copy; 2015 <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
	<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a> 
	<?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?> 由<a target="_blank" href="http://www.loobo.me">loobo.me</a>设计整理 </p>
  </div>
</footer>
<script>
window._bd_share_config={
	"common":{
		"bdSnsKey":{"tsina":""},
		"bdText":"<?php the_title(); ?>",
		"bdMini":"2",
		"bdMiniList":false,
		"bdPic":"",
		"bdStyle":"1",
		"bdSize":"24"
	},
	"share":{
	}
};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>
<script>window.mbt={www: '<?php echo esc_url( home_url( '/' ) ); ?>',uri: '<?php bloginfo('template_url') ?>'};</script>
<?php wp_footer();?>
</body>
</html>