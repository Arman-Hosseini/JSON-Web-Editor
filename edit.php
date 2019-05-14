<?php
	require_once( "config.php" );
	
	//get the filename from URL
	$file = base64_decode( urldecode($_GET['file'] ) );
	$filename = $file;
	$file = $json_dir.$filename;
	if ( ! is_file( $file ) )
	{
		header( "Location: ./index.php?code=404" );
		die();
	}
	
	//save changes
	if ( isset( $_POST["submit"] ) )
	{
		unset( $_POST["submit"] );
		$data = $_POST;
		
		//replace boolean values and empty array with real type
		function array_in_array_replace( $find, $replace, &$array ){
			foreach( $array as &$field )
			{
				if ( is_array( $field ) && count( $field ) > 0 )
					array_in_array_replace( $find, $replace, $field );
				else if ( in_array( $field, $find ) )
				{
					$field = $replace[array_search( $field, $find )];
				}	
			}
		}
		array_in_array_replace( 
			array( 
				'False:isBool',
				'True:isBool',
				'[]:isArray'
			),
			array( 
				False,
				True,
				array()
			),
			$data
		);
		//print_R($data);
		
		
		$json = json_encode( $data );
		file_put_contents( $file, $json );
		$save = true;
	}
	

	//load file and get json data
	$data = file_get_contents( $file );
	$json = json_decode( $data, true );
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$head?>
	
	<title>JSON Editor | editing <?=$filename?></title>
</head>
<body>
<div class="container">
	<?=$header?>
	<a class="btn btn-primary mt-2 mb-5 text-white" href='./'>File browser</a>
	<?=isset($save)?'	<p class="bg-white text-success p-2 rounded border border-success">Changes saved!</p>'.PHP_EOL:PHP_EOL?>
	
	<form action="./edit.php?file=<?=urlencode( base64_encode( $filename ) )?>" method="POST">
	<?php
		function initialize_views( $json, $parentArrayName = null )
		{
			foreach( $json as $key => $field ):
				$label = $key;
				$name = !is_null($parentArrayName) ? $parentArrayName.'['.$key.']' : $key;
				
				if ( is_numeric( $field ) ):
	?>
		<div class="form-group">
			<label for="<?=$name?>"><?=$label?>*</label>
			<input type="number" class="form-control" name="<?=$name?>" value="<?=$field?>">
		</div>
	<?php
				elseif ( is_string( $field ) ):
					$field = htmlentities( $field, ENT_QUOTES );
	?>
		<div class="form-group">
			<?=( ! is_numeric( $label ) ) ? '<label for="'.$name.'">'.$label.'*</label>' : ''?>
			<input type="text" class="form-control" name="<?=$name?>" value="<?=$field?>">
		</div>
	<?php
				elseif( is_array( $field ) ):
	?>
		<div class="pb-0 mt-4 mb-4 border-bottom">
		  <h4><?=$label?>*</h4>
		</div>
	<?php
					if ( count( $field ) > 0 ):
						initialize_views( $field, $name );
					else: //empty array
	?>
			<input type="hidden" name="<?=$name?>" value="[]:isArray">
	<?php
					endif;
				elseif ( is_bool( $field ) === true ):
	?>
		<div class="form-group">
			<label for="<?=$name?>"><?=$label?>*</label>
			<select class="form-control" name="<?=$name?>">
				<option<?=$field==false?' selected':''?> value='False:isBool'>False</option>
				<option<?=$field==true?' selected':''?> value='True:isBool'>True</option>
			</select>
		</div>
	<?php
				endif;
			endforeach;
		}
		
		if ( is_array( $json ) )
		{
			initialize_views( $json );
			echo '	<button type="submit" class="btn btn-success mb-3" name="submit">Save changes</button>'.PHP_EOL;
		}
		else
			echo '	<p class="bg-white text-danger p-2 rounded border border-danger">This isn\'t a JSON file!</p>'.PHP_EOL;
	?>
	</form> 
</div>
</body>
</html>