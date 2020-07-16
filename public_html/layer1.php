<?php
	require_once("accesscontrol.php");
	//Get data from database here
	if($_SESSION['visit']!=1){
		//cme
		$_SESSION['cme_unique_one']=mysql_result(mysql_query("select uni_contract1 from Market where market_ID='XCME'"),0);
		$_SESSION['cme_unique_two']=mysql_result(mysql_query("select uni_contract2 from Market where market_ID='XCME'"),0);
		$_SESSION['cme_unique_three']=mysql_result(mysql_query("select uni_contract3 from Market where market_ID='XCME'"),0);	
		$_SESSION['cme_count_up']=mysql_num_rows(mysql_query("select * from Price_Day_All where market_ID='XCME' and time_d_value=(select max(time_d_value) from Price_Day_All) and expected_return_d>0"));
		$_SESSION['cme_count_down']=mysql_num_rows(mysql_query("select * from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and expected_return_d<0 and market_ID='XCME'"));
		$_SESSION['cme_count']=mysql_num_rows(mysql_query("select * from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and market_ID='XCME'"));	
		$_SESSION['cme_up']=$_SESSION['cme_count_up']/$_SESSION['cme_count'];
		$_SESSION['cme_down']=$_SESSION['cme_count_down']/$_SESSION['cme_count'];	
		$_SESSION['cme_total']=mysql_result(mysql_query("select sum(volume_d) as total from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and market_ID='XCME'"),0);
		
		//hkfe
		$_SESSION['hkfe_unique_one']=mysql_result(mysql_query("select uni_contract1 from Market where market_ID='XHKF'"),0);
		$_SESSION['hkfe_unique_two']=mysql_result(mysql_query("select uni_contract2 from Market where market_ID='XHKF'"),0);
		$_SESSION['hkfe_unique_three']=mysql_result(mysql_query("select uni_contract3 from Market where market_ID='XHKF'"),0);		
		$_SESSION['hkfe_count_up']=mysql_num_rows(mysql_query("select * from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and expected_return_d>0 and market_ID='XHKF'"));
		$_SESSION['hkfe_count_down']=mysql_num_rows(mysql_query("select * from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and expected_return_d<0 and market_ID='XHKF'"));
		$_SESSION['hkfe_count']=mysql_num_rows(mysql_query("select * from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and market_ID='XHKF'"));		
		$_SESSION['hkfe_up']=$_SESSION['hkfe_count_up']/$_SESSION['hkfe_count'];
		$_SESSION['hkfe_down']=$_SESSION['hkfe_count_down']/$_SESSION['hkfe_count'];		
		$_SESSION['hkfe_total']=mysql_result(mysql_query("select sum(volume_d) as total from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and market_ID='XHKF'"),0);
		
		//eurex
		$_SESSION['eurex_unique_one']=mysql_result(mysql_query("select uni_contract1 from Market where market_ID='XEUR'"),0);
		$_SESSION['eurex_unique_two']=mysql_result(mysql_query("select uni_contract2 from Market where market_ID='XEUR'"),0);
		$_SESSION['eurex_unique_three']=mysql_result(mysql_query("select uni_contract3 from Market where market_ID='XEUR'"),0);		
		$_SESSION['eurex_count_up']=mysql_num_rows(mysql_query("select * from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and expected_return_d>0 and market_ID='XEUR'"));
		$_SESSION['eurex_count_down']=mysql_num_rows(mysql_query("select * from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and expected_return_d<0 and market_ID='XEUR'"));
		$_SESSION['eurex_count']=mysql_num_rows(mysql_query("select * from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and market_ID='XEUR'"));		
		$_SESSION['eurex_up']=$_SESSION['eurex_count_up']/$_SESSION['eurex_count'];
		$_SESSION['eurex_down']=$_SESSION['eurex_count_down']/$_SESSION['eurex_count'];		
		$_SESSION['eurex_total']=mysql_result(mysql_query("select sum(volume_d) as total from Price_Day_All where time_d_value=(select max(time_d_value) from Price_Day_All) and market_ID='XEUR'"),0);

		$_SESSION['visit']=1;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>FuturesV</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="js/jquery.js"></script>
	<link href="style.css" rel="stylesheet" type="text/css">
<script>
	//Mouse-over and mouse-leave events
	$(document).ready(function(){
		$("#hkfe").mouseover(function(){
			$("#info_hkfe").css("display","block");
		});
		$("#hkfe").mouseleave(function(){
			$("#info_hkfe").css("display","none");		
		});
	});
	
	$(document).ready(function(){
		$("#cme").mouseover(function(){
			$("#info_cme").css("display","block");
		});
		$("#cme").mouseleave(function(){
			$("#info_cme").css("display","none");		
		});
	});
	
	$(document).ready(function(){
		$("#eurex").mouseover(function(){
			$("#info_eurex").css("display","block");
		});
		$("#eurex").mouseleave(function(){
			$("#info_eurex").css("display","none");		
		});
	});	
</script>
</head> 

<?php
	//Navigation Bar and Tool Bar
	require_once("body_begin.php");
	$hkfe=0.50625;
?>
<div>
	<img src="pic/map.png" style="height:95%; width:100%; position:fixed; top:45px; z-index:0;left:0px;"></img>
	<!-- Exchange icon form -->
	<form name="selectExchange" method="post" action="layer2.php">
		<input id="hkfe" name="exchange" type="image" src="pic/city_hkfe.png" value="XHKF" style="position:fixed;right:27%;top:48%;width:130px;"></input>
		<input id="cme" name="exchange" type="image" src="pic/city_cme.png" value="XCME" style="position:fixed;left:22%;top:35%;width:80px;"></input>
		<input id="eurex" name="exchange" type="image" src="pic/city_eurex.png" value="XEUR" style="position:fixed;left:48%;top:27%;width:120px;"></input>
		
	</form>
	<!-- Hidden Pages -->
	<div>
		<!-- HKFE -->
		<div id="info_hkfe" style="display:none;background-color:black;position:fixed;width:250px;height:350px;opacity:0.9;right:32%;top:25%;">
			<div>
				<img src="pic/logo_hkfe.png" style="width:240px;"></img>
				<h2 style="color:white;margin-left:10px;margin-top:0px;margin-bottom:5px;">Market Summary:</h2>
				<div style="background-color:grey;margin-left:10px;width:230px;height:30px;">
					<div style="display:table-cell;background-color:red;margin:0px;width:<?php echo $hkfe*230;?>px;height:30px;text-align:center;">
						<h3 style="color:white;margin-top:5px;margin-bottom:5px;vertical-align:middle;"><?php echo round($hkfe*100,2);?>%</h3>
					</div>
					<div style="display:table-cell;background-color:green;margin:0px;width:<?php echo (1-$hkfe)*230;?>px;height:30px;text-align:center;">
						<h3 style="color:white;margin-top:5px;margin-bottom:5px;vertical-align:middle;"><?php echo round((1-$hkfe)*100,2);?>%</h3>
					</div>
				</div>
				<h2 style="color:white;margin-left:10px;margin-top:10px;margin-bottom:0px;">Total Trading Volume:</h2>
				<div style="margin-left:10px;width:230px;height:30px;text-align:center;"><h3 style="color:red;margin:0px;"><?php echo $_SESSION['hkfe_total'];?> Contracts</h3></div>
				<h2 style="color:white;margin-left:10px;margin-top:0px;margin-bottom:0px;">Unique contracts</h2>
				<ul>
					<li style="color:white;"><b><?php echo $_SESSION['hkfe_unique_one'];?></b></li>
					<li style="color:white;"><b><?php echo $_SESSION['hkfe_unique_two'];?></b></li>
					<li style="color:white;"><b><?php echo $_SESSION['hkfe_unique_three'];?></b></li>
				</ul>
			</div>
		</div>
		<!-- CME -->
		<div id="info_cme" style="display:none;background-color:black;position:fixed;width:250px;height:300px;opacity:0.9;left:4%;top:20%;">
			<div>
				<img src="pic/logo_cme.png" style="width:240px;top:5px;"></img>
				<h2 id="info_cme" style="color:white;margin-left:10px;margin-top:0px;margin-bottom:5px;">Market Summary:</h2>
				<div style="background-color:grey;margin-left:10px;width:230px;height:30px;">
					<div style="display:table-cell;background-color:red;margin:0px;width:<?php echo $_SESSION['cme_up']*230;?>px;height:30px;text-align:center;">
						<h3 style="color:white;margin-top:5px;margin-bottom:5px;vertical-align:middle;"><?php echo round($_SESSION['cme_up']*100,2);?>%</h3>
					</div>
					<div style="display:table-cell;background-color:green;margin:0px;width:<?php echo $_SESSION['cme_down']*230;?>px;height:30px;text-align:center;">
						<h3 style="color:white;margin-top:5px;margin-bottom:5px;vertical-align:middle;"><?php echo round($_SESSION['cme_down']*100,2);?>%</h3>
					</div>
				</div>
				<h2 style="color:white;margin-left:10px;margin-top:10px;margin-bottom:0px;">Total Trading Volume:</h2>
				<div style="margin-left:10px;width:230px;height:30px;text-align:center;"><h3 style="color:red;margin:0px;"><?php echo $_SESSION['cme_total'];?> Contracts</h3></div>
				<h2 style="color:white;margin-left:10px;margin-top:0px;margin-bottom:0px;">Unique contracts</h2>
				<ul>
					<li style="color:white;"><b><?php echo $_SESSION['cme_unique_one'];?></b></li>
					<li style="color:white;"><b><?php echo $_SESSION['cme_unique_two'];?></b></li>
					<li style="color:white;"><b><?php echo $_SESSION['cme_unique_three'];?></b></li>
				</ul>
			</div>
		</div>
		<!-- EUREX -->
		<div id="info_eurex" style="display:none;background-color:black;position:fixed;width:250px;height:300px;opacity:0.9;left:30%;top:15%;">
			<div>
				<img src="pic/eurex_logo.png" style="position:relative;width:150px;left:10px;top:5px;"></img>
				<h2 id="info_eurex" style="color:white;margin-left:10px;margin-top:0px;margin-bottom:5px;">Market Summary:</h2>
				<div style="background-color:grey;margin-left:10px;width:230px;height:30px;">
					<div style="display:table-cell;background-color:red;margin:0px;width:<?php echo $_SESSION['eurex_up']*230;?>px;height:30px;text-align:center;">
						<h3 style="color:white;margin-top:5px;margin-bottom:5px;vertical-align:middle;"><?php echo round($_SESSION['eurex_up']*100,2);?>%</h3>
					</div>
					<div style="display:table-cell;background-color:green;margin:0px;width:<?php echo $_SESSION['eurex_down']*230;?>px;height:30px;text-align:center;">
						<h3 style="color:white;margin-top:5px;margin-bottom:5px;vertical-align:middle;"><?php echo round($_SESSION['eurex_down']*100,2);?>%</h3>
					</div>
				</div>
				<h2 style="color:white;margin-left:10px;margin-top:10px;margin-bottom:0px;">Total Trading Volume:</h2>
				<div style="margin-left:10px;width:230px;height:30px;text-align:center;"><h3 style="color:red;margin:0px;"><?php echo $_SESSION['eurex_total'];?> Contracts</h3></div>
				<h2 style="color:white;margin-left:10px;margin-top:0px;margin-bottom:0px;">Unique contracts</h2>
				<ul>
					<li style="color:white;"><b><?php echo $_SESSION['eurex_unique_one'];?></b></li>
					<li style="color:white;"><b><?php echo $_SESSION['eurex_unique_two'];?></b></li>
					<li style="color:white;"><b><?php echo $_SESSION['eurex_unique_three'];?></b></li>
				</ul>
			</div>
		</div>		
	</div>
</div>
</body>
</html>