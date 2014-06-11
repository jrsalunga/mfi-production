<?php
require_once('../lib/initialize.php');
!$session->is_logged_in() ? redirect_to("login"): "";
include_once('../../classes/class.cleanurl.php');

ini_set('display_errors','Off');
$cleanUrl->setParts('projectid');
$project = Project::find_by_id($projectid);
//var_dump($project);
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

<link rel="stylesheet" href="/css/bootstrap.css">
<link rel="stylesheet" href="/css/styles-ui2.css">

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
            	<img class="img-responsive header-logo" alt="MFI Logo" src="/images/mfi-logo.png">
        	</a>
          <a class="navbar-brand" href="/">Production Report</a>
        </div>
        
        <div class="navbar-collapse collapse">
        	<ul class="nav navbar-nav">
              <li><a href="/daily">Daily</a></li>
              <li><a href="/monthly">Monthly</a></li>
              <li class="active"><a href="/project-status">Project Status</a></li>
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
            <h1>Project Status Board</h1>
        </div>
        <div class="col-md-3 proj-nav-lists">
            <ul class="nav nav-pills nav-stacked">
            <?php
				$prjs = Project::find_all();
				
				foreach($prjs as $prj){
					echo '<li ';
					echo $prj->id==$projectid ? "class=\"active\"":"";
					echo '>';
					echo '<a href="/project-status/'.$prj->id.'">'.$prj->descriptor.'</a>';
					echo '</li>';
				}
			?>
			</ul>
        </div>
		<div class="col-md-9 r-pane">
        <!--<div class="col-md-9 r-pane affix">-->
            <div class="p-info">
            	<h2><span class="glyphicon glyphicon-briefcase"></span>
                <?=$project->descriptor?>
				</h2>
            	<p>
                <span class="glyphicon glyphicon-map-marker"></span>
                <?=$project->location?>
                </p>
                <div class="row">
                	<div class="col-xs-4">
                    	<p title="Customer">
                        	<span class="glyphicon glyphicon-user"></span>
                        	<span><?=Customer::row($project->customerid, 1)?></span>
                        </p>
                    </div>
                    <div class="col-xs-4">
                    	<p title="Salesman">
                            <span class="glyphicon glyphicon-headphones"></span>
                            <span><?=Salesman::row($project->salesmanid, 1)?></span>
                        </p>
                    </div>
                    <div class="col-xs-4">
                    	<p>
                            <span class="glyphicon glyphicon-tower"></span>
                            <span title="Type"><?=$project->type=='2'?'Hi Rise':''?><?=$project->type=='1'?'Singles':''?></span>
                        </p>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-4">
                    	<p title="Date started">
                            <span class="glyphicon glyphicon-save"></span>
                            <span><?=isset($project->datestart)? date('F j, Y', strtotime($project->datestart)):'';?> </span>
                        </p>
                    </div>
                    <div class="col-xs-4">
                    	<p title="Target date">
                            <span class="glyphicon glyphicon-screenshot"></span>
                            <span><?=isset($project->dateendx)? date('F j, Y', strtotime($project->dateendx)):'';?> </span>
                        </p>
                    </div>
                    <div class="col-xs-4">
                    	<p title="Date ended">
                            <span class="glyphicon glyphicon-saved"></span>
                            <span title="Date ended"><?=isset($project->dateendx)? date('F j, Y', strtotime($project->dateendx)):'';?></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="p-development">
        	<br>
        	<table class="table">
            	<thead>
                	<tr><th>Operations</th><th>Total Parts</th></tr>
                </thead>
                <tbody>
				<?php
                
                    $operations = Operation::find_all();
                    foreach($operations as $operation){
						echo '<tr>';
                        $sql = "SELECT SUM(totparts) as totparts FROM prodhdr ";
                        $sql .= "WHERE projectid = '".$projectid."' AND opnid = '".$operation->id."'";
                        $prodhdr = Prodhdr::find_by_sql($sql);
                        $prodhdr = array_shift($prodhdr);
                        echo '<td>'.$operation->descriptor.'</td><td>'.number_format($prodhdr->totparts).'</td>';
						echo '</tr>';
                    }
                
                ?>
                </tbody>
       		</table>
        </div>
        </div>
		

    </div>
</div> <!-- /container -->
    
    
    








<!--
<link rel="stylesheet" href="css/main-ui.css">
<link rel="stylesheet" href="css/styles-ui.css">
-->

<script src="/js/vendors/jquery-1.10.1.min.js"></script>
<script src="/js/vendors/jquery-ui-1.10.3.js"></script>
<!--
<script src="../js/vendors/jquery-ui-1.10.3.js"></script>
<script src="../js/vendors/jquery-1.9.1.js"></script>
<script src="js/vendors/underscore-min.js"></script>
<script src="js/vendors/backbone-min.js"></script>
-->
<script src="/js/vendors/underscore-min.js"></script>
<script src="/js/vendors/backbone-min.js"></script>
<script src="/js/vendors/bootstrap.min.js"></script>
<script src="/js/vendors/backbone-validation-min.js"></script>
<script src="/js/vendors/jquery.cookie-1.4.js"></script>
<script src="/js/vendors/moment.2.1.0-min.js"></script>
<script src="/js/vendors/accounting.js"></script>
<script src="/js/vendors/jquery.filedrop.js"></script>
<script src="/js/common.js"></script>

<script src="/js/app.js"></script>


<script>




$(document).ready(function(e) {
	
	

	
});
</script>

</body>
</html>