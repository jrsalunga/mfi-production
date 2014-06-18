<?php
require_once('../lib/initialize.php');
!$session->is_logged_in() ? redirect_to("login"): "";
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
table.table tbody tr td:not(:nth-child(1)) {
	text-align:right;
	font-weight:bold;
}
table.table tbody tr td div {
	font-size:13px;
	color:#666666;
	text-align:right;
	font-weight:normal;
	
	
          transition: all 100ms ease-in-out;
     -moz-transition: all 100ms ease-in-out;
	-webkit-transition: all 100ms ease-in-out;
}
table.table tbody tr td:nth-child(1) div {
	opacity: 0;
}
table.table tbody tr:hover td:nth-child(1) div {
	opacity: 0.8;
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
              <li><a href="/daily">Daily</a></li>
              <li class="active"><a href="/monthly">Monthly</a></li>
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

    <div>
    <div class="stage">
		
        <div class="col-md-12 title">
       		<h1>Monthly Production Output Board</h1>
     	</div>
        <div class="col-md-12">
            	<?php
					$operations = Operation::find_all();
				?>
                <br>
            	<table class="table table-bordered table-hover">
                <thead>
                	<tr>
                    	<th>MONTHS</th>
                        <?php
							foreach($operations as $operation){
								echo '<th title="'.$operation->descriptor.'">'.$operation->code.'</th>';
							}
						?>
                    </tr>
                </thead>
            	<?php
					//date('Y-m-t', strtotime(date('Y', strtotime('now')).'-'.$mon))
					for($mon=1; $mon<=12; $mon++){
						$curr_mon = date('Y', strtotime('now')).'-'.$mon;
						$mon_begin = date('Y-m-01', strtotime($curr_mon));
						$mon_end = date('Y-m-t', strtotime($curr_mon));
						$m_end = date('Y-m-t', strtotime($curr_mon)) < date('Y-m-d', strtotime('now')) ? date('Y-m-t', strtotime($curr_mon)):date('Y-m-d', strtotime('now'));
						$dr = new DateRange($mon_begin,$m_end,false);
						echo '<tr>';
						echo '<td><a href="/daily?fr='.$mon_begin.'&to='.$mon_end.'">';
						echo date('F', strtotime(date('Y', strtotime('now')).'-'.$mon)).'</a>';
						echo '<div>Ave</div><div>Work Ave</div></td>';
							foreach($operations as $operation){
								$sql = "SELECT SUM(totparts) AS totparts, COUNT(DISTINCT date) AS totline FROM prodhdr ";
								$sql .= "WHERE date BETWEEN '".$mon_begin."' AND '".$mon_end."' ";
								$sql .= "AND opnid = '".$operation->id."' ORDER BY date DESC";
								$prodhdr = Prodhdr::find_by_sql($sql);
								$prodhdr = array_shift($prodhdr);
								$ave = $prodhdr->totparts/($dr->date_diff() + 1);
								$ave2 = $prodhdr->totparts / $prodhdr->totline;
								echo '<td>';
								echo $prodhdr->totparts > 0 ? number_format($prodhdr->totparts):'';
								echo $ave!=0 ? '<div>'. number_format($ave,2) .'<div>':'';
								echo $ave2>0 ? '<div>'.number_format($ave2,2).'</div>':'';
								echo '</td>';
							}
						echo '</tr>';
					}
				
				
				?>
                </table>
            </div>
  

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




$(document).ready(function(e) {
	
	
	$('table.table').fixMe({
		'container': '.navbar'	
	});

	
});
</script>

</body>
</html>