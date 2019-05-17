<?php
//json directory
$json_dir = "report";
$json_dir .= DIRECTORY_SEPARATOR;

require_once( "funcs.php" );
$head   = '	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<script src="assets/js/jquery.bdt.js"></script>
	<link href="assets/css/jquery.bdt.css" rel="stylesheet">
	<link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<script src="assets/js/jquery.sortelements.js"></script>'.PHP_EOL;
	
$header = '<div class="pb-2 mt-4 mb-2 border-bottom">
		  <h2>JSON editor</h2>
	</div>'.PHP_EOL;