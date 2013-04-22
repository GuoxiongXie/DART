<?php
session_start();
include_once "include/conn.php";

$role = $_SESSION['authority'];
$username = $_SESSION['username'];

if ($role != "admin") {
	$projectName = $_SESSION['project'];
	$projInfoQuery = "SELECT * FROM Project WHERE projectname='".$projectName."'";
	$rst = $conn->Execute($projInfoQuery) or die($conn->errorMsg());
	$lastAssessment = $rst->fields['lastAssessmentDate'];
	$closed = $rst->fields['closed'];
}

function ExportCSV() {
	$filename = "./csv/Results_".$projectName."_".$username.".csv";
	file_put_contents($filename, $GLOBALS['file'], LOCK_EX);
	return $filename;
}

?>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Results</title>
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
  	<div id="logo"><img src="images/usc.png" width="140" alt="logo" /></div>
    <div id="header-text">
      <h3 style="font-family:Georgia, Times, serif; color: white">Distributed Assessment of Risks Tool(DART)</h3>
    </div>
  </div>
</div>
<!--END of header-->
<!--This is the START of the menu-->
<div id="menu-wrapper">
  <div id="main-menu">
    <ul>
      <li><a class="selected" href="about.html">About</a></li>
      <li><a href="jumpProject.php">Project</a></li>
      <li><a href="jumpRiskAssessment.php">Risk Assessment</a></li>
      <li><a href="jumpCloseVotingPeriod.php">Close Voting Period</a></li>
      <li><a href="jumpViewResults.php">View Results</a></li>
    </ul>
  </div>
</div>
<!--END of menu-->
<!--This is the START of the content-->
<div id="content">
  <!--This is the START of the contact section-->
    
<h5 style="margin-top: 40px">View Result:
<?php
if ($role == "admin") {
	$query = "SELECT * FROM Project";
	$rst = $conn->Execute($query) or die($conn->errorMsg());
	if ($_GET['project'] == null) {
		$projectName = $rst->fields['projName'];
		$lastAssessment = $rst->fields['lastAssessmentDate'];
		$closed = $rst->fields['closed'];
	}
	else {
		$projectName = $_GET['project'];
		$projInfoQuery = "SELECT * FROM Project WHERE projectname='".$projectName."'";
		$rst = $conn->Execute($projInfoQuery) or die($conn->errorMsg());
		$lastAssessment = $rst->fields['lastAssessmentDate'];
		$closed = $rst->fields['closed'];
	}
	echo "<select name=\"projeSelect\" style=\"margin-left: 55px;\" onchange=\"location.href=ViewResults.php?project=this.options[this.selectedIndex].value;\" >";
	while (!$rst->EOF) {
		echo "<option value=\"$rst->fields['projName']\">$rst->fields['projName']</option>";
		$rst->movenext();
	}
	echo "</select>";
}
?>
</h5>
<h5 style="margin-top: 40px">Project Name:<font style="margin-left: 150px; color:#660000; "><?php echo $projectName; ?></font></h5>	
<h5 style="margin-top: 40px">Last Assessment:<font style="margin-left: 150px; color:#660000; "><?php echo $lastAssessmentDate; ?></font><button type="button" style="align:right;" onclick="location.href=<?php ExportCSV(); ?>">Export CSV</button></h5>        

<div>
<?php
if ($closed == 0) {
	echo "No Closed Voting Result Yet.";
}
else {
	echo "
	<table>
		<thead>
			<tr>
				<th rowspan=\"2\">Rank</th>
				<th rowspan=\"2\">Risk Item</th>
				<th colspan=\"2\">RE</th>
				<th colspan=\"2\">Average</th>
				<th rowspan=\"2\">Mitigation Strategy</th>
				<th rowspan=\"2\">Last Updated</th>
			</tr>
			<tr>
				<th>Last</th>
				<th>Last_1</th>
				<th>P(UO)</th>
				<th>L(UO)</th>
			</tr>
		</thead>";
	echo "<tbody>";
	$riskResultQuery = "SELECT * FROM ProjRiskDesc WHERE projname='".$projectName."'";
	$riskRst = $conn->Execute($riskResultQuery) or die($conn->errorMsg());
	$count = 1;
	$file = "Project Name: ".$projectName."\n";
	$file .= "Last Assessment: ".$lastAssessment."\n";
	$file .= "Rank, Risk Item, Last RE, Last 1 RE, Avg. P(UO), Avg. L(UO), Risk Mitigation Strategy, Last Updated\n";
	while (!$riskRst->EOF) {
		//echo the table
		echo "<tr><td>$count</td><td>".$riskRst->fields['riskName']."</td><td>".$riskRst->fields['lastRE']."</td><td>".$riskRst->fields['lastButOneRE']."</td><td>".$riskRst->fields['averagePUO']."</td><td>".$riskRst->fields['averageLUO']."</td><td>".$riskRst->fields['mitigation']."</td><td>".$riskRst->fields['mitigationUpdateTime']."</td></tr>";
		//save in the file
		$file .= $count.", ".$riskRst->fields['riskName'].", ".$riskRst->fields['lastRE'].", ".$riskRst->fields['lastButOneRE'].", ".$riskRst->fields['averagePUO'].", ".$riskRst->fields['averageLUO'].", \"".$riskRst->fields['mitigation']."\", ".$riskRst->fields['mitigationUpdateTime']."\n";
		$riskRst->movenext();
		$count++;
	}
	echo "</tbody>";
	echo "</table>";
}
?>
</div>  


    
  </div>
  <!--END of contact section--> 
</div>
<!--END of content-->
<p class="slide"><a href="#" class="btn-slide"></a></p>
<div id="slide-panel">
	<!--This is the START of the follow section-->
	<div id="follow">
		<a href="adminSignUp.html">
		<div id="follow-setup"><img src="images/setup.jpg" />
			<h4>TA Signup</h4>
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
		<h1>Thanks for that!</h1>
	</div>
	<!--END of follow section-->
</div>
</body>
</html>