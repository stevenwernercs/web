<?php session_start();
	/*begin JAVA_BRIDGE*/
		require_once("./JavaConnect.inc");
		setBridge("/Java_Bridge/GUIRule", "Rule", $_SESSION['ID'], true);
	/*end JAVA_BRIDGE*/
		
		echo "</head>";
			
		echo "<body onload=\"pop_rules('existing_rule'); pop_sensors('left_sel'); pop_sensors('right_sel'); pop_sensors('prem_sel'); pop_sensors('bool_sel')\">";
			
		if (!(empty($_POST['boolean_formula'])))
		{
			$success =java_context()->getServlet()->setRule($_SESSION['EMAIL'], $_POST['name'], $_POST['dnl'],
					$_POST['duration'], $_POST['definition'], "" ,$_POST['lbound_formula'],
					"",$_POST['rbound_formula'],"",$_POST['premise_formula'],"",
					$_POST['boolean_formula'], $_POST['rbound_sensor']);
			
				
			echo "<div class=\"jumbotron\">";
      		echo "<div class=\"container\">";
			
			if($success=="TRUE")
			{
				if($_POST['overwrite']=="TRUE")
					echo "Overwrite of Rule '".$_POST['name']."' successful." ;
				else 
					echo "Created new Rule '".$_POST['name']."' successfully." ;
			}
			else
			{
				echo "Save failed<br/>";
				echo $success;
			}
	

			echo "</div>";
			echo "</div>";
			echo "<hr>";
		}
		else 
			echo "<hr>";
		
		
                $rules   = "";  //java_context()->getServlet()->printRuleArray($_SESSION['ID']);
                $sensors = "";   //java_context()->getServlet()->printSensorArray();
?>
<!-- begin page logic -->
<script>
//text fields, to change to uppercase after modified
function lower_case(fname)
{
	var x=document.getElementById(fname);
	x.value=x.value.toLowerCase();
}
function set_enable_elements(elem_id, type)
{
		document.getElementById(elem_id).disabled=type;
}
function disable_section(sel_id, prefix)
{
	var x=document.getElementById(sel_id).selectedIndex;
	var y=document.getElementById(sel_id).options;

	disable = true;

	if(sel_id == "rule_dur")
	{	
		if(y[x].index >= 4)  //includes 5
			disable = false;
		else if(y[x].index == 2 && prefix=="left")
			disable = false;
		else if(y[x].index == 3 && prefix=="right")
			disable = false;
	}
	else if(sel_id == "rule_def")
		if(y[x].index == 4) 
			disable=false;
	
	//dis      dis       dis            dis         en
	//0=select 1=absense 2=universality 3=existance 4=response 
	
	//dis	   dis      e_L d_R    e_R d_L    en		en
	//0=select 1=global 2=after_l 3=before_R 4=between 5=until

	set_enable_elements((prefix+"_sel"),	disable	);
	set_enable_elements((prefix+"_field1"),	disable	); 
	set_enable_elements((prefix+"_field2"),	disable	);
	set_enable_elements((prefix+"_field3"),	disable	);
	set_enable_elements((prefix+"_field4"),	disable	);
	set_enable_elements((prefix+"_butt_1"),	disable	);
	set_enable_elements((prefix+"_butt_2"),	disable	);
	set_enable_elements((prefix+"_butt_3"),	disable	);
	set_enable_elements((prefix+"_butt_4"),	disable	);
	set_enable_elements((prefix+"_butt_5"),	disable	);
	set_enable_elements((prefix+"_butt_6"),	disable	);
	set_enable_elements((prefix+"_butt_7"),	disable	);
	set_enable_elements((prefix+"_butt_8"),	disable	);
	set_enable_elements((prefix+"_butt_9"),	disable	);
	set_enable_elements((prefix+"_formula"),disable	);
	//alert("Index: " + y[x].index + " is " + y[x].text);
}
function check_submit()
{
	var error_code = 0;
	var alert_msg = "";
	var rule_name = "";	

	//Req 110  check save or save as if modifying existing rule..
	x=document.getElementById("existing_rule").selectedIndex;
	//var y=document.getElementById("existing_rule").options

	//Confirm
	if(x != 0)
	{
		var r=confirm("Overwrite Existing?");
		if (r==true)
  		{
			var y=document.getElementById("existing_rule").options;
			rule_name = y[x].text;
			document.getElementById("overwrite").value = "TRUE";
  		}
		else
  		{
  			x="You pressed Cancel!";
			do
			{
				var rule_name = prompt("Please enter unique rule ID to Save As","");
				if(rule_name == null)
				{
					return false;
				}
				if(!unique(rule_name))
				{
					alert("Name is not unique locally, please re-enter unique rule ID, or cancel");
				}
			}
			while(!unique(rule_name))	
	 	}
	}
	else
	{
		rule_name = document.getElementById("new_rule_id").value;
		if(!unique(rule_name))
		{
			error_code = error_code + 1;
			alert_msg = alert_msg + "Name is not unique\n";
		}
		if(rule_name=="Enter unique identifier")
		{
			alert_msg = alert_msg + "Name not set, Must modify text labeld as 'Enter unique identifier'\n";
			error_code = error_code + 1;
		}
	}
	
	//SET for submit
	//<input type="text" name="name" id="name" value=""/>
	//<input type="text" name="lbound_sensor" id="lbound_sensor" value=""/>  			ID 
	//<input type="text" name="duration" id="duration" value=""/>
	//<input type="text" name="lbound_formula" id="lbound_formula" value=""/>
	//<input type="text" name="rbound_formula" id="rbound_formula" value=""/>
	//<input type="text" name="definition" id="definition" value=""/>
	//<input type="text" name="premise_formula" id="premise_formula" value=""/>
	//<input type="text" name="boolean_formula" id="boolean_formula" value=""/>
	//<input type="text" name="rbound_sensor" id="rbound_sensor"/>		 			Share boolean
	
	document.getElementById("name").value = rule_name.toLowerCase();
	document.getElementById("lbound_sensor").value = "";   //ID
	x=document.getElementById("rule_dur").selectedIndex;
	//y=document.getElementById("rul_dur").options;
	//idx = y[x].index;
	if(x==0)
	{
		alert_msg = alert_msg + "Must set a 'Rule Duration' from drop down list.\n";
		error_code=error_code+1;
	}
	document.getElementById("duration").value = x;
	document.getElementById("lbound_formula").value = document.getElementById("left_formula").value;
	document.getElementById("rbound_formula").value = document.getElementById("right_formula").value;
	x=document.getElementById("rule_def").selectedIndex;
	//TODO if formula fields are empty based on scope type
	//y=document.getElementById("rul_def").options;
	//idx = y[x].index;
	if(x==0)
	{
		alert_msg = alert_msg + "Must set a 'Rule Definition' from drop down list.\n";
		error_code=error_code+1;
	}
	document.getElementById("definition").value = x;
	document.getElementById("premise_formula").value = document.getElementById("prem_formula").value;
	
	bool = document.getElementById("bool_formula").value;
	if(bool == null || bool == "")
	{
		alert_msg = alert_msg + "Must set a 'Boolean formula'.";
		error_code = error_code + 1;
	}
	document.getElementById("boolean_formula").value = bool;
	document.getElementById("rbound_sensor").value = document.getElementById("share_box").checked;   //boolean share

	document.getElementById("dnl").value = document.getElementById("NLD").value;   //boolean share

	//LOGIC FOR ERROR!!!
	if(error_code > 0)
	{
		alert(alert_msg);
		return false;
	}
	return true;
}

function unique(name)
{
	rules = get_rule(-1);
	for (var i=1 ; i < rules.length; i++)
		if(rules[i][0]==name)
			return false;
	return true;

}

// PHP should fill all this data for all rules avalible to the current logged on user!  

//<input type="text" name="name" id="name" value=""/>
//<input type="text" name="lbound_sensor" id="lbound_sensor" value=""/>  			<!-- ID -->
//<input type="text" name="duration" id="duration" value=""/>
//<input type="text" name="lbound_formula" id="lbound_formula" value=""/>
//<input type="text" name="rbound_formula" id="rbound_formula" value=""/>
//<input type="text" name="definition" id="definition" value=""/>
//<input type="text" name="premise_formula" id="premise_formula" value=""/>
//<input type="text" name="boolean_formula" id="boolean_formula" value=""/>
//<input type="text" name="rbound_sensor" id="rbound_sensor"/>		 	<!-- Share boolean -->

function get_rule(index)
{
	//this is a cheap way to hold all the rule data
	var rules = new Array();
	rules[0] = null;

<?php
	//get rules for this user
	echo $rules;

?>

	//test data ::  (since TOMCAT is OFF)
	rules[1] = ["r1", "", 1, null, null, 1, null, "s10.humidity@%>60", true];
	rules[2] = ["r2", "", 2, "s10.humidity@%>60", null, 2, null, "s10.humidity@%>60", false];
	rules[3] = ["r3", "", 3, null, "s10.humidity@%>60", 3, null, "s10.temperature@%>60", true];
	rules[4] = ["r4", "", 4, "s10.humidity@%>60", "s10.humidity@%>80", 4, "s11.humidity@%>60", "s4.temperature@%>60", true];
	rules[5] = ["r5", "", 1, null, null, 4, "s10.humidity@%>60", "s10.humidity@%>60", true];
	rules[6] = ["r6", "", 2, "s10.humidity@%>60", null, 3, null, "s10.humidity@%>60", false];
	rules[7] = ["r7", "", 3, null, "s10.humidity@%>60", 2, null, "s10.humidity@%>60", false];
	rules[8] = ["r8", "", 4, "s10.humidity@%>60", "s10.humidity@%>60", 1, null, "s10.humidity@%>60", true];
	 
	if(index < 0 )
		return rules;
	return rules[index];
}
function get_natural_language()
{
	scope1 	= document.getElementById("left_formula").value;
	scope2 	= document.getElementById("right_formula").value;
	premise = document.getElementById("prem_formula").value;
	bool 	= document.getElementById("bool_formula").value;

	if(scope1 == null || scope1 == "")
		scope1 = "<set left boundry sub formula>";	
	if(scope2 == null || scope2 == "")
		scope2 = "<set right boundry sub formula>";		
	if(premise == null || premise == "")
		premise = "<set premise sub formula>";	
	if(bool == null || bool == "")
		bool = "<set boolean sub formula>";	

	dur = document.getElementById("rule_dur").selectedIndex;
	if(dur == 0)
		nld = "<set rule duration> ";
	else if(dur == 1)
		nld = "For all readings ";
	else if(dur == 2) //after L
		nld = "For all readings after the statement " + scope1 + " becomes true, ";
	else if(dur == 3) //before R
		nld = "For all readings before the statement " + scope2 + " becomes true, ";
	else if(dur == 4)
		nld = "For each interval of readings after which the statement " + scope1 + " becomes true and until the statement " + scope2 + " first becomes true, "; 
	else if(dur == 5) //doesnt go that hi
		nld = "For each interval of readings after which the statement " + scope1 + " becomes true and until the statement " + scope2 + " first becomes true, or until the end of the readings if " + scope2 + " does not become true, "; //SRS says '.' but should be ','

	def = document.getElementById("rule_def").selectedIndex;
	if(def == 0)
		nld = nld + "<set rule definition> ";
	else if(def == 1)
		nld = nld + "it is always the case that the statement " + bool + " is true within the duration.";
	else if(def == 2)
		nld = nld + "it is never the case that the statement " + bool + " is true within the duration.";
	else if(def == 3)
		nld = nld + "there is at least one reading in which the statement " + bool + " is true within the duration.";
	else if(def == 4)
		nld = nld + "every reading where the statement " + premise + "is true within the duration, is followed immedietly by a reading where the statement " + bool + " is true within the duration.";

	document.getElementById("NLD").value = nld;
}

// php should fill all this data for all sensors avalible to the current logged on user!
function get_sensor(index)
{
	//this is a cheap way to hold all sensors
	          //id,  serial#, 'city, state', lat d:m:s,   lon d:m:s, accuracy
	var sensors = new Array();
	sensors[0]   = null;

	<?php 
	//get sensors
	echo $sensors
	?>
	
	//sensor test data::  (since TOMCAT is OFF)
	sensors[1]   = ["s1" , "0001", "New York, NY",     "101:23:12", "42:52:23", "10%", ["time","24h:mm:ss"], ["temperature","F"], ["temperature","C"]];
	sensors[2]   = ["s2" , "0002", "Denver, CO",       "130:54:23", "38:34:22", "10%", ["time","24h:mm:ss"], ["temperature","F"], ["humidity","%"]];
	sensors[3]   = ["s3" , "0003", "Phoenix, AZ",      "135:35:02", "33:23:31", "10%", ["time","24h:mm:ss"], ["temperature","F"], ["rain","mm"], ["light","lux"]];
	sensors[4]   = ["s4" , "0004", "Dallas, TX",       "112:43:15", "30:53:13", "10%", ["time","24h:mm:ss"], ["temperature","F"], ["wind","m/s"]];
	sensors[5]   = ["s5" , "0005", "Detriot, MI",      "142:44:43", "51:34:32", "10%", ["time","24h:mm:ss"], ["temperature","F"]];
	sensors[6]   = ["s6" , "0006", "El Paso, TX",      "101:31:21", "42:35:21", "10%", ["time","24h:mm:ss"], ["light","lux"]];
	sensors[7]   = ["s7" , "0007", "El Paso, TX",      "101:35:23", "42:43:51", "10%", ["time","24h:mm:ss"], ["rain","mm"]];
	sensors[8]   = ["s8" , "0008", "El Paso, TX",      "101:32:43", "42:35:23", "10%", ["time","24h:mm:ss"], ["temperature","F"]];
	sensors[9]   = ["s9" , "0009", "El Paso, TX",      "101:12:13", "42:43:35", "10%", ["time","24h:mm:ss"], ["wind","m/s"]];	
	sensors[10]  = ["s10", "0010", "El Paso, TX",      "101:03:32", "42:13:53", "10%", ["time","24h:mm:ss"], ["humidity","%"]];
	sensors[11]  = ["s11", "0011", "Horizon City, TX", "101:03:33", "42:53:13", "10%", ["time","24h:mm:ss"], ["temperature","C"], ["humidity","%"]];

	if(index < 0)
		return sensors;
	return sensors[index];
}
function sensor_selection(prefix)
{
	var x=document.getElementById(prefix+"_sel").selectedIndex;
	//var y=document.getElementById(prefix+"_sel").options;

	//idx = y[x].index;
	sensor = get_sensor(x); 

	document.getElementById(prefix+"_field1").value = "";
	document.getElementById(prefix+"_field2").value = "";
	document.getElementById(prefix+"_field3").value = "";
	document.getElementById(prefix+"_field4").value = "";

	document.getElementById(prefix+"_field1").disabled = true;
	document.getElementById(prefix+"_field2").disabled = true;
	document.getElementById(prefix+"_field3").disabled = true;
	document.getElementById(prefix+"_field4").disabled = true;

	document.getElementById(prefix+"_field1").hidden = true;
	document.getElementById(prefix+"_field2").hidden = true;
	document.getElementById(prefix+"_field3").hidden = true;
	document.getElementById(prefix+"_field4").hidden = true;
	
	if(sensor!=null)
	{
		if(sensor[7]!=null)
		{	
			document.getElementById(prefix+"_field1").value = sensor[7][0] + '@' + sensor[7][1];
			document.getElementById(prefix+"_field1").disabled = false;
			document.getElementById(prefix+"_field1").hidden = false;
		}
		if(sensor[8]!=null)
		{	
			document.getElementById(prefix+"_field2").value = sensor[8][0] + '@' + sensor[8][1];
			document.getElementById(prefix+"_field2").disabled = false;
			document.getElementById(prefix+"_field2").hidden = false;

		}
		if(sensor[9]!=null)
		{	
			document.getElementById(prefix+"_field3").value = sensor[9][0] + '@' + sensor[9][1];
			document.getElementById(prefix+"_field3").disabled = false;
			document.getElementById(prefix+"_field3").hidden = false;

		}
		if(sensor[10]!=null)
		{	
			document.getElementById(prefix+"_field4").value = sensor[10][0] + '@' + sensor[10][1];
			document.getElementById(prefix+"_field4").disabled = false;
			document.getElementById(prefix+"_field4").hidden = false;

		}
	}
	else
	{
		document.getElementById(prefix+"_field1").value = "field1";
		document.getElementById(prefix+"_field2").value = "field2";
		document.getElementById(prefix+"_field3").value = "field3";
		document.getElementById(prefix+"_field4").value = "field4";
	
		document.getElementById(prefix+"_field1").hidden = false;
		document.getElementById(prefix+"_field2").hidden = false;
		document.getElementById(prefix+"_field3").hidden = false;
		document.getElementById(prefix+"_field4").hidden = false;


	}
}
function insert_field(prefix, field_index)
{
	var x=document.getElementById(prefix+'_sel').selectedIndex;
	//var y=document.getElementById(prefix+'_sel').options;

	//sensor_index = y[x].index;
	sensor = get_sensor(x);
	
	text=sensor[0]+'.'+sensor[6+field_index][0]+'@'+sensor[6+field_index][1];
	
	insert(prefix, text);
}
function insert(prefix, text)
{
	formula = document.getElementById(prefix+"_formula").value;
	formula = formula + text;
	document.getElementById(prefix+"_formula").value = formula;
}
function pop_rules(select_name)
{
	rules = get_rule(-1);
	for (var i=0 ;i < rules.length; i++)
	{
		var x=document.getElementById(select_name);
		var option=document.createElement("option");
		if(i==0)
		{	option.text="Select rule identifier";}
		else
		{	
			element_name=(rules[i][0]);
			option.text=element_name;
		}	
		try	
  		{
		  // for IE earlier than version 8
		  x.add(option,x.options[null]);
		}
		catch (e)
		{
		  x.add(option,null);
		}
	}
}
function pop_sensors(select_name)
{
	sensors = get_sensor(-1);
	for (var i=0 ;i < sensors.length; i++)
	{
		var x=document.getElementById(select_name);
		var option=document.createElement("option");
		if(i==0)
		{	option.text="Select Sensor";}
		else
		{	
			element_name=(sensors[i][0] + ' ' + sensors[i][3]);
			option.text=element_name;
		}	
		try	
  		{
		  // for IE earlier than version 8
		  x.add(option,x.options[null]);
		}
		catch (e)
		{
		  x.add(option,null);
		}
	}
}
function load_rule(elem)
{
	var x=document.getElementById(elem).selectedIndex;
	//var y=document.getElementById(elem).options;

	//idx = y[x].index;

	if(x>0)
	{
		rule = get_rule(x); 
		document.getElementById("rule_dur").selectedIndex  = rule[2];
			disable_section('rule_dur', 'left'); 
			disable_section('rule_dur', 'right');
		document.getElementById("rule_def").selectedIndex  = rule[5];
			disable_section('rule_def', 'prem');
		document.getElementById("left_formula").value      = rule[3];
		document.getElementById("right_formula").value     = rule[4];
		document.getElementById("prem_formula").value      = rule[6];
		document.getElementById("bool_formula").value      = rule[7];
		document.getElementById("share_box").checked       = rule[8];
	}
	else
	{
		document.getElementById("rule_dur").selectedIndex  = 0;
		document.getElementById("rule_def").selectedIndex  = 0;
		document.getElementById("left_formula").value      = "";
		document.getElementById("right_formula").value     = "";
		document.getElementById("prem_formula").value      = "";
		document.getElementById("bool_formula").value      = "";
		document.getElementById("share_box").checked       = false;
	}	
}
</script>
<!-- end page logic -->

	<div class="container">
	<p>
		<h4>Sample Rule Page: This page provides the ability to create a 'rule' or constraint. </h4>
		This page conforms to the layout specified in the Software Requirements Specification Document for the project.<br/>
		You may choose to view existing rules, and modify them.<br/>
		You may choose to create a rule from scratch by selecting a 'Rule Duration' & 'Rule Definition'
		and the sensors you would like the rule to apply to.<br/>
		This is a sample until I can host the whole project on a tomcat server, so data is hard coded.<br/>
		Please use this as a very simple example of javascript form interaction. Thank you.
	</p>	
<hr>


<table border="0">
<tr>
<!-- <td></td> -->
<td colspan="1">New Rule</td>
<td></td>
<!-- <td></td> -->
<td colspan="1">Existing Rule</td>
</tr>
<tr>
<!-- <td><input type="radio" name="new_rule" value="1"/></td>        infered requierment -->
<td><input type="text" id="new_rule_id" name="new_rule_id" onclick="this.select()" value="Enter unique identifier" size="50" onchange="lower_case('new_rule_id')"/></td>
<td></td>
<!-- <td><input type="radio" name="existing_rule" value="2"/></td>   infered requierment -->


<td><select id="existing_rule" onchange="load_rule('existing_rule'); get_natural_language();">
       </select>
</td>
<td></td>
</tr>

</table>

<hr/>

<table border= "0">
<tr>
<td colspan="8">Natural Language Description</td>
</tr>

<tr>
 <td colspan="8">
 	<textarea rows="3" id="NLD" name="NLD" disabled="disabled"  cols="148">
 	</textarea>
 </td>
</tr>

<tr>
 <td colspan="4">RULE DURATION</td>
 <td colspan="4">RULE DEFINITION</td>
</tr>

<tr>
 <td colspan="4">     
       <select id="rule_dur" onchange="disable_section('rule_dur', 'left'); disable_section('rule_dur', 'right'); get_natural_language()">
        <option value="null">Select a Duration</option>
        <option value="global">All readings</option>
        <option value="before_r">All Readings After L</option>
        <option value="after_l">All readings Before R</option>
        <option value="between">All Readings Between L and R</option>
        <option value="until">All Readings After L Until R</option>  <!-- not specified in SRS--> 
       </select>
  </td>
 <td colspan="4">     
	<select id="rule_def" onchange="disable_section('rule_def', 'prem'); get_natural_language()">
         <option value="null">Select Rule Definition</option>
         <option value="u">Universality</option>
         <option value="a">Absense</option>
         <option value="e">Existence</option>
         <option value="r">Response</option>
       </select>
  </td>
</tr>

</table>

<br/>

<table border="1">

<tr><td>

<table border="0" style="position:relative;width:100%;">
<tr>
<td colspan="12">Left Boundry</td>
</tr>
<tr>
  <td colspan="12">
     <select id="left_sel" onchange="sensor_selection('left')" disabled="disabled" >
     </select>
  </td>
</tr>
<tr>
  <td colspan="3"><input type="button" id="left_field1" name="field1" value="field1" disabled="disabled"  onclick="insert_field('left', 1); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="left_field2" name="field2" value="field2" disabled="disabled"  onclick="insert_field('left', 2); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="left_field3" name="field3" value="field3" disabled="disabled"  onclick="insert_field('left', 3); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="left_field4" name="field4" value="field4" disabled="disabled"  onclick="insert_field('left', 4); get_natural_language()"/></td>
</tr>
<tr>
  <td> <button type="button" id="left_butt_1" onclick="insert('left', '='); get_natural_language()" disabled="disabled" >=</button></td>
  <td> <button type="button" id="left_butt_2" onclick="insert('left', '!='); get_natural_language()" disabled="disabled" >&ne;</button></td>
  <td> <button type="button" id="left_butt_3" onclick="insert('left', '<'); get_natural_language()" disabled="disabled" >&lt;</button></td>
  <td> <button type="button" id="left_butt_4" onclick="insert('left', '>'); get_natural_language()" disabled="disabled" >&gt;</button></td>
  <td> <button type="button" id="left_butt_5" onclick="insert('left', '>='); get_natural_language()" disabled="disabled" >&ge;</button></td>
  <td> <button type="button" id="left_butt_6" onclick="insert('left', '<='); get_natural_language()" disabled="disabled" >&le;</button></td>
  <td> <button type="button" id="left_butt_7" onclick="insert('left', 'OR'); get_natural_language()" disabled="disabled" >OR</button></td>
  <td> <button type="button" id="left_butt_8" onclick="insert('left', 'AND'); get_natural_language()" disabled="disabled" >AND</button></td>
  <td> <button type="button" id="left_butt_9" onclick="insert('left', 'NOT'); get_natural_language()" disabled="disabled" >NOT</button></td>
</tr>
<tr><td colspan="12">Left Boundary Sub-formula</td></tr>
<tr>
  <td colspan="12">
       <input type="text" id="left_formula" name="left_formula" size="70" onchange="get_natural_language()" disabled="disabled" />
   </td>
</tr>
</table>
</td>

<td>
<table border="0">
<tr>
<td colspan="12">Right Boundry</td>
</tr>
<tr>
  <td colspan="12">
     <select id="right_sel" onchange="sensor_selection('right')" disabled="disabled" >
     </select>
  </td>
</tr>
<tr>
  <td colspan="3"><input type="button" id="right_field1" name="field1" value="field1" disabled="disabled"  onclick="insert_field('right', 1); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="right_field2" name="field2" value="field2" disabled="disabled"  onclick="insert_field('right', 2); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="right_field3" name="field3" value="field3" disabled="disabled"  onclick="insert_field('right', 3); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="right_field4" name="field4" value="field4" disabled="disabled"  onclick="insert_field('right', 4); get_natural_language()"/></td>
</tr>
<tr>
  <td> <button type="button" id="right_butt_1" onclick="insert('right', '='); get_natural_language()" disabled="disabled" >=</button></td>
  <td> <button type="button" id="right_butt_2" onclick="insert('right', '!='); get_natural_language()" disabled="disabled" >&ne;</button></td>
  <td> <button type="button" id="right_butt_3" onclick="insert('right', '<'); get_natural_language()" disabled="disabled" >&lt;</button></td>
  <td> <button type="button" id="right_butt_4" onclick="insert('right', '>'); get_natural_language()" disabled="disabled" >&gt;</button></td>
  <td> <button type="button" id="right_butt_5" onclick="insert('right', '>='); get_natural_language()" disabled="disabled" >&ge;</button></td>
  <td> <button type="button" id="right_butt_6" onclick="insert('right', '<='); get_natural_language()" disabled="disabled" >&le;</button></td>
  <td> <button type="button" id="right_butt_7" onclick="insert('right', 'OR'); get_natural_language()" disabled="disabled" >OR</button></td>
  <td> <button type="button" id="right_butt_8" onclick="insert('right', 'AND'); get_natural_language()" disabled="disabled" >AND</button></td>
  <td> <button type="button" id="right_butt_9" onclick="insert('right', 'NOT'); get_natural_language()" disabled="disabled" >NOT</button></td>
</tr>
<tr><td colspan="12">Right Boundary Sub-formula</td></tr>
<tr>
  <td colspan="12">
       <input type="text" id="right_formula" name="right_formula" size="70" onchange="get_natural_language()" disabled="disabled" />
   </td>
</tr>
</table>
</td>

</tr>
<tr>
<td><table border="0">
<tr>
<td colspan="12">Premise:</td>
</tr>
<tr>
  <td colspan="12">
     <select id="prem_sel" onchange="sensor_selection('prem')" disabled="disabled" >
     </select>
  </td>
</tr>
<tr>
  <td colspan="3"><input type="button" id="prem_field1" name="field1" value="field1" disabled="disabled"  onclick="insert_field('prem', 1); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="prem_field2" name="field2" value="field2" disabled="disabled"  onclick="insert_field('prem', 2); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="prem_field3" name="field3" value="field3" disabled="disabled"  onclick="insert_field('prem', 3); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="prem_field4" name="field4" value="field4" disabled="disabled"  onclick="insert_field('prem', 4); get_natural_language()"/></td>
</tr>
<tr>
  <td> <button type="button" id="prem_butt_1" onclick="insert('prem', '='); get_natural_language()" disabled="disabled" >=</button></td>
  <td> <button type="button" id="prem_butt_2" onclick="insert('prem', '!='); get_natural_language()" disabled="disabled" >&ne;</button></td>
  <td> <button type="button" id="prem_butt_3" onclick="insert('prem', '<'); get_natural_language()" disabled="disabled" >&lt;</button></td>
  <td> <button type="button" id="prem_butt_4" onclick="insert('prem', '>'); get_natural_language()" disabled="disabled" >&gt;</button></td>
  <td> <button type="button" id="prem_butt_5" onclick="insert('prem', '>='); get_natural_language()" disabled="disabled" >&ge;</button></td>
  <td> <button type="button" id="prem_butt_6" onclick="insert('prem', '<='); get_natural_language()" disabled="disabled" >&le;</button></td>
  <td> <button type="button" id="prem_butt_7" onclick="insert('prem', 'OR'); get_natural_language()" disabled="disabled" >OR</button></td>
  <td> <button type="button" id="prem_butt_8" onclick="insert('prem', 'AND'); get_natural_language()" disabled="disabled" >AND</button></td>
  <td> <button type="button" id="prem_butt_9" onclick="insert('prem', 'NOT'); get_natural_language()" disabled="disabled" >NOT</button></td>
</tr>
<tr><td colspan="12">Premise Sub-formula</td></tr>
<tr>
  <td colspan="12">
       <input type="text" id="prem_formula" name="prem_formula" size="70" onchange="get_natural_language()" disabled="disabled" />
   </td>
</tr>
</table></td>
<td><table border="0">
<tr>
<td colspan="12">Boolean Statement</td>
</tr>
<tr>
  <td colspan="12">
     <select id="bool_sel" onchange="sensor_selection('bool')">
     </select>
  </td>
</tr>
<tr>
  <td colspan="3"><input type="button" id="bool_field1" name="field1" value="field1" onclick="insert_field('bool', 1); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="bool_field2" name="field2" value="field2" onclick="insert_field('bool', 2); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="bool_field3" name="field3" value="field3" onclick="insert_field('bool', 3); get_natural_language()"/></td>
  <td colspan="3"><input type="button" id="bool_field4" name="field4" value="field4" onclick="insert_field('bool', 4); get_natural_language()"/></td>
</tr>
<tr>
  <td> <button type="button" id="bool_butt_1" onclick="insert('bool', '='); get_natural_language()">=</button></td>
  <td> <button type="button" id="bool_butt_2" onclick="insert('bool', '!='); get_natural_language()">&ne;</button></td>
  <td> <button type="button" id="bool_butt_3" onclick="insert('bool', '<'); get_natural_language()">&lt;</button></td>
  <td> <button type="button" id="bool_butt_4" onclick="insert('bool', '>'); get_natural_language()">&gt;</button></td>
  <td> <button type="button" id="bool_butt_5" onclick="insert('bool', '>='); get_natural_language()">&ge;</button></td>
  <td> <button type="button" id="bool_butt_6" onclick="insert('bool', '<='); get_natural_language()">&le;</button></td>
  <td> <button type="button" id="bool_butt_7" onclick="insert('bool', 'OR'); get_natural_language()">OR</button></td>
  <td> <button type="button" id="bool_butt_8" onclick="insert('bool', 'AND'); get_natural_language()">AND</button></td>
  <td> <button type="button" id="bool_butt_9" onclick="insert('bool', 'NOT'); get_natural_language()">NOT</button></td>
</tr>
<tr><td colspan="12">Boolean Statement Sub-formula</td></tr>
<tr>
  <td colspan="12">
       <input type="text" id="bool_formula" name="bool_formula" size="70" onchange="get_natural_language()"/>
   </td>
</tr>
</table></td>
</tr>
</table>



<div align="center">

<p><input type="checkbox" id="share_box"/>Share the rule</p>  <!-- infered req, how can you un-set a radio button -->

<form action="rule.php" onsubmit="return check_submit()" method="post"> 

<input type="hidden" name="name" id="name" value=""/>
<input type="hidden" name="lbound_sensor" id="lbound_sensor" value=""/>  			<!-- ID -->
<input type="hidden" name="duration" id="duration" value=""/>
<input type="hidden" name="dnl" id="dnl" value=""/>
<input type="hidden" name="lbound_formula" id="lbound_formula" value=""/>
<input type="hidden" name="rbound_formula" id="rbound_formula" value=""/>
<input type="hidden" name="definition" id="definition" value=""/>
<input type="hidden" name="premise_formula" id="premise_formula" value=""/>
<input type="hidden" name="boolean_formula" id="boolean_formula" value=""/>
<input type="hidden" name="rbound_sensor" id="rbound_sensor"/>		 	<!-- Share boolean -->
<input type="hidden" name="overwrite" id="overwrite" value="FALSE"/>

<p><input type="submit" value="Submit"/></p>

</form>

</div>
<br/><br/>
<hr>
<?php include("./footer.inc")?>
