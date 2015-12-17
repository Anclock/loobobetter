<?php

if(isset($_POST['submit_personal'])){
	if ( is_user_logged_in() ) {
		$art=array(
			  'ID' => $current_user->ID,
			  'nickname'=> strip_tags(trim($_POST["displayName"])),
			  'display_name' => strip_tags(trim($_POST["displayName"])),
			  'user_email' => strip_tags(trim($_POST["userEmail"])),
			  'user_url' => strip_tags(trim($_POST["userUrl"])),
			  'user_qq' => strip_tags(trim($_POST["userQq"])),
			  'user_weibo' => strip_tags(trim($_POST["userWeibo"])),
			  'description' => strip_tags(trim($_POST["description"]))
			  
			);
			$user_id=wp_update_user($art);
		if($user_id){
			$success_msg = '个人信息更新成功！';
			//echo "<script language=\"JavaScript\">alert(\"个人信息更新成功！\");</script>"; 
		}else{
			$success_msg = '个人信息更新失败！';
		}
	}else{
		wp_redirect( home_url() ); exit; 
	}
}
if(isset($_POST['submit_password'])){
	if ( is_user_logged_in() ) {
		if($_POST['password'] == $_POST['password2']){
			$user = wp_authenticate($current_user->user_login, $_POST['passwordOld']);
			if(is_wp_error($user)){
				$success_msg = '原始密码不正确'; 
			}else{
				wp_set_password( $_POST['password'], $current_user->ID );
				$success_msg = '密码修改成功，可能需要您重新登录！'; 
			}
		}else{
				$success_msg = '两次输入的密码不一致！';
		}
	}else{
		wp_redirect( home_url() ); exit; 
	}
}
if(isset($_POST['submit_contribut'])) {
	if ( is_user_logged_in() ) {
    global $wpdb;
    $last_post = $wpdb->get_var("SELECT post_date FROM $wpdb->posts WHERE post_type = 'post' ORDER BY post_date DESC LIMIT 1");
    if ( current_time('timestamp') - strtotime($last_post) < 120 ){
        $success_msg ='您投稿也太勤快了吧，先歇会儿！';
    }
       
    // 表单变量初始化
    $name = isset( $_POST['contributeAuthorName'] ) ? trim(htmlspecialchars($_POST['contributeAuthorName'], ENT_QUOTES)) : '';
    $email =  isset( $_POST['contributeAuthorEmail'] ) ? trim(htmlspecialchars($_POST['contributeAuthorEmail'], ENT_QUOTES)) : '';
    $title =  isset( $_POST['contributeArtTitle'] ) ? trim(htmlspecialchars($_POST['contributeArtTitle'], ENT_QUOTES)) : '';
    $content =  isset( $_POST['contributeArtContent'] ) ? trim($_POST['contributeArtContent']) : '';
	$copy =  isset( $_POST['contributeArtCopy'] ) ? trim(htmlspecialchars($_POST['contributeArtCopy'], ENT_QUOTES)) : '';
    // 表单项数据验证
    if ( !empty($name) && mb_strlen($name) < 20 ) {
        if ( !empty($email) && strlen($email) < 60 || !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
			if ( !empty($title) && mb_strlen($title) < 100 ) {
				if ( !empty($content) && mb_strlen($content) < 3000 && mb_strlen($content) > 100) {
					$post_content = '昵称: '.$name.'<br />Email: '.$email.'<br />copy: '.$copy.'<br />内容:<br />'.$content;
   
					$tougao = array(
						'post_title' => $title,
						'post_content' => $post_content,
						'post_status' => 'pending'
					);
					// 将文章插入数据库
					$status = wp_insert_post( $tougao );
					if ($status != 0) {
						// 投稿成功给博主发送邮件
						// somebody#example.com替换博主邮箱
						// My subject替换为邮件标题，content替换为邮件内容
					    wp_mail("loobo.me@qq.com","My subject","content");

						$success_msg = '投稿成功！感谢投稿！';
						wp_redirect( home_url().'/u/'. $current_user->user_login.'?u=article&n=audit' ); exit; 
					}
					else {
					   $success_msg = '投稿失败！';
					}
				}else{
					$success_msg = '内容必须填写，且长度不得超过3000字，不得少于100字。';
				}
			}else{
				$success_msg = '标题必须填写，且长度不得超过100字。';
			}
		}else{
			$success_msg = 'Email必须填写，且长度不得超过60字，必须符合Email格式。';
		}
    }else{
		$success_msg = '昵称必须填写，且长度不得超过20字。';
	}
	}else{
		wp_redirect( home_url() ); exit; 
	}
}

if(isset($_POST['submit_contributAsk'])) {
	if ( is_user_logged_in() ) {
    global $wpdb;
    $last_post = $wpdb->get_var("SELECT post_date FROM $wpdb->posts WHERE post_type = 'post' ORDER BY post_date DESC LIMIT 1");
    if ( current_time('timestamp') - strtotime($last_post) < 120 ){
        $success_msg ='您投稿也太勤快了吧，先歇会儿！';
    }
       
    // 表单变量初始化
    $title =  isset( $_POST['contributeArtTitle'] ) ? trim(htmlspecialchars($_POST['contributeArtTitle'], ENT_QUOTES)) : '';
    $content =  isset( $_POST['contributeArtContent'] ) ? trim($_POST['contributeArtContent']) : '';
	$tag=isset( $_POST['contributeAsk'] ) ? trim($_POST['contributeAsk']) : '';
    // 表单项数据验证
			if ( !empty($title) && mb_strlen($title) < 100 ) {
				if ( !empty($content) && mb_strlen($content) < 3000 && mb_strlen($content) > 30) {
					$post_content = $content;
					$tougao = array(
						'post_title' => $title,
						'post_content' => $post_content,
						'post_status' => 'publish',
						'tags_input' => $tag,//For tags. 
						'post_category' =>array(103)  
					);
					// 将文章插入数据库
					$status = wp_insert_post( $tougao );
					if ($status != 0) {
						// 投稿成功给博主发送邮件
						// somebody#example.com替换博主邮箱
						// My subject替换为邮件标题，content替换为邮件内容
					    wp_mail("1369919129@qq.com","My subject","content");

						$success_msg = '提问成功！感谢提问！';
						wp_redirect( home_url().'/ask' ); exit; 
					}
					else {
					   $success_msg = '提问失败！';
					}
				}else{
					$success_msg = '内容必须填写，且长度不得超过3000字，不得少于30字。';
				}
			}else{
				$success_msg = '标题必须填写，且长度不得超过100字。';
			}
	}else{
		wp_redirect( home_url() ); exit; 
	}
}


if(isset($_POST['picSubmit'])){
//创建一个数组，用来判断上传来的图片是否合法
$uptypes    = array(
                    'image/jpg',
                    'image/jpeg'
                );
$files     = $_FILES["uppic"];
if($files["size"] > 2097152){
   $success_msg =  "上传图片不能大于2M";
    exit;
}
$ftype    = $files["type"];
if(!in_array($ftype,$uptypes)){
    $success_msg = "上传的图片文件格式不正确";
    exit;
}
$fname    = $files["temp_name"];

$name    = $files["name"];
$str_name    = pathinfo($name);
$extname    = strtolower($str_name["extension"]);
$upload_dir    = "wp-content/uploads/avatars/";
$file_name    =  md5($current_user->ID).".".$extname;
$str_file    = $upload_dir.$file_name;
if(!file_exists($upload_dir)){
    mkdir($upload_dir);
}
if(!move_uploaded_file($files["tmp_name"],$str_file)){
    $success_msg = "图片上传失败";
    exit;
}else{
    $success_msg = "图片上传成功";   
}
//调整上传图片的大小
$width=180; 
$height=180; 
$size=getimagesize($str_file); 
if($size[2]==1)
$im_in=imagecreatefromgif($str_file);  
if($size[2]==2)
$im_in=imagecreatefromjpeg($str_file);  
if($size[2]==3)
$im_in=imagecreatefrompng($str_file); 
$im_out=imagecreatetruecolor($width,$height); 
imagecopyresampled($im_out,$im_in,0,0,0,0,$width,$height,$size[0],$size[1]); 
imagejpeg($im_out,$str_file);
imagedestroy($im_in); 
imagedestroy($im_out);
}
?>