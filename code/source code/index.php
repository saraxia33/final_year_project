<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FuturesV_Layer1</title>
<script src="jquery-2.1.1.min.js"></script>
<script>
function goForward()
  {
  window.history.forward()
  }
function goBack()
  {
  window.history.back()
  }
$(document).ready(function(){
	$("#HKFE").mouseover(function(){
		$("#HKFE_info").css("display","block");
	});
	$("#HKFE").mouseleave(function(){
		$("#HKFE_info").css("display","none");		
	});
});
</script>
</head> 

<body>
<!--Tool Bar-->
<div >
    <div style="background-color:#4b4a4a; height:40px; width:100%; position:fixed; left:0px; top::0px; padding:0;  margin:0;">
      <ul style=" list-style-type: none;">
          <div>
              <a href="layer1.htm"><li style="position:fixed;top:10px;left:10px;"><img src="pic/logo.png" height="40px" href="#home"/></img></li></a>
              <li style="position:fixed;top:10px;left:60px;"><img src="/pic/user profile.png"  height="50px" href="#home"></img></li>
              <li style="position:fixed;top:10px;left:200px;"><img src="/pic/fav contracts.png" height="35px" href="#home"/></img></li> 
          </div>
      </ul>
<div style="position:fixed; top:15px; right:20px;">
              <input type="search" name="search" id="search" placeholder="Search..." />
              <div data-role="content">
                  <form method="post" action="../demoform.asp">
                  <div data-role="fieldcontain"></div>
                  </form>
              </div>             
          </div>
    <!--Navigation Bar-->
<div style="background-color:#f1f0f0; height:40px; width:100%; position:fixed; left:0px; top: 47px; padding:0; margin:0;">
      <ul style=" list-style-type: none;">
            <div>
              <a href="layer1.htm"><li style="position:fixed;top:55px;left:15px;"><img src="../pic/global view.png" height="25px" href="#home"/></img></li></a>
              <li style="position:fixed;top:55px;left:150px;"><img src="../pic/treemap view.png"  height="25px" href="#home"></img></li>
              <li style="position:fixed;top:55px;left:290px;"><img src="../pic/bubble chart.png" height="25px" href="#home"/></img></li> 
              <li style="position:fixed;top:55px;left:470px;"><img src="../pic/techical analysis.png" height="25px" href="#home"/></img></li>
              <li style="position:fixed;top:50px;right:80px;"><input type="image" src="../pic/arrow_left.png" onclick="goBack()" height="35px"></img></li>
              <li style="position:fixed;top:50px;right:40px;"><input type="image" src="../pic/arrow_right.png" onclick="goForward()" height="35px"></img></li>
            </div>
  </ul>  
</div>
    <!--Map-->
    <div>
      <img src="../pic/map.jpg" style="height:90%; width:100%; position:fixed; top:87px; z-index:0;"/></img>
      <a href="layer2_treemap.htm"><img id="HKFE" src="../pic/hongkong.png" style="height:50px; width:auto; position:fixed; top:40%; right:220px; z-index:1;"/></img></a>
      <img id="HKFE_info" src="../pic/exchange info.png" style="height:300px; width:auto; position:fixed; top:200px; right:380px; z-index:1; display:none" /></img>
    </div>
   

</body>
</html>
