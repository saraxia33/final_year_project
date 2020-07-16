<?PHP
session_start();

$_SESSION['username']=$_REQUEST['loginName'];
$_SESSION['password']=$_REQUEST['loginPassword'];

$username=$_REQUEST['loginName'];  
$password=$_REQUEST['loginPassword'];


require_once("connection.php");

if ($username && $password){
	$sql = "select * from Investor where Investor_Name='".$username."' and password='".$password."'";
		
    $result = mysql_query($sql);
	$rows = mysql_num_rows($result);
		
    if($rows == 1){ 
		header("location:layer1.php");		
	} else{
		header("location:index.php");
	//	echo '<script type="text/javascript">alert("'$sql'");</script>';
	}
}
