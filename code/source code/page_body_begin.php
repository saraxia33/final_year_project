<body style="padding-top:51px; background-image:url(img/background.png);">
	<div id="pageContainer">
		<div id="contentContainer" class="container">				
			
			<div id="navBar" class="container-fluid">

				<nav class="navbar navbar-inverse navbar-fixed-top">
				  <div class="container-fluid">
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>                        
				      </button>
				      <a class="navbar-brand" href="/~prj4540a/">SEEM4540 Coffee Shop</a>
				    </div>
				    <div class="collapse navbar-collapse navbar-right" id="myNavbar">
				      <ul class="nav navbar-nav">
				        <li><a href="/~prj4540a/">Home</a></li>
				        <li><a href="/~prj4540a/products/">Products</a></li>
				        <li><a href="/~prj4540a/shopping-cart/">Shopping Cart</a></li>
				        <li><a href="/~prj4540a/contact-us/">Contact Us</a></li>
				      </ul>
				    </div>
				  </div>
				</nav>
			</div>

			<div id="headerInfo" class="container-fluid">
			  <div class="row">
			    <div class="col-sm-12">
				    <img class="headerLogo" src="img/logo.png">
				    <img class="headerSlogan" src="img/slogan.png">
				    <table id="headerTable">
					    <tr>
						    <td>
							    <?php require_once 'page_shoppingcart_function.php';?>
						    </td>
					    </tr>
					    
					    <!--If user login-->
					    			    
					    <!---->
					    
					    <!--If user didn't login-->
					    <tr>
						    <td>
							    <a class="headerUser" href="<?php echo wp_login_url(); ?>"><span class="glyphicon glyphicon-log-in"></span>&nbsp;Login</a>
							    <a class="headerUser" href="<?php echo wp_registration_url();?>"><span class="glyphicon glyphicon-user"></span>&nbsp;Sign Up&nbsp;</a>
						    </td>
					    </tr>
					    <!---->
					    
				    </table>
				  </div>
			  </div>
			</div>