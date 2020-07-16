<?php
	require_once("accesscontrol.php");
	if($_REQUEST['exchange']){
		$_SESSION['exchange']=$_REQUEST['exchange'];
	} 
	if(!$_SESSION['exchange']){
		echo '<script type="text/javascript">alert("Please select a valid exchange!");</script>';
		header("location:layer1.php");	
	}
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
	//Mouse-over and mouse-leave events
	$(document).ready(function(){
		$("#play_button").click(function(){
			$("#play_button").css("display","none");
		});
		$("#end_button").click(function(){
			$("#play_button").css("display","block");		
		});
	});
</script>
</head>
<?php
	//Navigation bar and tool bar
	require_once("body_begin.php");
?>
<!--Current Selection-->
<div style="background-color:#003471;position:fixed;width:20%;height:21%;right:1%;top:50px;border: 0px;border-radius: 8px;z-index:-99;">
<h2 style="margin:0;color:white;text-align:center;">Current Selection</h2>
</div>
<p id="chart"></p>
<div style="position:absolute;bottom:1%;">
<span id="min-time">Latest</span> 
<input type="range" name="points" min="0" max="30" step="1" value="0" id="slider-time" style="width:900px" oninput="myFunction()">
<span id="max-time">30 days ago</span>
</div>
<script>
// Various accessors that specify the four dimensions of data to visualize.
function x(d) { return d.risk; }
function y(d) { return d.expectedReturn; }
function radius(d) { return d.volume; }
function color(d) { return d.price; }
function key(d) { return d.contractName; }
function playdate(d) {return d.date; }

// Chart dimensions.
var margin = {top: 80, right: 150, bottom: 50, left: 150},
	width = 1100 - margin.right,
	height = 600 - margin.bottom - margin.bottom;

	var exchange = <?php echo json_encode($_SESSION['exchange']); ?>;

// Various scales. These domains make assumptions of data, naturally.
if(exchange == 'XCME'){
var xScale = d3.scale.linear().domain([-0.00001, 0.0001]).range([0, width]),
	yScale = d3.scale.linear().domain([-0.04, 0.06]).range([height, 0]),
	radiusScale = d3.scale.sqrt().domain([0, 7e6]).range([0, 250]),
	colorScale = d3.scale.linear().domain([10,100,1500,3000,10000]).range(["#D5D9C5","#78ABBF","#4E6BA6","#003471","#002755","black"]);
} else if(exchange == 'XHKF'){
	var xScale = d3.scale.linear().domain([0, 0.00015]).range([0, width]),
	yScale = d3.scale.linear().domain([-0.03, 0.06]).range([height, 0]),
	radiusScale = d3.scale.sqrt().domain([0, 980000]).range([0, 250]),
	colorScale = d3.scale.linear().domain([10,100,1500,3000,10000]).range(["#D5D9C5","#78ABBF","#4E6BA6","#003471","#002755","black"]);
} else if (exchange == 'XEUR') {
var xScale = d3.scale.linear().domain([-0.00005, 0.0003]).range([0, width]),
	yScale = d3.scale.linear().domain([-0.02, 0.03]).range([height, 0]),
	radiusScale = d3.scale.sqrt().domain([0, 34000]).range([0, 250]),
	colorScale = d3.scale.linear().domain([10,100,1500,3000,10000]).range(["#D5D9C5","#78ABBF","#4E6BA6","#003471","#002755","black"]);
}

// The x & y axes.
var xAxis = d3.svg.axis().orient("bottom").scale(xScale).ticks(5, d3.format(",d")),
    yAxis = d3.svg.axis().scale(yScale).orient("left");

// Create the SVG container and set the origin.
var svg = d3.select("#chart").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
    .attr("class", "gRoot")

// Add the x-axis.
svg.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")")
    .call(xAxis);

// Add the y-axis.
svg.append("g")
    .attr("class", "y axis")
    .call(yAxis);

// Add an x-axis label.
svg.append("text")
    .attr("class", "x label")
    .attr("text-anchor", "end")
    .attr("x", width)
    .attr("y", height - 6)
    .text("risk");

// Add a y-axis label.
svg.append("text")
    .attr("class", "y label")
    .attr("text-anchor", "end")
    .attr("y", 6)
    .attr("dy", ".75em")
    .attr("transform", "rotate(-90)")
    .text("expected return");


/* Add the country label; the value is set on transition.
var countrylabel = svg.append("text")
    .attr("class", "country label")
    .attr("text-anchor", "start")
    .attr("y", 80)
    .attr("x", 20)
    .text(" ");*/

// Add tooltip div
var div = d3.select("body")
	.append("div")  
	.attr("class", "tooltip")             
	.style("opacity", 0); 

var div_compare = d3.select("body")
	.append("div")  
	.attr("class", "tooltip")             
	.style("opacity", 0); 

	
// Add the year label; the value is set on transition.
var label = svg.append("text")
    .attr("class", "year label")
    .attr("text-anchor", "end")
    .attr("y", height - 24)
    .attr("x", width)
    .text("");
	
// Add Selections
var selection1 = d3.select("body")
	.append("div")  
	.attr("class", "current_selection")
	.style("opacity", 0); 
	
var selection2 = d3.select("body")
	.append("div")  
	.attr("class", "current_selection")
	.style("opacity", 0); 

// Add two_runway Button
var two_runway = d3.select("body")
	.append("div")  
	.attr("class", "current_selection")
	.style("opacity", 0); 
	
var selection_number = 1;

// Load the data.
d3.json("data_layer2.php", function(nations) {	
	var nest = d3.nest()
	.key(function(d) { return d.date; })
    .entries(nations);

  // Add a dot per nation. Initialize the data at 1800, and set the colors.
  var dot = svg.append("g")
      .attr("class", "dots")
    .selectAll(".dot")
      .data(d3.values(nest[0])[1])
    .enter().append("circle")
      .attr("class", "dot")
      .style("fill", function(d) { return colorScale(color(d)); })
      .call(position).sort(order)
	  .on("mousedown", function(d, i) {

      })
      .on("mouseup", function(d, i) {
        dot.classed("selected", false);
        d3.select(this).classed("selected", !d3.select(this).classed("selected"));
		if(selection_number==1){
			//display the first contract
			selection1.transition()
				.duration(200)
				.style("opacity", 1);
			selection1 .html(
				'<p> 1. ' + d.contractName + "</p>"
				)
				.style("left", 80+"%")			 
				.style("top", 65+"px");
			oFormObject = document.forms['hidden_form'];
			oFormObject.elements["data_name_one"].value = d.contractName;	
			selection_number = 2;
		} else if(selection_number ==2){
			//display the second contract
			selection2.transition()
				.duration(200)
				.style("opacity", 1);
			selection2 .html(
				'<p> 2. ' + d.contractName + "</p>"
				)
				.style("left", 80+"%")			 
				.style("top", 95+"px");
			oFormObject = document.forms['hidden_form'];
			oFormObject.elements["data_name_two"].value = d.contractName;	
			selection_number = 1;
			
			//Display go to layer3 button
			two_runway.transition()
				.duration(200)
				.style("opacity", 1);
			two_runway .html(
				'<button type="button" style="border:none;border-radius:40px;background: #FFFFFF;color: #003471;padding: 10px 37px;margin: 10px 0 20px 10px;" onclick="goTwoRunway()"><b>Technical Analysis</b></button>'
				)
				.style("right", 4+"%")			 
				.style("top", 135+"px");
		}
	
        div_compare.transition()
				.duration(200)	
				.style("opacity", .9);	
		div_compare	.html(
				'<h2 style="text-align:center;margin-top:1px;margin-bottom:2px;">' + d.contractName + "</h2>"  + 
				'<ul>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Full Name: '+d.futures_name+'</p></li>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Delivery Date: '+d.delivery_date+'</p></li>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Trading Hours: '+d.trading_hours_o+' - '+d.trading_hours_c+'</p></li>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Margin: '+d.margin+'</p></li>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Tick Size: '+d.price_Increment+'</p></li>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Contract Size:'+d.contract_size+'</p></li>'+				
				'</ul>'			
					)
				.style("right", 1+"%")			 
				.style("top", 30+"%")
				.style("background","#5f82ab");

      })
	  .on("dblclick",function(d,i){
		oFormObject = document.forms['hidden_form'];
		oFormObject.elements["data_name_one"].value = d.contractName;
		oFormObject.elements["data_name_two"].value = "";
		oFormObject.submit();
	  })
      .on("mouseenter", function(d, i) {
		  var m = d.contractName;
          dot.style("opacity", .4);
          d3.select(this).style("opacity", 1);
          d3.selectAll(".selected").style("opacity", 1);
			div.transition()
				.duration(200)	
				.style("opacity", .9);	
			div	.html(
				'<h2 style="text-align:center;margin-top:1px;margin-bottom:2px;">' + d.contractName + "</h2>"  + 
				'<ul>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Full Name: '+d.futures_name+'</p></li>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Delivery Date: '+d.delivery_date+'</p></li>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Trading Hours: '+d.trading_hours_o+' - '+d.trading_hours_c+'</p></li>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Margin: '+d.margin+'</p></li>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Tick Size: '+d.price_Increment+'</p></li>'+
				'<li type="square" style="color:white"><p style="color:white;margin-left:1px;margin-bottom:2px;"> Contract Size:'+d.contract_size+'</p></li>'+				
				'</ul>'			
					)
				.style("right", 1+"%")			 
				.style("top", 63+"%")
				.style("background","darkblue");
      })
      .on("mouseleave", function(d, i) {
		div.transition()
				.duration(200)	
				.style("opacity", 0);	
          dot.style("opacity", 1);       
      })


  // Positions the dots based on data.
  function position(dot) {
    dot.attr("cx", function(d,i) { return xScale(x(d)); })
       .attr("cy", function(d,i) { return yScale(y(d)); })
       .attr("r", function(d,i) { return radiusScale(radius(d)); });
  }

  // Defines a sort order so that the smallest dots are drawn on top.
  function order(a, b) {
    return (radius(b) - radius(a));
  }
  
// Add the year label; the value is set on transition.
	label.text(d3.values(nest[0])[0]);


});

function goTwoRunway() {
	oFormObject = document.forms['hidden_form'];
	oFormObject.submit();
}
function myFunction() {
    var a = document.getElementById("slider-time").value;
    //get data again
	d3.json("data_layer2.php", function(nations) {	
	var nest = d3.nest()
	.key(function(d) { return d.date; })
    .entries(nations);
	label.text(d3.values(nest[a])[0]);
	
	 var gdots = d3.selectAll(".dot").data(d3.values(nest[a])[1])
    
    
	 // Transite the dots
	gdots.transition().duration(300)
			 .style("fill", function(d) { return colorScale(color(d)); })
			 .call(position)
			 .sort(order);
			 
 function position(dot) {
    dot.attr("cx", function(d,i) { return xScale(x(d)); })
       .attr("cy", function(d,i) { return yScale(y(d)); })
       .attr("r", function(d,i) { return radiusScale(radius(d)); });
  }
  
  // Defines a sort order so that the smallest dots are drawn on top.
  function order(a, b) {
    return (radius(b) - radius(a));
  }
}) ;
}
var m = 0;
var myVar = setInterval(function(){display()},1000);

function display() {
    //get data again
	d3.json("data_layer2.php", function(nations) {	
		if(m<=30){
		var nest = d3.nest()
		.key(function(d) { return d.date; })
		.entries(nations);
		label.text(d3.values(nest[m])[0]);
		
		 var gdots = d3.selectAll(".dot").data(d3.values(nest[m])[1])
		
		
		 // Transite the dots
		gdots.transition().duration(300)
				 .style("fill", function(d) { return colorScale(color(d)); })
				 .call(position)
				 .sort(order);
				 
	 function position(dot) {
		dot.attr("cx", function(d,i) { return xScale(x(d)); })
		   .attr("cy", function(d,i) { return yScale(y(d)); })
		   .attr("r", function(d,i) { return radiusScale(radius(d)); });
	  }
	  
	  // Defines a sort order so that the smallest dots are drawn on top.
	  function order(a, b) {
		return (radius(b) - radius(a));
	  }
	m++;
	} else {
		m = 0;
	}
}) ;
}
</script>
<img id="play_button" src="pic/media-fast-forward.png" onclick="myVar=setInterval(function(){display()},1500)" style="display:none;height:4%; width:3%; position:fixed; bottom:10px; right:10px;"></img>
<img id="end_button" src="pic/media-stop.png" onclick="clearInterval(myVar)" style="height:4%; width:2%; position:fixed; bottom:10px; right:50px;"></img>

<form action="getName.php" type="post" method="post" id="hidden_form">
<input type="hidden" name="data_name_one" id="data_name_one"></input>
<input type="hidden" name="data_name_two" id="data_name_two"></input>
</form>
</html>