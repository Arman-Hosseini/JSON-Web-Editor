<?php
//json directory
$json_dir = "report";
$json_dir .= DIRECTORY_SEPARATOR;

require_once( "funcs.php" );
$head   = '	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<script src="js/jquery.bdt.js"></script>
	<link href="css/jquery.bdt.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<script src="js/jquery.sortelements.js"></script>'.PHP_EOL;
	
$header = '<div class="pb-2 mt-4 mb-2 border-bottom">
		  <h2>JSON editor</h2>
	</div>'.PHP_EOL;