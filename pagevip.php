<?php
/*
Template Name: VIP页面
*/
get_header();?>
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
<div id="main">
	<section class="container" style="margin-top:20px;margin-bottom:20px;">
					<?php if(isset($msg)){?>
						<?php echo $msg;?>
					<?php }else{?>
						
					<?php };?>
					<form method="post" id="formLogin" class="sign-formvip">
					    <h1>VIP服务</h1>
						<h1 class="item">
						    <label><?php 
							$ciphp_year_price    = get_option('ciphp_year_price');
							$ciphp_quarter_price = get_option('ciphp_quarter_price');
							$ciphp_month_price  = get_option('ciphp_month_price');
							
                            $userTypeId=getUsreMemberType();
                            if($userTypeId==7)
                            {
                                echo "您目前是包月会员";
                            }
                            elseif ($userTypeId==8)
                            {
                                echo "您目前是包季会员";
                            }
                            elseif ($userTypeId==9)
                            {
                                echo "您目前是包年会员";
                            }
                            else 
                            {
                                echo '您未购买任何VIP服务';
                            }
                            ?>&nbsp;&nbsp;&nbsp;<?php echo $userTypeId>0 ?'到期时间：'.getUsreMemberTypeEndTime() :''?>
							</label>
						</h1>
						<div class="item">
						    <label><input type="radio" id="userType" name="userType" value="9" checked/>年费会员（￥<?php echo $ciphp_year_price?>）&nbsp;<input type="radio" id="userType" name="userType" value="8" />包季会员（￥<?php echo $ciphp_quarter_price?>）&nbsp;<input type="radio" id="userType" name="userType" value="7" />包月会员（￥<?php echo $ciphp_month_price?>）</label>
						</div>
						<div class="sign-submit">
							<input type="submit" name="Submit" value="升级VIP" style="margin-top:20px;" class="btn btn-primary btn-block signsubmit-loader" onClick="return confirm('确认升级成为VIP?');"/>
						</div>
						<h1 class="item">
						    <label>可用余额:<?php echo sprintf("%.2f",$okMoney)?><?php echo get_option(ice_name_alipay)?></label>
						</h1>
						<div class="sign-submit">
							<a href="/alipay" class="btn btn-primary">充值</a>
						</div>
					</form>		
					</div>
				</section>
				</div>
<?php get_footer(); ?>
