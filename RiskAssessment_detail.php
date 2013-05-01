<script language="javascript">
/*Function:focus on the blank and alert the user to input the necessaries.
*/
function check(form, counter)
{
	counter = counter - 1;	//3
	
	var input1;
	var input2;
	var id1;
	var id2;
	
	while (counter > 0) {
		id1 = counter+"+1"; //debug: single quote or double? 
		id2 = counter+"+2"; //debug: single quote or double? 
		
		input1before = document.getElementById(id1);
		input2before = document.getElementById(id2);
		
		input1 = document.getElementById(id1).value;
		input2 = document.getElementById(id2).value;
		
		if (input1=="" || input2=="" || input1==null || input2==null){	//debug: PUO and LUO are integers!! ""??
			alert("Please do not leave the boxes blank. If you wish to abstain, enter 0 for both PUO and LUO.");
			input1before.focus();
			return false;
		}
		else if ( (input1==0 && input2!=0) || (input1!=0 && input2==0) ){
			alert("If you wish to abstain, please enter 0 for both PUO and LUO.");
			input1before.focus();
			return false;
		}
		else if (input1>10 || input1<0 || input2>10 || input2<0){
			alert("Values for PUO and LUO should be 0~10. Enter 0 for both PUO and LUO if you wish to abstain.");
			input1before.focus();
			return false;
		}
		
		counter = counter - 1;
	}
	
	form.submit();
}
</script>


<?php
//This action happens after manager or regular users clicks on "Risk Assessment" in the navigation bar on the left.
//This file can be integrated with html to generate ballot table! (maybe this file is included in html file??)
//The authority will be checked immediately.

include_once 'include/conn.php';
session_start();

$role = $_SESSION['authority']; //manager, admin, user; here it only can be manager

if ($role != "manager" && $role != "user"){
	echo "<script>alert('Sorry, but you have to be one of the project managers or regular users to vote!');</script>";
	echo "<script language='javascript'>window.location.href='setup.html';</script>";	//debug: go where?? This one should be for TA's
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM ProjMem WHERE member='".$username."'";
$rst = $conn->execute($sql);
$projName = $rst->fields['project'];

//lookup (projName, riskName) in ProjRiskDesc
$sql1 = "SELECT * FROM ProjRiskDesc WHERE projName='".$projName."'";	//this returns many rows since many risks
$rst1 = $conn->execute($sql1);

while (!$rst1->EOF) {	//for every row in ProjRiskDesc
	//$projName = $rst1->fields['projName'];
	$riskName = $rst1->fields['riskName'];
	
	//look up member in ProjMem for the project
	$sql2 = "SELECT * FROM ProjMem WHERE project='$projName'";	//this returns many rows due to many members in a proj
	$rst2 = $conn->execute($sql2);
	
	while (!$rst2->EOF){	//for every row in ProjMem with particular projName
		$member = $rst2->fields['member'];
		
		//look up (projName, riskName, username) in IndividualVote, if no match, then insert it; if matched, do nothing.
		$sql3 = "SELECT * FROM IndividualVote WHERE projName='$projName' AND riskName='$riskName' AND userName='$member'";
		$rst3 = $conn->execute($sql3);
		
		if ($rst3->RecordCount() == 0){	//no matched, insert it
			$sql4 = "insert into IndividualVote (projName, riskName, userName) values ('$projName', '$riskName', '$member')";
			$rst4 = $conn->execute($sql4);
		}
		
		//do nothing if matched.
		
		$rst2->movenext();
	}
	
	
	$rst1->movenext();	//move on to the next (projName, riskName) in ProjRiskDesc
}

$getRiskSQL = "SELECT * FROM ProjRiskDesc WHERE projName='".$projName."'";	//this returns many rows since many risks
$getRiskRST = $conn->execute($getRiskSQL);
$numberofrow = $getRiskRST->RecordCount();

?>


<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Risk Assessment</title>
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
  <div id="contact">
    <h5 style="margin-top:0px;">Risk Assessment Ballot</h5>
    <p>&diams; For each risks item enter value(0 to abstain, 1=low to 10=highest) for the following:</p>
    <p>P(UO)- Probability of Undesirable Outcome.</p>
    <p>L(UO)- Size of Loss of Undesirable Outcome.</p>
    <p>&diams; For each risk, you can see votes from project stakeholders by clicking +/-</p>
    <p>&diams; Note that if you want to abstain from a risk item, enter 0 for both PUO and LUO.</p>
    <p>&diams; Note that only Integers from 0~10 (inclusive) are acceptable for both PUO and LUO.</p>
    <p>&diams; Please enter values for PUO and LUO for EACH risk item; the old values you entered are replaced by the new ones.</p>
	<br/>
	<h5>Project Name:</h5>
	<h5 style="color: #660000"><?php echo $projName; ?></h5>
	<br/>
          

<form method="post" action="saveVotes.php" name="voting_form" id="voting_form">
<div>
	<table>
 		<thead>
			<th>ID</th>
			<th>Risk Item</th>
			<th>P(UO)</th>
			<th>L(UO)</th>
			<th>Rationale</th>
			<th>Other People</th>
		</thead>
		<tbody>
			<?php for($counter = 1;$counter<=$numberofrow;$counter++){ ?>
			
			  <tr>
				<?php $riskName = $getRiskRST->fields['riskName']; ?>
				<td><?php echo $counter; ?></td>
				<td><?php echo $riskName; ?></td>
				
				<td><input style="width:25px" id="<?php echo $counter;?>+1" name="arr[pvalue][<?php echo $riskName;?>]" type="text" class="input" id="sender_name" title="riskname" value="0" maxlength="2"/></td>
				<td><input style="width:25px" id="<?php echo $counter;?>+2" name="arr[lvalue][<?php echo $riskName;?>]" type="text" class="input" id="sender_name" title="riskname" value="0" maxlength="2"/></td>
				<td><input name="arr[rationale][<?php echo $riskName;?>]" type="text" class="input" id="sender_name" title="riskname" value="" maxlength="100"/></td>
				<!--<td><a href="RiskAssessment.php">+</a></td>-->
				<td><a href="<?php echo "RiskAssessment_detail.php?name=".$riskName; ?>")">+</a></td>
			  </tr>
			
			  <?php $getRiskRST->movenext(); ?>
			<?php }?>
		</tbody>
	</table>
</div>
  
	<br/>
	<div class="submitbtn">
		<input type="submit" name='Save Votes' class="styled-button" onclick="return check(voting_form, <?php echo $counter;?>);" value="Save Votes" />
    </div>  
</form>
  </div>
  
<div id="contactinfo" style="width:300px; margin-left: 2px">    

<br/>
<?php $riskItem = $_GET['name'];

$sameRiskSQL = "SELECT * FROM IndividualVote WHERE projName='$projName' AND riskName='$riskItem'";	//this returns many rows since many stakeholders.
$sameRiskRST = $conn->execute($sameRiskSQL);
$numberofstakeholder = $sameRiskRST->RecordCount();

?>
<?php echo "<h5>&diams; Here's how other stakeholders voted on ".$riskItem.":</h5><br />"; ?>
  <!--END of contact section-->
	<table>
		<thead>
			<th>Stakeholder</th>
			<th>P(UO)</th>
			<th>L(UO)</th>
			<th>Stakeholder Vote Rationale</th>
		</thead>
		<tbody>
			<?php for($counter = 1;$counter<=$numberofstakeholder;$counter++){ ?>
				
			<tr>
				<?php $stakeholder = $sameRiskRST->fields['userName']; ?>
				<td><?php echo $stakeholder; ?></td>
				<?php $aPUO = $sameRiskRST->fields['PUO']; ?>
				<td><?php echo $aPUO; ?></td>
				<?php $aLUO = $sameRiskRST->fields['LUO']; ?>
				<td><?php echo $aLUO; ?></td>
				<?php $aRationale = $sameRiskRST->fields['rationale']; ?>
				<td><?php echo $aRationale; ?></td>
			</tr>
			  <?php $sameRiskRST->movenext(); ?>
			<?php } ?>
		</tbody>
	</table>  
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
