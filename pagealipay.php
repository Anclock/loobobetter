<?php
/*
Template Name: 充值页面
*/
get_header();?>
<?php

if(!is_user_logged_in())
{
	echo "<script>window.location.href='".wp_login_url()."';</script>";
}
 get_header(); 
 ?>
<link rel='stylesheet' id='style-css'  href="<?php echo get_template_directory_uri().'/css/profile.css' ?>" type='text/css' media='all' />

<?php 
if($_POST)
{
	if($_POST['paytype'])
	{
		$paytype=intval($_POST['paytype']);
		if(isset($_POST['paytype']) && $paytype==5)
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/alipay_scow.php?ice_money=".$_POST['ice_money'];
		}
		elseif(isset($_POST['paytype']) && $paytype==4)
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/alipay_fun.php?ice_money=".$_POST['ice_money'];
		}
		elseif(isset($_POST['paytype']) && $paytype==3)
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/chinabank.php?ice_money=".$_POST['ice_money'];
		}
		elseif(isset($_POST['paytype']) && $paytype==1)
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/chong.php?ice_money=".$_POST['ice_money'];
		}
		else
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/paypal.php?ice_money=".$_POST['ice_money'];
		}
		echo "<script>location.href='".$url."'</script>";
		exit;
	}
	if($_POST['userType'])
	{
		$userType=isset($_POST['userType']) && is_numeric($_POST['userType']) ?intval($_POST['userType']) :0;
		if($userType >6 && $userType < 10)
		{
			$okMoney=erphpGetUserOkMoney();
			$priceArr=array('7'=>'ciphp_month_price','8'=>'ciphp_quarter_price','9'=>'ciphp_year_price');
			$priceType=$priceArr[$userType];
			$price=get_option($priceType);
			if(empty($price) || $price<1)
			{
				echo "<script>alert('此类型的会员价格错误，请稍候重试！');</script>";
			}
			elseif($okMoney < $price)
			{
				echo "<script>alert('当前可用余额不足完成此次交易！');</script>";
			}
			elseif($okMoney >=$price)
			{
				if(erphpSetUserMoneyXiaoFei($price))//扣钱
				{
					if(userPayMemberSetData($userType))
					{
						addVipLog($price, $userType);
						
					}
					else
					{
						echo "<script>alert('系统发生错误，请联系管理员！');</script>";
					}
				}
				else
				{
					echo "<script>alert('系统发生错误，请稍候重试！');</script>";
				}
			}
			else
			{
				echo "<script>alert('未定义的操作！');</script>";
			}
		}
		else
		{
			echo "<script>alert('会员类型错误！');</script>";
		}
	}
	
}
?>
<?php
if ( !defined('ABSPATH') ) {exit;}
if(!is_user_logged_in())
{
	wp_die('请登录系统');
}
?>
<?php 
if($_POST)
{
	$paytype=intval($_POST['paytype']);
	$doo = 1;
	if(isset($_POST['paytype']) && $paytype==5)
	{
		$url=constant("erphpdown")."alipay_scow.php?ice_money=".$_POST['ice_money'];
	}
	elseif(isset($_POST['paytype']) && $paytype==4)
	{
		$url=constant("erphpdown")."alipay_fun.php?ice_money=".$_POST['ice_money'];
	}
	elseif(isset($_POST['paytype']) && $paytype==3)
	{
		$url=constant("erphpdown")."chinabank.php?ice_money=".$_POST['ice_money'];
	}
	elseif(isset($_POST['paytype']) && $paytype==1)
	{
		$url=constant("erphpdown")."chong.php?ice_money=".$_POST['ice_money'];
	}
	elseif(isset($_POST['paytype']) && $paytype==7)
	{
		$url=constant("erphpdown")."mbttenpay.php?ice_money=".$_POST['ice_money'];
	}
	elseif(isset($_POST['paytype']) && $paytype==6)
	{
		$doo = 0;
		$result = checkDoCardResult($_POST['ice_money'],$_POST['password']);
		if($result == '0') echo "此充值卡已被使用，请重新换张！";
		if($result == '4') echo "系统出错，出现问题，请联系管理员！";
		if($result == '1') echo "充值成功！";
	}
	else
	{
		$url=constant("erphpdown")."paypal.php?ice_money=".$_POST['ice_money'];
	}
	if($doo)
	 echo "<script>location.href='".$url."'</script>";
	exit;
}
?>
<div class="wrap">
<script type="text/javascript">
jQuery(document).ready(function() {
	var c = jQuery("input[name='paytype']:checked").val();
	if(c == 6){jQuery("#cpass").css("display","");jQuery("#cname").html("充值卡号");}
	else{jQuery("#cpass").css("display","none");jQuery("#cname").html("充值金额");}
});

function checkFm()
{
	if(document.getElementById("ice_money").value=="")
	{
		alert('请输入金额或卡号');
		return false;
	}
}

function checkCard()
{
	var c = jQuery("input[name='paytype']:checked").val();
	if(c == 6){jQuery("#cpass").css("display","");jQuery("#cname").html("充值卡号");}
	else{jQuery("#cpass").css("display","none");jQuery("#cname").html("充值金额");}
}
</script>
<?php 
//统计数据
$user_info=wp_get_current_user();
$total_trade   = $wpdb->get_var("SELECT COUNT(ice_id) FROM $wpdb->icealipay WHERE ice_success>0 and ice_user_id=".$user_info->ID);
$total_money   = $wpdb->get_var("SELECT SUM(ice_price) FROM $wpdb->icealipay WHERE ice_success>0 and ice_user_id=".$user_info->ID);
//分页计算
$ice_perpage = 8;
$pages = ceil($total_trade / $ice_perpage);
$page=isset($_GET['p']) ?intval($_GET['p']) :1;
$offset = $ice_perpage*($page-1);
$list = $wpdb->get_results("SELECT * FROM $wpdb->icealipay where ice_success=1 and ice_user_id=$user_info->ID order by ice_time DESC limit $offset,$ice_perpage");
?>
<div id="main">
	<section class="container" style="margin-top:20px;margin-bottom:20px;">
<form action="" method="post" target="_blank" onsubmit="return checkFm();"  class="sign-formvip">
        <h2 style="text-align:center;">在线充值</h2>
        <table class="form-table">
		    <h2>充值比例:<font color="#006600">1元 =<?php echo get_option(ice_proportion_alipay) ?><?php echo get_option(ice_name_alipay) ?></font></h2>
        	<h2>充值金额:
			    <input type="text" id="ice_money" name="ice_money" maxlength="50" size="50" class="ipt"/>
			</h2>
            <h2>充值方式
                <td>
                <?php if(plugin_check_card()){?>
                 <input type="radio" id="paytype6" class="paytype" name="paytype" value="6" checked onclick="checkCard()"/>充值卡
                 <?php }?>
                <?php if(get_option('ice_scow_partner')){?>
                <input type="radio" id="paytype5" class="paytype" checked name="paytype" value="5" onclick="checkCard()" />支付宝担保交易(￥人民币)&nbsp;
                <?php }?>
                <?php if(get_option('ice_fun_partner')){?>
                <input type="radio" id="paytype4" class="paytype" checked name="paytype" value="4" onclick="checkCard()" />支付宝(￥人民币)&nbsp;
                <?php }?>
                <?php if(get_option('ice_ali_partner')){?> 
                <input type="radio" id="paytype1" class="paytype" checked name="paytype" value="1" onclick="checkCard()" />支付宝即时到帐(￥人民币)&nbsp;
                <?php }?>
                <?php if(get_option('erphpdown_tenpay_uid')){?> 
                <input type="radio" id="paytype7" class="paytype" name="paytype" value="7" onclick="checkCard()" />财付通(￥人民币)&nbsp;    
                <?php }?> 
                <?php if(get_option('ice_china_bank_uid')){?> 
                <input type="radio" id="paytype3" class="paytype" name="paytype" value="3" onclick="checkCard()"/>银联支付(￥人民币)&nbsp;    
                <?php }?> 
                <?php if(get_option('ice_payapl_api_uid')){?> 
                <input type="radio" id="paytype2" class="paytype" name="paytype" value="2" onclick="checkCard()"/>PayPal($美元)汇率：
                 (<?php echo get_option('ice_payapl_api_rmb')?>)&nbsp;  
                 <?php }?> 
                </td>
            </h2>
    </table>
        <br /> 
        <table> <tr>
        <td><p class="submit">
            <input type="submit" name="Submit" value="充值" class="btn btn-primary" onclick="return confirm('确认充值?');"/>
            </p>
        </td>

        </tr> </table>

</form>
<?php if(get_option('erphpdown_zhuan')){
$user_Info   = wp_get_current_user();
?>
<form action="https://shenghuo.alipay.com/send/payment/fill.htm" method="post" target="_blank" name="myform">
<h2>支付宝转账充值</h2>
<input name="optEmail" type="hidden" value="<?php echo get_option('erphpdown_zhuan')?>">
<input name="memo" type="hidden" value="website username: <?php echo $user_Info->user_login;?>">
    <table class="form-table" >
		<tbody>
		<tr>
			<td class="Usertablerow2" height="25">金额：</td>
			<td class="Usertablerow2">
            <input class="inputbody" size="50" maxlength="50" name="payAmount" id="payAmount"  type="text">元
				
			</td>
		</tr>
		<!-- <tr>
			<td class="Usertablerow1"  height="25">付款说明：</td>
			<td class="Usertablerow1">
				<input class="inputbody" size="50" maxlength="50" name="title" id="title" value="" type="text">
			</td>
		</tr>-->
		<tr>
			<td class="Usertablerow1"  height="25">说明：</td>
			<td class="Usertablerow1">
				转账成功后请联系管理员充值！
			</td>
		</tr>
		<tr>
			<td class="Usertablerow2" align="left"><input class="button-primary" type="submit" name="submit_button" value=" 确 认 ">&nbsp;&nbsp;</td>
		</tr>
    </tbody></table>
</form>
<?php }?>
</div>
</section>
				</div>
<?php get_footer(); ?>
