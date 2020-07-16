<body>
<!--Tool Bar-->
<?php
	$query_count = mysql_query("select * from alert WHERE investor_ID=(select investor_ID from Investor where investor_name='".$_SESSION['username']."')");
	$count=mysql_num_rows($query_count);
?>
    <div style="background-color:black; height:43px; width:100%; position:fixed; left:0px; top:0px; padding:0;  margin:0;">
		
			<form>
				<a href="layer1.php"><img src="pic/logo.png" height="33px" style="margin-left:8px;margin-right:8px;"/></input></a>
				<a href="layer1.php"><img type="image" src="pic/global view.png" height="26px" style="margin-left:8px;margin-right:8px;"/></input></a>
				<a href="layer2.php"><img src="pic/bubble chart.png"  height="26px" style="margin-left:8px;margin-right:8px;"></img></a>
				<a href="layer3.php"><img src="pic/techical analysis.png" height="26px" style="margin-left:8px;margin-right:8px;"/></img></a>
				
		</form>
		
		<div style="position:fixed; top:0px; right:20px;">
			<form action="search.php" method="post" type="post">
				<input type="text" name="search" id="search" placeholder="Search here!" />
				<input type="image" src="pic/search.png" style="height:20px;"alt="Submit Form" />			
            </form>
		</div>

<script>
	//Mouse-over and mouse-leave events
	$(document).ready(function(){
		$("button").mouseover(function(){
			$("#menu").css("display","block");
		});
		$("#menu").mouseleave(function(){
			$("#menu").css("display","none");		
		});
	});
</script>	
</div>
<div id="menu" style="background-color:black; height:43px; width:500px;position:fixed; left:545px; top:0px; padding:0;  margin:0;display:none;">
<a href="profile.php"><button type="button" style="position:fixed;top:11px;left:680px;border:none;border-radius:40px;background: white;color: #003471;padding: 5px 37px;margin: 0;z-index:99;" onclick="goTwoRunway()"><b>Favourite Contracts</b></button></a>
<a href="traditional.php"><button type="button" style="position:fixed;top:11px;left:885px;border:none;border-radius:40px;background: white;color: #003471;padding: 5px 37px;margin: 0;z-index:99;" onclick="goTwoRunway()"><b>Traditional View</b></button></a>
</div>
<button type="button" style="position:fixed;top:11px;left:550px;border:none;border-radius:40px;background: white;color: #003471;padding: 5px 37px;margin: 0;z-index:99;" onclick="goTwoRunway()"><b>Options</b></button>
