<?php
	//In the name of god
	//By: Arman Hosseini
	require_once( "config.php" );
?>
<!DOCTYPE html>
<html dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$head?>
   
	<title>JSON editor | file browser</title>
</head>
<body>

<div class="container">
	<?=$header?>
	<?=isset($_GET["code"])?'	<p class="bg-white text-danger p-2 rounded border border-danger">This file doesn\'t exist!</p>'.PHP_EOL:PHP_EOL?>
	<table id="bootstrap-table" class="table table-hover">
		<thead>
			<th>File Name <i class="fa fa-sort" aria-hidden="true"></i></th>
			<th class="text-right">Size</th>
			<th class="text-right">Modified</th>
		</thead>
		<tbody>
			<?php 
				if ($handle = opendir( $json_dir )) {
					while (false !== ($entry = readdir($handle))) {
						if ($entry != "." && $entry != "..")
						{
							$stat = stat( $json_dir . $entry );
							$item['bytes']      =   $stat['size'];
							$item['size']       =   bytes_to_string($stat['size'], 2);
							$item_pretty_size = $item['size']['num'] . " " . $item['size']['str'];
							
							$item['mtime']      =   $stat['mtime'];
							$time_ago = time_ago($item['mtime'])
			?><tr>
				<td> <a href='<?='edit.php?file='.urlencode( base64_encode( $entry ) )?>' target='_blank'><?=$entry?></a> </td>
				<td class="text-right"> <?=$item_pretty_size?> </td>
				<td class="text-right"> <?=$time_ago?> </td>
			</tr>
			<?php
						}
					}
					closedir($handle);
				}
			?>
		</tbody>
	</table>
</div>

    <script type="text/javascript">
    $(document).ready( function () {
       $('#bootstrap-table').bdt({
		    showSearchForm: 1,
            showEntriesPerPageField: 1
	   });
    });
    </script>

</body>
</html>
