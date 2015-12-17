<?php 
	if($u=='article'&&$n==''&&is_user_logged_in()&&$curauth->ID == $current_user->ID){
		include_once("indexArticle.php");
	}elseif($u=='article'&&$n=='audit'&&is_user_logged_in()&&$curauth->ID == $current_user->ID){
		include_once("indexArticleAudit.php");
	}elseif($u=='article'&&$n=='ask'&&is_user_logged_in()&&$curauth->ID == $current_user->ID){
		include_once("indexArticleAsk.php");
	}elseif($u=='comment'&&is_user_logged_in()&&$curauth->ID == $current_user->ID){
		include_once("indexComment.php");
	}elseif($u=='setting'&&$n==''&&is_user_logged_in()&&$curauth->ID == $current_user->ID){
		include_once("indexSetting.php");
	}elseif($u=='setting'&&$n=='password'&&is_user_logged_in()&&$curauth->ID == $current_user->ID){
		include_once("indexSettingPassword.php");
	}elseif($u=='setting'&&$n=='avatar'&&is_user_logged_in()&&$curauth->ID == $current_user->ID){
		include_once("indexSettingAvatar.php");
	}elseif($u=='contribute'&&$n==''&&is_user_logged_in()&&$curauth->ID == $current_user->ID){
		include_once("indexContribute.php");
	}elseif($u=='contribute'&&$n=='ask'&&is_user_logged_in()&&$curauth->ID == $current_user->ID){
		include_once("indexContributeAsk.php");
	}
?>