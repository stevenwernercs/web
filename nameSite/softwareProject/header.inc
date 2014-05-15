<!DOCTYPE html>
<!-- saved from url=(0043)http://getbootstrap.com/examples/jumbotron/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Team2Awesome">
    <link rel="shortcut icon" href="senqual.ico">
    <script>
    function check_tel(id)
    {
    	number = document.getElementById(id).value;

    	if(number == "")
    		return true;

    	numArray = number.match(/\d/g);

    	number = numArray.join("");
    	
    	document.getElementById(id).value = number;
    	if(number.length!=10)
    	{
    		alert("Phone number must be 10 digits");
    		return false;
    	}
    	return true;
    	
    }
   	function check_email(id)
   	{
    	email = document.getElementById(id).value;
		
		var name   = email.split("@");
		
		if(name.length!=2 || name[0].length<=1)
		{
			alert("The e-mail address format is not valid. Please reenter.");
			return false;
		}
		var domain = name[1].split(".");
    	
    	if(domain.length<2 || domain[0].length<=1 || domain[1].length<=1)
    	{
			alert("The e-mail address format is not valid. Please reenter.");
			return false;
		}
   		return true;
   	}
    </script>
  
