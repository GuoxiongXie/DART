<?php
session_start();
include_once 'include/conn.php';

//verify that only manager can access this feature

$role = $_SESSION['authority'];
if ($role != "manager"){
	echo "<script language='javascript'>alert('Sorry but you have to be a manager to add a stakeholder.');</script>";
	echo "<script language='javascript'>window.location.href='setup.html';</script>";
}
?>

<script language="javascript">
/*Function:focus on the blank and alert the user to input the necessaries.
*/
function check(form)
{
	if(form.name.value=="")
	{
		alert("Please input a name for the stakeholder");
		form.name.focus();
		return false;
	}
	if(form.pw.value=="")
	{
		alert("Please input a password for the stakeholder");
		form.pw.focus();
		return false;
	}
	if (form.Stakeholder.value=="") {
		alert("Please select a role for the stakeholder");
		form.Stakeholder.focus();
		return false;
	}
	
	form.submit();
}
</script>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Stakeholder</title>
<link rel="shortcut icon" href="favicon.ico" />
<!-- Load CSS -->
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!-- Load Fonts -->
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic" type="text/css" />
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold" type="text/css" />
<!-- Load jQuery library -->
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<!-- Load custom js -->
<script type="text/javascript" src="scripts/panelslide.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
<!-- Load topcontrol js -->
<script type="text/javascript" src="scripts/scrolltopcontrol.js"></script>
<!-- Load NIVO Slider -->
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-theme.css" type="text/css" media="screen" />
<script src="scripts/jquery.nivo.slider.pack.js" type="text/javascript"></script>
<script src="scripts/nivo-options.js" type="text/javascript"></script>
<!-- Load fancybox -->
<script type="text/javascript" src="scripts/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="scripts/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="scripts/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" href="css/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<!-- Load contact check -->
<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('We are sorry, but there is an error:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
</script>
</head>
<body>
<!--This is the START of the header-->
<div id="topcontrol" style="position: fixed; bottom: 5px; left: 960px; opacity: 1; cursor: pointer;" title="Go to Top"></div>
<div id="header-wrapper">
  <div id="header">
    <div id="header-text">
      <h4>DISTRIBUTED ASSESSMENT OF RISKS TOOL(DART)</h4>
    </div>
  </div>
</div>
<!--END of header-->
<!--This is the START of the menu-->
<div id="menu-wrapper">
  <div id="main-menu">
    <ul>
      <li><a href="about.html">About</a></li>
      <li><a  class="selected" href="setup.html">Project →</a></li>
      <li><a href="blog.html">Risk Assessment</a></li>
      <li><a href="contact.html">Close Voting Period</a></li>
      <li><a href="features.html">View Results</a></li>
    </ul>
  </div>
	<!--This is the START of the footer-->

	<!--END of footer-->
</div>
<!--END of menu-->
<!--This is the START of the content-->
<div id="content" style="width:1200px">
  
  
  
  
  <!--This is the START of the contact section-->
  <div id="contact" style="float:left;">
    <h5 style="margin-top:0px;">Add Stakeholder</h5>
   
    <form method="post" action="addstakeholder.php" name="add_stakeholder_form" id="contactform">
      <div class="boxes">
            
            <h5>Enter new stakeholder info.</h5><br></br>

               
      	<div>
			
			<h6>Name:&nbsp  </h6> <div class="box">
       	   	<input name="name" type="text"  class="input" id="sender_name" title="name" value="" maxlength="2048"/></div>
       	   	
       	   	<h6>Password:&nbsp  </h6> <div class="box">
       	   	<input name="pw" type="password"  class="input" id="sender_pw" title="Pw" value="" maxlength="2048"/></div>

       		<h6>Role:&nbsp </h6>
        	<select name="Stakeholder" size="1">
        	<option value=""></option>	
			<option value="sm">Manager </option>
			<option value="sn">Regular user </option>
			
			</select>
			
			
        	<div class="submitbtn">
            <input type="submit" name='Add Stakeholder' class="button btncolor" onclick="return check(add_stakeholder_form);" value="Add Stakeholder" />
        	</div>
        </div>
        
        
	</div>
    </form>
    	
        

    
  </div>
  <!--END of contact section-->
  
    <div id="contact" style="float:left;text-align:center;">
  	<h5 style="margin-top:0px;">Existing Stakeholders</h5><br>
  	<?php
  		$managerName = $_SESSION['username'];	//get the name of manager, this managerName can actually be username too
		$findProjQuery = "SELECT project FROM ProjMem WHERE member='".$managerName."'";
		$strangeProjName = $conn->Execute($findProjQuery) or die($conn->errrorMsg()); //debug: the output is actually "project sth".
		$projName = trim(substr($strangeProjName, 8)); //get the actual input name, trim removes all the whitespaces in the front and at the end
		$findMgrQuery = "SELECT ProjMem.member AS member FROM ProjMem, Manager WHERE ProjMem.project='".$projName."' AND Manager.name=ProjMem.member";
		$rst1 = $conn->Execute($findMgrQuery) or die($conn->errorMsg());
		echo "Manager:<br>";
		while (!$rst1->EOF) {
			echo $rst1->fields['member'];
			echo "<br>";
			$rst1->movenext();
		}
		echo "<br>";
		$findUserQuery = "SELECT ProjMem.member AS member FROM ProjMem, RegularUser WHERE ProjMem.project='".$projName."' AND RegularUser.name=ProjMem.member";
		$rst1 = $conn->Execute($findUserQuery) or die($conn->errorMsg());
		echo "Regular User:<br>";
		while (!$rst1->EOF) {
			echo $rst1->fields['member'];
			echo "<br>";
			$rst1->movenext();
		}
		echo "<br>";

  	?>
  	
  </div>
  <div style="clear:both;"></div>
  
</div>
<!--END of content-->
<p class="slide"><a href="#" class="btn-slide"></a></p>
<div id="slide-panel">
	<!--This is the START of the follow section-->
	<div id="follow">
		<a href="TAsignin.html">
		<div id="follow-setup"><img src="images/setup.jpg" />
			<h4>TA Signin</h4>
		</div>
		</a>
		<a href="login.html">	
		<div id="follow-login"><img src="images/login.png" />
			<h4>Login</h4>
		</div>
		</a>
		
		<form method="post" action="logout.php">
		<div id="follow-mail"><input type="image" src="images/logout.png" alt="Submit" name='Logout' value='Logout' />
		<!--<div id="follow-mail"><img src="images/logout.png" /> -->
			<h4>Logout</h4>
		</div>
		</form>
		
		<!--
		<a href="about.html">
		<div id="follow-mail"><img src="images/logout.png" />
			<h4>Logout</h4>
		</div>
		</a>
		-->
		
		<h1>Thanks for visiting!</h1>
	</div>
	<!--END of follow section-->
</div>
</body>
</html>