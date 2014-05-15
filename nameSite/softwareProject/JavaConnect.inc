<?php

//just tell what java servlet you want to talk to
//usage: setBridge("/Java_Bridge/GUIProfile", "Login", $_SESSION['EMAIL'], "FALSE");
$showDebugs="";
function startsWith($haystack, $needle)
{
	return !strncmp($haystack, $needle, strlen($needle));
}
function setBridge($javaClass, $pageName=null, $sessionVar="", $mustVerify=true)
{
	$debug = true;
	
	//settings..
	//IF 	 this file is on uteps server, it will call java from uteps server. (only way it will work).
	
	//ELSE 	 this file is on your computer, you have (2) options:
	$option=1;	 //(1)=call java hosted from your localhost tomcat server
	//or
	//$option=2; //(2)=call java files from utep server
	
	$utepTomcatServerDir ="D:\\inetpub\\wwwroot\\vhosts\\team2awesome";   //expected static location of this file if placed in utep server.
	$dir = dirname(__FILE__);	//current location
	
	if($option==1 && !(startsWith($dir,$utepTomcatServerDir)))
	{	//(1)=call java files from utep server
		$javaHost = "localhost:8080";
	}
	else//(2)=call java files from utep server
		$javaHost = "129.108.19.91:8080";
	
	define("JAVA_HOSTS", $javaHost);  //"localhost:8080"
	define("JAVA_SERVLET", $javaClass);  //defines the servlet you will use in this page (.java)
	//require_once("Java.inc");
	
	if($debug)
	{
		$phpDebugOutput="---------------------start php debug---------------------<br/>\n".
				"<b>PHP: ".$dir."</b><br/>\n".
				"<b>JAVA: ".$javaHost."</b><br/>\n".
				"---------------------start php debug---------------------<br/>\n";
	}
	else
		$phpDebugOutput="";
	
	if($pageName!=null)
	{
		getHeader($pageName, $sessionVar, $mustVerify, $phpDebugOutput);
	}
	return $phpDebugOutput;
}
function getHeader($pageName, $sessionVar, $mustVerify, $phpDebugOutput)
{
	//$valiationOutput[0] = java_context()->getServlet()->validate($sessionVar);

	$valiationOutput[0] = "TRUE";
	$valiationOutput[1] = "";

	if($valiationOutput[0]=="FALSE")
	{
		if($mustVerify)
		{	//not allowed to be here
			header("Location: ../side/session_jump_error.php");
			exit;
		}
		elseif(!empty($_SESSION['ID']) && $pageName!="Error") //TODO
		{	//stale session..  tell user why..?
			
			$bootReason="TRUE";
			//echo "not logged in destroying session<br/>";
			session_destroy();
		}
	}
	elseif($valiationOutput[0]=="EXPIRED")
	{
		if($mustVerify)
		{
			header("Location: ../side/session_expired.php");
			exit;
		}
		else 
		{
			session_destroy();
		}
	}
	include("header.inc");
	if($valiationOutput[1]!="")
	{	
		$showDebugs="TRUE";
		echo $phpDebugOutput.$valiationOutput[1];
	}
	if($valiationOutput[0]=="TRUE")
	{
		include("menu.inc");
	}
	else 
	{
		include("loginmenu.inc");	
	}
}
?>
