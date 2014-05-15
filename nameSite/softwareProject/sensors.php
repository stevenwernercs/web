<?php session_start();
	/*begin JAVA_BRIDGE*/
		require_once("./JavaConnect.inc");
		setBridge("/Java_Bridge/GUISensor", "Sensor", $_SESSION['ID'], true);
	/*end JAVA_BRIDGEecho $sensors*/

	if (!(empty($_POST["Identfier"])))
	{
		$result=java_context()->getServlet()->updateSensor($_POST["Identfier"], $_POST["SerialNum"], $_POST["type"],
		$_POST["location"], $_POST["precision"], $_POST["latitude"], $_POST["longitude"], $_POST["fields1"], $_POST["unit1"],
		 $_POST["fields2"], $_POST["unit2"], $_POST["fields3"], $_POST["unit3"], $_POST["fields4"], $_POST["unit4"]);
	}
	$sensors = ""; //java_context()->getServlet()->printSensorArray();
?>
<script> 
var link;
function get_sensor(index)
{
	var sensors = new Array();
	sensors[0]   = ["NAME" , "0001", "?", "LOCATION",     22.6833, -12.4667, "PRECISION", ["FIELDS","UNIT"], ["Type2","F"], ["Type3","C"]];

<?php
	echo $sensors; 
?>	
	sensors[1]   = ["sensor 1" , "0001", "Multiple Field", "New York, NY", 40.6700, -73.9400, "10%", ["time","24h:mm:ss"], ["temperature","F"], ["temperature","C"]];
	sensors[2]   = ["sensor 2" , "0002", "Multiple Field", "Denver, CO", 39.7392, -104.9847, "5%", ["time","24h:mm:ss"], ["temperature","F"], ["humidity","%"]];
	sensors[3]   = ["sensor 3" , "0003", "Multiple Field", "Phoenix, AZ", 33.4500, -112.0667, "10%", ["time","24h:mm:ss"], ["temperature","F"], ["rain","mm"], ["light","lux"]];
	sensors[4]   = ["sensor 4" , "0004", "Multiple Field", "Dallas, TX", 32.7758, -96.7967, "15%", ["time","24h:mm:ss"], ["temperature","F"], ["wind","m/s"]];
	sensors[5]   = ["sensor 5" , "0005", "Multiple Field", "Detriot, MI", 42.3314, -83.0458, "10%", ["time","24h:mm:ss"], ["temperature","F"]];
	sensors[6]   = ["MIT: Home of EyeWire!" , "0005", "Multiple Field", "Cambridge, MA", 42.3598, -71.0921, "0%", ["time","24h:mm:ss"], ["light","Lux"]];
	
	if(index < 0)
		return sensors;
	return sensors[index];
}
function get_locations(index)
{
	if(index<=0)
		return ["0", 22.6833, -12.4667, 0];
	var sensors = get_sensor(index);
	var location=['<h4>'+sensors[0]+'</h4>', sensors[4], sensors[5], getColor(sensors)];
	return location;
}
function getColor(sensor)
{
    //iconURLPrefix + 'red-dot.png', 			//temp
    //iconURLPrefix + 'green-dot.png',			//humid
    //iconURLPrefix + 'blue-dot.png',			//rain
    //iconURLPrefix + 'orange-dot.png',			//time
    //iconURLPrefix + 'purple-dot.png',			//wind
    //iconURLPrefix + 'pink-dot.png',      		//else
    //iconURLPrefix + 'yellow-dot.png'		   	//light
    var i;
    for(i = 7; i < sensor.length; i++)
        if(sensor[i][0].toLowerCase().search("rain")>-1)
        	return "2";
    for(i = 7; i < sensor.length; i++)
        if(sensor[i][0].toLowerCase().search("light")>-1)
        	return "6";
    for(i = 7; i < sensor.length; i++)
        if(sensor[i][0].toLowerCase().search("humidity")>-1)
        	return "1";
    for(i = 7; i < sensor.length; i++)
        if(sensor[i][0].toLowerCase().search("wind")>-1)
        	return "4";
    for(i = 7; i < sensor.length; i++)
        if(sensor[i][0].toLowerCase().search("temp")>-1)
        	return "0";
    for(i = 7; i < sensor.length; i++)
        if(sensor[i][0].toLowerCase().search("time")>-1)
        	return "3";
	return "5";
}
function searchRules() 
{
	clearInputs();
	link = new Array();
	link[0]=0;
	var locations = new Array();
	var locIndex = 1;
	var list = document.getElementById('popSensors');
	var filterValuefromBox = document.getElementById('SearchBox').value.toLowerCase();
	var isSearch = true;
	if(filterValuefromBox.search("<keyword to filter sensors>")==0)
		filterValuefromBox="";
	if(filterValuefromBox=="")
		isSearch = false;
    var sensors = get_sensor(-1);
    list.options.length = 0;
    var option=document.createElement("option");
    if(isSearch)
    	element_name=(tab(sensors[0][0]) + tab(sensors[0][3]) + tab('MATCH'));
    else
    	element_name=(tab(sensors[0][0]) + tab(sensors[0][3]) + sensors[0][7][0]);
    option.text=element_name;
	try	
	{
	  // for IE earlier than version 8
	  list.add(option,list.options[null]);
	}
	catch (e)
	{
	  list.add(option,null);
	}
    for(var i = 1; i < sensors.length; i++)
    {
    	var merged = [];
    	merged = merged.concat.apply(merged, sensors[i]);
       	for(var j = 0; j < merged.length; j++)
    	{
       		if(merged[j].toString().toLowerCase().search(filterValuefromBox)>-1)
		    {
		    	option=document.createElement("option");
		    	if(isSearch)
		    		element_name=(tab(sensors[i][0]) + tab(sensors[i][3]) + tab(merged[j]));
		    	else
		    		element_name=(tab(sensors[i][0]) + tab(sensors[i][3]) + joinFields(sensors[i]));
				option.text=element_name;
				try	
		  		{
				  // for IE earlier than version 8
				  list.add(option,list.options[null]);
				}
				catch (e)
				{
				  list.add(option,null);
				}
				link[locIndex]=i;
			   	locations[locIndex-1]=get_locations(i);
		   	 	locIndex=locIndex+1;
		   	 	break;
			}
    	}
    	
    }
    clearMap();
    addMarkers(locations);
}
function joinFields(sensorLine)
{
	var len = sensorLine.length;
	var line = "";
	if(len>7)
	{	
		line = line + sensorLine[7][0]+'@'+sensorLine[7][1];
		if(len>8)
		{	
			line = line + ' '+sensorLine[8][0]+'@'+sensorLine[8][1];
			if(len>9)
			{	
				line = line + ' '+sensorLine[9][0]+'@'+sensorLine[9][1];
				if(len>10)
				{	
					line = line + ' '+sensorLine[10][0]+'@'+sensorLine[10][1];
				}
			}
		}
	}
	return line;
}
function tab(word)
{
	var separator = "............ |   ";
	if(word.length>12)
	{
		word = word.substring(0, 10);
		word = word + '..';
	}
	separator = separator.substring(word.toString().length, separator.length);	
	return word+separator;
}
function sensor_selection()
{
	var x=document.getElementById("popSensors").selectedIndex;

	sensor = get_sensor(link[x]); 

	clearInputs();
	
	if(x!=0)
	{
		document.getElementById("Identfier").value = sensor[0];
		document.getElementById("SerialNum").value = sensor[1];
		document.getElementById("type").value = sensor[2];
		document.getElementById("location").value = sensor[3];
		document.getElementById("latitude").value = sensor[4];
		document.getElementById("longitude").value = sensor[5];
		document.getElementById("precision").value = sensor[6];
				
		if(sensor[7]!=null)
		{	
			document.getElementById("fields1").value = sensor[7][0];
			document.getElementById("unit1").value = sensor[7][1];
		}
		if(sensor[8]!=null)
		{	
			document.getElementById("fields2").value = sensor[8][0];
			document.getElementById("unit2").value = sensor[8][1];
		}
		if(sensor[9]!=null)
		{	
			document.getElementById("fields3").value = sensor[9][0];
			document.getElementById("unit3").value = sensor[9][1];
		}
		if(sensor[10]!=null)
		{	
			document.getElementById("fields4").value = sensor[10][0];
			document.getElementById("unit4").value = sensor[10][1];
		}
	}
	centerOn(get_locations(link[x]));
	
}
function clearInputs()
{
	document.getElementById("Identfier").value = "";
	document.getElementById("SerialNum").value = "";
	document.getElementById("type").value = "";
	document.getElementById("precision").value = "";
	document.getElementById("location").value = "";
	document.getElementById("latitude").value = "";
	document.getElementById("longitude").value = "";
	document.getElementById("fields1").value = "<field name>";
	document.getElementById("unit1").value = "<unit measure>";
	document.getElementById("fields2").value = "<field name>";
	document.getElementById("unit2").value = "<unit measure>";
	document.getElementById("fields3").value = "<field name>";
	document.getElementById("unit3").value = "<unit measure>";
	document.getElementById("fields4").value = "<field name>";
	document.getElementById("unit4").value = "<unit measure>";
}
function reset()
{
	document.getElementById("SearchBox").value = "<keyword to filter sensors>";
	searchRules();
	clearInputs();
}
function check_submit()
{
	return true;
}
function lower_case(fname)
{
	var x=document.getElementById(fname);
	x.value=x.value.toLowerCase();
}
</script>
</head>

<body onload="searchRules()">


<?php
if (!(empty($result)))
{
	echo "<div class=\"jumbotron\">";
	echo "<div class=\"container\">";
	if($result[0]=="TRUE")
	{
		echo "<h3>Success!</h3>";
	}
	else
	{
		echo "<h3>Sorry.</h3>";
	} 
	echo $result[1];
	echo "</div>";
	echo "</div>";
}
?>
<hr/>
<div class="container">
	<p>
		<h4>Sample Sensor Page: This page provides the edit/add sensors to database, and see them geographically.. </h4>
		This page conforms to the layout specified in the Software Requirements Specification Document for the project.<br/>
		You may select an individual sensor, see it's location, and see it's attributes below.<br/>
		You may filter the list of sensors, this checks every attribute for a match, and displays the matching list<br/>
		This is a sample until I can host the whole project on a tomcat server, so data is hard coded.<br/>
		Please use this as a very simple example of javascript form interaction. Thank you.
	</p>	
<hr>

<table style="position:relative;width:100%;"><!-- Beginning of Table -->
<tr>
	<td>
		<input id="SearchBox" onchange="searchRules()" type="search" size=35 value="<keyword to filter sensors>" onfocus="if (this.value=='<keyword to filter sensors>') this.value='';">
	</td>
	<td>
		<input type="button" id="search" value="search" onclick="searchRules()">
	</td>
	<td>
		<input type="button" id="reset" value="View All Sensors" onclick="reset()">
	</td>
</tr>
<tr>
	<td colspan="3">
		<style>
			select, option { font-family: Consolas,  monospace;  font-size:100%;}
		</style>
		<select id="popSensors" size="27" style="width:100%; height: 400px;" onchange="sensor_selection()">
			<!--Box with Sensors-->
		</select>
	</td>
	<td>
		<?php include ("./Map.inc");?>
	</td>
</tr>
<tr>
	<td colspan="3">
		<b>Click on sensor to edit</b>
	</td>
</tr>
</table>

	</div>
		</div>
		
		<hr>
	<div class="container">
<!--End of Sensor List and Map Table-->
<br/>
<hr>
<br/>
<!--Beginning of Textboxes Table--> 
<form action="sensors.php" onsubmit="return check_submit()" method="post">
<table>
<tr><td>Identifier*: </td> <td><input type="text" size=50 name="Identfier" id="Identfier" value="" onchange="lower_case('Identfier')" required><br></td></tr>
<tr><td>Serial Number*: </td> <td><input type="text" size=50 name="SerialNum" id="SerialNum" value="" required><br></td></tr>
<tr><td>Type: </td> <td><input type="text" size=50 name="type" id="type" value="" ><br></td></tr>
<tr><td>Location: </td> <td><input type="text" size=50 name="location" id="location" value="" ><br></td></tr>
<tr><td>Latitude* (decimal): </td><td><input type="text" size=50 name="latitude" id="latitude" value="" required><br></td></tr>
<tr><td>Longitude* (decimal): </td> <td><input type="text" size=50 name="longitude" id="longitude" value="" required><br></td></tr>
<tr><td>Precision/Accuracy* : </td> <td><input type="text" size=50 name="precision" id="precision" value="" required><br></td></tr>
<tr><td>Fields (one required*): </td> <td><input type="text" size=50 name="fields1" id="fields1" value="<field name>" onfocus="if (this.value=='<field name>') this.value='';" > <input type="text" size=50 name="unit1" id="unit1" value="<unit measure>" onfocus="if (this.value=='<unit measure>') this.value='';"><br></td></tr>
<tr><td></td> <td><input type="text" size=50 name="fields2" id="fields2"  value="<field name>" onfocus="if (this.value=='<field name>') this.value='';"> <input type="text" size=50 name="unit2" id="unit2" value="<unit measure>" onfocus="if (this.value=='<unit measure>') this.value='';"><br></td></tr>
<tr><td></td> <td><input type="text" size=50 name="fields3" id="fields3"  value="<field name>" onfocus="if (this.value=='<field name>') this.value='';"> <input type="text" size=50 name="unit3" id="unit3" value="<unit measure>" onfocus="if (this.value=='<unit measure>') this.value='';"><br></td></tr>
<tr><td></td> <td><input type="text" size=50 name="fields4" id="fields4"  value="<field name>" onfocus="if (this.value=='<field name>') this.value='';"> <input type="text" size=50 name="unit4" id="unit4" value="<unit measure>" onfocus="if (this.value=='<unit measure>') this.value='';"><br></td></tr>
<tr><td><h5>*=must be filled on update</h5></td></tr>
</table>

<div align="center">
<input type="reset" value="Clear">    <!-- Clear Button -->
<input type="submit" value="Submit">  <!-- Submit Button -->
</div>
</form>

<br/><br/>
<hr>
<?php include("./footer.inc")?>


