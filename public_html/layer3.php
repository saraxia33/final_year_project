<?php
	require_once("accesscontrol.php");
	//Get data from database here
	if(!$_SESSION['exchange']){
		echo '<script type="text/javascript">alert("Please select a valid exchange!");</script>';
		header("location:layer1.php");	
	}
	if(!$_SESSION['search_one']){
		echo '<script type="text/javascript">alert("Please select at least one valid contract!");</script>';
		header("location:layer2.php");	
	}
	
	$search_one=$_SESSION['search_one'];
		//Load data for the first contract
		if(!array_key_exists($search_one, $_SESSION['contract'])){ 
			$name=mysql_result(mysql_query("select futures_name from Futures_All where futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$delivery_date=mysql_result(mysql_query("select delivery_date from Futures_All where futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$trading_hours_start=mysql_result(mysql_query("select trading_hours_o from Futures_All where futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$trading_hours_end=mysql_result(mysql_query("select trading_hours_c from Futures_All where futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$underlying_base=mysql_result(mysql_query("select underlying_base from Futures_All where futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$tick_size=mysql_result(mysql_query("select Price_Increment from Futures_All where futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$contract_size=mysql_result(mysql_query("select contract_size from Futures_All where futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$margin=mysql_result(mysql_query("select Margin from Futures_All where futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$time=mysql_result(mysql_query("select time_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$open_price=mysql_result(mysql_query("select op_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$high_price=mysql_result(mysql_query("select hp_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$low_price=mysql_result(mysql_query("select lp_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$close_price=mysql_result(mysql_query("select cp_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$volume=mysql_result(mysql_query("select volume_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$expected_return=mysql_result(mysql_query("select expected_return_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$risk_level=mysql_result(mysql_query("select expected_risk_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);
			$accuracy=mysql_result(mysql_query("select accuracy from Futures_All where futures_ID='".$search_one."' and market_ID='".$_SESSION['exchange']."'"),0);

			$_SESSION['contract'][$search_one]=array(
				name=>$name,
				delivery_date=>$delivery_date,
				trading_hours_start=>$trading_hours_start,
				trading_hours_end=>$trading_hours_end,
				underlying_base=>$underlying_base,
				tick_size=>$tick_size,
				contract_size=>$contract_size,
				margin=>$margin,
				time_d=>$time,
				open_price=>$open_price,
				high_price=>$high_price,
				low_price=>$low_price,
				close_price=>$close_price,
				volume=>$volume,
				expected_return=>$expected_return,
				risk_level=>$risk_level,
				accuracy=>$accuracy
			);
		} 
		//Check if contract one be liked
		$temp1=mysql_query("select * from Favorite_Contracts WHERE investor_ID=(select investor_ID from Investor where investor_name='".$_SESSION['username']."') and `market_ID`='".$_SESSION['exchange']."' and futures_ID='".$_SESSION['search_one']."'");
		$row1=mysql_num_rows($temp1);		
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>FuturesV</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="js/jquery.js"></script>
	<link href="js/dragit.css" rel="stylesheet"/>
	<script src="js/d3.js"></script>
	<script src="js/dragit.js"></script>
	<link href="style.css" rel="stylesheet" type="text/css">
	<link href="runningchart.css" rel="stylesheet" type="text/css">
<script>
	$(document).ready(function(){
		$("#contract_one").mouseover(function(){
			$("#info_contract_one").css("display","block");
			$("#contract_one").css("height","45%");
		});
		$("#contract_one").mouseleave(function(){
			$("#info_contract_one").css("display","none");
			$("#contract_one").css("height","13%");	
		});
	});
	
	$(document).ready(function(){
		$("#contract_two").mouseover(function(){
			$("#info_contract_two").css("display","block");
			$("#contract_two").css("height","45%");
		});
		$("#contract_two").mouseleave(function(){
			$("#info_contract_two").css("display","none");
			$("#contract_two").css("height","13%");	
		});
	});	
function like_one(){
	oFormObject = document.forms['hidden_form_like_one'];
	oFormObject.submit();
}
function like_two(){
	oFormObject = document.forms['hidden_form_like_two'];
	oFormObject.submit();
}
function unlike_one(){
	oFormObject = document.forms['hidden_form_unlike_one'];
	oFormObject.submit();
}
function unlike_two(){
	oFormObject = document.forms['hidden_form_unlike_two'];
	oFormObject.submit();
}
</script>
</head> 
<form action="like_one.php" type="post" method="post" id="hidden_form_like_one">
<input type="hidden" name="contract_like" id="contract_like"></input>
</form>
<form action="like_two.php" type="post" method="post" id="hidden_form_like_two">
<input type="hidden" name="contract_like" id="contract_like"></input>
</form>
<form action="unlike_one.php" type="post" method="post" id="hidden_form_unlike_one">
<input type="hidden" name="contract_like" id="contract_like"></input>
</form>
<form action="unlike_two.php" type="post" method="post" id="hidden_form_unlike_two">
<input type="hidden" name="contract_like" id="contract_like"></input>
</form>
<?php
	//Navigation Bar and Tool Bar
	require_once("body_begin.php");
	
	//Check if it get 2 variables
	if($_SESSION['search_one']&&$_SESSION['search_two']){
		
	//Load data for the second contract
			$search_two=$_SESSION['search_two'];
		//Load data for the second contract
		if(!array_key_exists($search_two, $_SESSION['contract'])){ 
			$name=mysql_result(mysql_query("select futures_name from Futures_All where futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$delivery_date=mysql_result(mysql_query("select delivery_date from Futures_All where futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$trading_hours_start=mysql_result(mysql_query("select trading_hours_o from Futures_All where futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$trading_hours_end=mysql_result(mysql_query("select trading_hours_c from Futures_All where futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$underlying_base=mysql_result(mysql_query("select underlying_base from Futures_All where futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$tick_size=mysql_result(mysql_query("select Price_Increment from Futures_All where futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$contract_size=mysql_result(mysql_query("select contract_size from Futures_All where futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$margin=mysql_result(mysql_query("select Margin from Futures_All where futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$time=mysql_result(mysql_query("select time_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$open_price=mysql_result(mysql_query("select op_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$high_price=mysql_result(mysql_query("select hp_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$low_price=mysql_result(mysql_query("select lp_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$close_price=mysql_result(mysql_query("select cp_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$volume=mysql_result(mysql_query("select volume_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$expected_return=mysql_result(mysql_query("select expected_return_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$risk_level=mysql_result(mysql_query("select expected_risk_d from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All where market_ID='".$_SESSION['exchange']."') and futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);
			$accuracy=mysql_result(mysql_query("select accuracy from Futures_All where futures_ID='".$search_two."' and market_ID='".$_SESSION['exchange']."'"),0);

			$_SESSION['contract'][$search_two]=array(
				name=>$name,
				delivery_date=>$delivery_date,
				trading_hours_start=>$trading_hours_start,
				trading_hours_end=>$trading_hours_end,
				underlying_base=>$underlying_base,
				tick_size=>$tick_size,
				contract_size=>$contract_size,
				margin=>$margin,
				time_d=>$time,
				open_price=>$open_price,
				high_price=>$high_price,
				low_price=>$low_price,
				close_price=>$close_price,
				volume=>$volume,
				expected_return=>$expected_return,
				risk_level=>$risk_level,
				accuracy=>$accuracy
			);
		}
		//Check if contract two be liked
		$temp2=mysql_query("select * from Favorite_Contracts WHERE investor_ID=(select investor_ID from Investor where investor_name='".$_SESSION['username']."') and `market_ID`='".$_SESSION['exchange']."' and futures_ID='".$_SESSION['search_two']."'");
		$row2=mysql_num_rows($temp2);
?>
<!-- flash-->
<div id="flashContent" style="position:fixed;bottom:0px;left:auto;z-index:98;">
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="1366" height="520" id="fyp" align="center">
		<param name="movie" value="fyp - edit.swf" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#ffffff" />
		<param name="play" value="true" />
		<param name="loop" value="true" />
		<param name="wmode" value="window" />
		<param name="scale" value="exactfit" />
		<param name="menu" value="true" />
		<param name="devicefont" value="false" />
		<param name="salign" value="" />
		<param name="allowScriptAccess" value="sameDomain" />
		<!--[if !IE]>-->
		<object type="application/x-shockwave-flash" data="fyp-2.swf" width="1366" height="520" align="center">
		<param name="movie" value="fyp.swf" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#ffffff" />
		<param name="play" value="true" />
		<param name="loop" value="true" />
		<param name="wmode" value="window" />
		<param name="scale" value="exactfit" />
		<param name="menu" value="true" />
		<param name="devicefont" value="false" />
		<param name="salign" value="" />
		<param name="allowScriptAccess" value="sameDomain" />
		<!--<![endif]-->
		<a href="http://www.adobe.com/go/getflash">
		<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获得 Adobe Flash Player" />
		</a>
		<!--[if !IE]>-->
		</object>
		<!--<![endif]-->
	</object>
</div>
<!--Legend-->


<!--Contract Info display-->
<!--first one -->
<div id="contract_one" style="z-index:99;background-color:#4E6BA6;position:fixed;width:35%;height:13%;left:10%;top:50px;border: 0px;border-radius: 8px;">
	<div style="display:block;">
		<table align="middle" style="color:white;border: 0px solid white;border-collapse:collapse;margin: 0px auto;">
		<tr>
			<td><p style="color:white;size:15px;margin-left:auto;margin-top:5px;margin-bottom:5px;text-align:center;"><b><?php echo $search_one." on ".$_SESSION['exchange'];?></b></p></td>
			<?php if($row1){?><td><input type="image" src="pic/star_white.png" height="25px" onclick="unlike_one()"></input></td>
			<?php } else { ?>
			<td><input type="image" src="pic/star-outline_white.png" height="25px" onclick="like_one()"></input></td>
			<?php } ?>			
		</tr>
		</table>
		<table align="middle" id="contract_info" style="color:white;border: 1px solid white;border-collapse:collapse;margin: 0px auto;">
			<tr>
				<th align="center" valign="middle" style="border: 1px solid white;">Date</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Open Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">High Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Low Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Close Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Accuracy</th>
			</tr>
			<tr>
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_one]['time_d']; ?></td>
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_one]['open_price'];?></td>		
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_one]['high_price'];?></td>					
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_one]['low_price'];?></td>			
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_one]['close_price'];?></td>
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo ($_SESSION['contract'][$search_one]['accuracy']*100)."%";?></td>
			</tr>
		</table>
	</div>
	<div id="info_contract_one" style="display:none;">
		<ul>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Full Name: ".$_SESSION['contract'][$search_one]['name'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Delivery Date: ".$_SESSION['contract'][$search_one]['delivery_date'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Trading Hours: ".$_SESSION['contract'][$search_one]['trading_hours_start']." - ".$_SESSION['contract'][$search_one]['trading_hours_end'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Margin: ".$_SESSION['contract'][$search_one]['margin'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Tick Size: ".$_SESSION['contract'][$search_one]['tick_size'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Underlying Base: ".$_SESSION['contract'][$search_one]['underlying_base'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Contract Size: ".$_SESSION['contract'][$search_one]['contract_size'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Expected Return: ".$_SESSION['contract'][$search_one]['expected_return'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Risk Level: ".$_SESSION['contract'][$search_one]['risk_level'];?></p></li>
		</ul>			
	</div>
</div>
<!-- Contract Info two -->
<div id="contract_two" style="z-index:99;background-color:#4E6BA6;position:fixed;width:35%;height:13%;right:10%;top:50px;border: 0px;border-radius: 8px;">
	<div style="display:block;">
		<table align="middle" style="color:white;border: 0px solid white;border-collapse:collapse;margin: 0px auto;">
		<tr>
			<td><p style="color:white;size:15px;margin-left:auto;margin-top:5px;margin-bottom:5px;text-align:center;"><b><?php echo $search_two." on ".$_SESSION['exchange'];?></b></p></td>	
			<?php if($row2){?><td><input type="image" src="pic/star_white.png" height="25px" onclick="unlike_two()"></input></td>
			<?php } else { ?>
			<td><input type="image" src="pic/star-outline_white.png" height="25px" onclick="like_two()"></input></td>
			<?php } ?>	
		</tr>
		</table>
		<table align="middle" id="contract_info" style="color:white;border: 1px solid white;border-collapse:collapse;margin: 0px auto;">
			<tr>
				<th align="center" valign="middle" style="border: 1px solid white;">Date</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Open Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">High Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Low Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Close Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Accuracy</th>
			</tr>
			<tr>
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_two]['time_d']; ?></td>
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_two]['open_price'];?></td>		
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_two]['high_price'];?></td>					
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_two]['low_price'];?></td>			
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_two]['close_price'];?></td>
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo ($_SESSION['contract'][$search_two]['accuracy']*100)."%";?></td>

			</tr>
		</table>
	</div>
	<div id="info_contract_two" style="display:none;">
		<ul>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Full Name: ".$_SESSION['contract'][$search_two]['name'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Delivery Date: ".$_SESSION['contract'][$search_two]['delivery_date'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Trading Hours: ".$_SESSION['contract'][$search_two]['trading_hours_start']." - ".$_SESSION['contract'][$search_two]['trading_hours_end'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Margin: ".$_SESSION['contract'][$search_two]['margin'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Tick Size: ".$_SESSION['contract'][$search_two]['tick_size'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Underlying Base: ".$_SESSION['contract'][$search_two]['underlying_base'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Contract Size: ".$_SESSION['contract'][$search_two]['contract_size'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Expected Return: ".$_SESSION['contract'][$search_two]['expected_return'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Risk Level: ".$_SESSION['contract'][$search_two]['risk_level'];?></p></li>
		</ul>			
	</div>
</div>
<?php
	//Check if it got only 1 variable
	} else if ($_SESSION['search_two']==""){
?>
<!-- flash-->
<div id="flashContent" style="position:fixed;bottom:0px;left:auto;z-index:99;">
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="900" height="620" id="fyp" align="center">
		<param name="movie" value="fyp - edit.swf" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#ffffff" />
		<param name="play" value="true" />
		<param name="loop" value="true" />
		<param name="wmode" value="window" />
		<param name="scale" value="exactfit" />
		<param name="menu" value="true" />
		<param name="devicefont" value="false" />
		<param name="salign" value="" />
		<param name="allowScriptAccess" value="sameDomain" />
		<!--[if !IE]>-->
		<object type="application/x-shockwave-flash" data="fyp.swf" width="900" height="620" align="center">
		<param name="movie" value="fyp.swf" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#ffffff" />
		<param name="play" value="true" />
		<param name="loop" value="true" />
		<param name="wmode" value="window" />
		<param name="scale" value="exactfit" />
		<param name="menu" value="true" />
		<param name="devicefont" value="false" />
		<param name="salign" value="" />
		<param name="allowScriptAccess" value="sameDomain" />
		<!--<![endif]-->
		<a href="http://www.adobe.com/go/getflash">
		<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获得 Adobe Flash Player" />
		</a>
		<!--[if !IE]>-->
		</object>
		<!--<![endif]-->
	</object>
</div>
<!--Legend-->


<!--Contract Info display-->
<div style="z-index:99;background-color:#4E6BA6;position:fixed;width:35%;height:45%;right:1%;top:50px;border: 0px;border-radius: 8px;">
	<div style="display:block;">
		<table align="middle" style="color:white;border: 0px solid white;border-collapse:collapse;margin: 0px auto;">
		<tr>
			<td><p style="color:white;size:15px;margin-left:auto;margin-top:5px;margin-bottom:5px;text-align:center;"><b><?php echo $search_one." on ".$_SESSION['exchange'];?></b></p></td>
			<?php if($row1){?><td><input type="image" src="pic/star_white.png" height="25px" onclick="unlike_one()"></input></td>
			<?php } else { ?>
			<td><input type="image" src="pic/star-outline_white.png" height="25px" onclick="like_one()"></input></td>
			<?php } ?>			
		</tr>
		</table>
		<table align="middle" id="contract_info" style="color:white;border: 1px solid white;border-collapse:collapse;margin: 0px auto;">
			<tr>
				<th align="center" valign="middle" style="border: 1px solid white;">Date</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Open Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">High Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Low Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Close Price</th>
				<th align="center" valign="middle" style="border: 1px solid white;">Accuracy</th>
			</tr>
			<tr>
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_one]['time_d']; ?></td>
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_one]['open_price'];?></td>		
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_one]['high_price'];?></td>					
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_one]['low_price'];?></td>			
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo $_SESSION['contract'][$search_one]['close_price'];?></td>
				<td align="center" valign="middle" style="border: 1px solid white;"><?php echo ($_SESSION['contract'][$search_one]['accuracy']*100)."%";?></td>
			</tr>
		</table>
	</div>
	<div>
		<ul>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Full Name: ".$_SESSION['contract'][$search_one]['name'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Delivery Date: ".$_SESSION['contract'][$search_one]['delivery_date'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Trading Hours: ".$_SESSION['contract'][$search_one]['trading_hours_start']." - ".$_SESSION['contract'][$search_one]['trading_hours_end'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Margin: ".$_SESSION['contract'][$search_one]['margin'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Tick Size: ".$_SESSION['contract'][$search_one]['tick_size'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Underlying Base: ".$_SESSION['contract'][$search_one]['underlying_base'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Contract Size: ".$_SESSION['contract'][$search_one]['contract_size'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Expected Return: ".$_SESSION['contract'][$search_one]['expected_return'];?></p></li>
			<li type="square" style="color:white"><p style="color:white;margin-left:10px;margin-top:5px;margin-bottom:5px;"><?php echo "Risk Level: ".$_SESSION['contract'][$search_one]['risk_level'];?></p></li>
		</ul>			
	</div>
</div>
<?php
	}
?>
</body>
</html>