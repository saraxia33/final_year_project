<?PHP
session_start();
	
require_once("accesscontrol.php");
require_once("connection.php");

$query = mysql_query("delete from Favorite_Contracts WHERE investor_ID=(select investor_ID from Investor where investor_name='".$_SESSION['username']."') and `market_ID`='".$_SESSION['exchange']."' and futures_ID='".$_SESSION['search_one']."'");

//echo '<script type="text/javascript">alert("'.$error.'");</script>';
header("location:layer3.php");	
?>