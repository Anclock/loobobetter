<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<link rel="shortcut icon" href="<?php bloginfo('template_url')?>/static/img/favicon.ico">
<link href="<?php bloginfo('template_directory'); ?>/static/css/font-awesome.css" rel="stylesheet">
<title><?php wp_title( '-', true, 'right' ); ?></title>
<?php MBT_keywords();MBT_description();wp_head();?>
<!--[if lt IE 9]><script src="http://apps.bdimg.com/libs/html5shiv/r29/html5.min.js"></script><![endif]-->
</head>
<body <?php body_class()?>>
<header class="header">
  <div class="container">
    <div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><img src="<?php bloginfo('template_url')?>/static/img/logo.png"></a></div>
    <ul class="site-nav site-navbar">
      <?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'main', 'echo' => false)) )); ?>
	  <li class="navto-search"><a href="javascript:;" class="search-show active"><i class="fa">&#xe604;</i></a></li>
    </ul>
     </div>
</header>
<div class="site-search">
  <div class="container">
    <form method="get" class="site-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
      <input class="search-input" name="s" type="text" placeholder="输入关键字搜索">
      <button class="search-btn" type="submit"><i class="fa">&#xe604;</i></button>
    </form>
  </div>
</div>
