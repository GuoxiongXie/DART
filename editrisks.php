<?php
include_once 'include/conn.php';
require_once "include/connect_to_mysql.php";	//the reason I include this is because $conn->execute() doesn't work

session_start();
$projName = "";
//$projDesc = "";
//$authority = $_SESSION['authority'];
//$projName = $_SESSION['project'];
	
function displayProjName() {
	global $projName;
	$projName = (string)$_SESSION['project'];	//$projName is of type object of no string casting
	//echo gettype($projName);
	//global $projDesc;
	echo $projName;
}
	
function riskSelect() {
	global $conn;
	$projName = $_SESSION['project'];
	$sql = "select * from ProjRiskDesc where projName = '$projName'";
		
	$rst = $conn->execute($sql);
	echo "<select name=\"name\" size=\"2\">";
	while (!$rst->EOF) {
		echo "<option value=\"".$rst->fields['riskName']."\">".$rst->fields['riskName']."</option>";
		$rst->movenext();
	}
	echo "</select>";
}
	
?>

<script language="javascript">
/*Function:focus on the blank and alert the user to input the necessaries.
*/
function check(form)
{
	if(form.risks.value=="")
	{
		alert("Please input the risk name");
		form.risks.focus();
		return false;
	}
	if(form.riskdesc.value=="")
	{
		alert("Please input the risk description");
		form.riskdesc.focus();
		return false;
	}
	form.submit();
}
</script>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Risks</title>
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
<div id="content">
  
  
  
  
  <!--This is the START of the contact section-->
  <div id="contact">
    <h3 style="margin-top:0px;">Edit Risks</h3>
    
    <h6>Project name:&nbsp</h6> <div class="box">
    <?php displayProjName() ?></div>
    
    <form method="post" action="deleteRisk.php" name="setup_form" id="contactform">
      <div class="boxes">
    	 <div class="spacer"></div>
      	<h5>Select a risk to delete.</h5><br></br>
        
      	<div>
       		<!--<h6>Project name:&nbsp</h6> <div class="box">
       	   	<input name="projectname" type="text"  class="input" id="sender_name" title="Projname" value="" maxlength="2048"/></div>
			-->
			
       		<h6>Risk Item:&nbsp </h6>
        	<?php
					riskSelect();
			?>
        
        	<div class="submitbtn">
            <input type="submit" name='Delete Risk' class="button btncolor" onclick="return check(setup_form);" value="Delete Risk" />
        	</div>
        </div>
      </form>
      
      
      
       
        <div class="spacer"></div>
        
        <h5>Update the mitigation plan for the selected risk.</h5><br></br>
        
        <form method="post" action="updateMitigationPlan.php" name="setup_form" id="contactform">
      	<div>
       		<h6>Risk Item:&nbsp </h6>
        	<?php
					riskSelect();
			?>
			<br></br>
			
			<h6>Mitigation Plan:</h6>
       		 <div class="msgbox">
        	  <textarea name="plan" class="message" id="cf_message" title="plan" value="" rows="50" cols="30" maxlength="2048"></textarea>
       	 	<!--size="30"-->
        	</div>
       	 
        	<div class="submitbtn">
            <input type="submit" name='Update Plan' class="button btncolor" onclick="return check(setup_form);" value="Update Plan" />
        	</div>
        </div>
        </form>
        
        
        <div class="spacer"></div>
        
            <h5>Modify the risk info shown below.</h5><br></br>
        
        <form method="post" action="editRiskDesc.php" name="update_description_form" id="contactform">
      	<div>
       		<h6>Risk Item:&nbsp </h6>
        	<?php
					riskSelect();
			?>
			<br></br>
			
			<h6>Risk Description:</h6>
       		 <div class="msgbox">
        	  <textarea name="riskdesc" class="message" id="cf_message" title="riskDescription" value="" rows="50" cols="30" maxlength="2048"></textarea>
       	 	<!--size="30"-->
        	</div>
       	 
        	<div class="submitbtn">
            <input type="submit" name='Edit Risk' class="button btncolor" onclick="return check(update_description_form);" value="Edit Risk" />
        	</div>
        </div>
        
        <div class="spacer"></div>

    	</form>
    	
        

    
  </div>
  <!--END of contact section-->
  
  
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