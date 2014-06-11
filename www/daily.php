<?php
require_once('../lib/initialize.php');
!$session->is_logged_in() ? redirect_to("login"): "";
if(isset($_GET['fr']) && isset($_GET['to'])){
    sanitize($_GET);
    $dr = new DateRange($_GET['fr'],$_GET['to'], false);
} else {
    $dr = new DateRange(NULL,NULL,false);   
}
?>
<!DOCTYPE HTML>
<html lang="en-ph">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Cache-control" content="public">

<title>MFI - Production Report</title>
<link href="/images/mfi-logo.png" type="image/x-icon" rel="shortcut icon">

<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/styles-ui2.css">
<style>
table.table thead tr th {
	font-weight: normal;
	font-size:12px;
}
</style>
</head>
<body id="app-body" class="state-nav">


	   <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div>
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
       		<a href="http://prod.mfi.dev">
            	<img class="img-responsive header-logo" alt="MFI Logo" src="http://prod.mfi.dev/images/mfi-logo.png">
        	</a>
          <a class="navbar-brand" href="/">Production Report</a>
        </div>
        
        <div class="navbar-collapse collapse">
        	<ul class="nav navbar-nav">
              <li class="active"><a href="/daily">Daily</a></li>
              <li><a href="/monthly">Monthly</a></li>
              <li><a href="/project-status">Project Status</a></li>
            </ul>
       		<ul class="nav navbar-nav navbar-right">
            <!--
                <li><a href="#home">Home</a></li>
                <li><a href="#location/jeff">About</a></li>
            -->    
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-cog"></span>
                    <b class="caret"></b>
                    </a>
                        <ul class="dropdown-menu">
                        	<li><a href="#settings">Settings</a></li>
                            <li><a href="logout">Sign Out</a></li>

     
                      </ul>
                </li>
            </ul>  
        </div><!--/.nav-collapse -->
      </div>
    </div>

    
    <div class="stage">
    	
      		<div class="col-md-12 title">
            	<h1>Daily Production Output</h1>
            </div>
            <div class="col-md-6 title">
            	
            </div>
            <div class="col-md-6 datepick">
                <form role="form" class="form-inline pull-right">
                    <div class="form-group">
                        <label class="sr-only" for="fr">From:</label>
                        <input type="text" class="form-control" id="fr" name="fr" placeholder="YYYY-MM-DD" value="<?=$dr->fr?>">
                    </div>	
                    <div class="form-group">
                        <label class="sr-only" for="to">To:</label>
                        <input type="text" class="form-control" id="to" name="to" placeholder="YYYY-MM-DD"  value="<?=$dr->to?>">
                    </div>
                    <button type="submit" class="btn btn-success">Go</button>
                </form>
            </div>
  			<div class="col-md-12">
            	<?php
					$operations = Operation::find_all();
				?>
                <br>
            	<table class="table table-bordered">
                <thead>
                	<tr>
                    	<th>DAYS</th>
                        <?php
							foreach($operations as $operation){
								echo '<th title="'.$operation->descriptor.'">'.$operation->code.'</th>';
							}
						?>
                    </tr>
                </thead>
            	<?php
					foreach($dr->getDaysInterval() as $date){
						echo '<tr>';
						echo '<td>'.$date->format('M j').'</td>';
							foreach($operations as $operation){
								echo '<td>-</td>';
							}
						echo '</tr>';
					}
				
				
				?>
                </table>
            </div>


	</div> <!-- /container -->
    
    
    








<!--
<link rel="stylesheet" href="css/main-ui.css">
<link rel="stylesheet" href="css/styles-ui.css">
-->

<script src="js/vendors/jquery-1.10.1.min.js"></script>
<script src="js/vendors/jquery-ui-1.10.3.js"></script>
<!--
<script src="../js/vendors/jquery-ui-1.10.3.js"></script>
<script src="../js/vendors/jquery-1.9.1.js"></script>
<script src="js/vendors/underscore-min.js"></script>
<script src="js/vendors/backbone-min.js"></script>
-->
<script src="js/vendors/underscore-min.js"></script>
<script src="js/vendors/backbone-min.js"></script>
<script src="js/vendors/bootstrap.min.js"></script>
<script src="js/vendors/backbone-validation-min.js"></script>
<script src="js/vendors/jquery.cookie-1.4.js"></script>
<script src="js/vendors/moment.2.1.0-min.js"></script>
<script src="js/vendors/accounting.js"></script>
<script src="js/vendors/jquery.filedrop.js"></script>
<script src="js/common.js"></script>

<script src="js/app.js"></script>


<script>



function daterange(){

  	$( "#fr" ).datepicker({
		defaultDate: "+1w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 2,
		onClose: function( selectedDate ) {
			$( "#to" ).datepicker( "option", "minDate", selectedDate );
		},
		beforeShow: function() {
			setTimeout(function(){
				$('#ui-datepicker-div').css('z-index', 1002);
			}, 0);
		}
	});
    $( "#to" ).datepicker({
  		defaultDate: "+1w",
      	dateFormat: 'yy-mm-dd',
      	changeMonth: true,
      	numberOfMonths: 2,
      	onClose: function( selectedDate ) {
        	$( "#fr" ).datepicker( "option", "maxDate", selectedDate );
      	},
		beforeShow: function() {
			setTimeout(function(){
				$('#ui-datepicker-div').css('z-index', 1002);
			}, 0);
		}
    });
}





$(document).ready(function(e) {
	
	daterange();
	
	

	
});
</script>

</body>
</html>