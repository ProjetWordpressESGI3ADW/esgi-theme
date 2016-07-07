<?php
function validateEventImg(array $upFile){
	if($upFile['size'] > 2000000){
		$_SESSION['event_error'] = "img has to weight less than 2MB !";
		return false;
	}
	if($upFile['error'] > 0){
		$_SESSION['event_error'] = "problem while receiving file";	
		return false;
	} 
	$type = $upFile['type'];
	if(is_bool(strpos($type, 'image'))) return false;
	$authorizedFormats = ['png', 'jpg', 'jpeg', 'gif'];
	$name = $upFile['name'];
	$format = explode('.', $name);
	$format = $format[count($format)-1];
	if(!(in_array($format, $authorizedFormats))) return false;

	return ['path' => $upFile['tmp_name'], 'format' => $format];
}
function renameEventFile($postId, $path, $format){
	$finalPath = str_replace("\\", '/', plugin_dir_path( __FILE__ )) . 'images/event/'.$postId.'.'.$format;
	echo "<script>alert('".$finalPath."');</script>";
	touch($finalPath);
	$r = move_uploaded_file($path, $finalPath);
	if($r) return $finalPath;
	return false;
}

$args = array(
    'event_proposed_email' => FILTER_VALIDATE_EMAIL
);
$filteredinputs = filter_input_array(INPUT_POST, $args);
foreach ($args as $key => $value) {
	if(!isset($filteredinputs[$key])){
		$_SESSION['event_error'] = "missing input ". $value;
		$filteredinputs = false;
	}
}
$newImg = validateEventImg($_FILES['event_proposed_drawing']);
if(!!$newImg){
	// $newImg = (renameEventFile())
}
	

// header('Location: '. get_template_directory_uri());