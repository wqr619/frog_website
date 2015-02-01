<?php
session_start();
$target_path = "uploads/";

 // Create new directory with 744 permissions if it does not exist yet
if ( !file_exists($target_path) ) {
  mkdir ($target_path, 0744);
}

 // Upload files
if(isset($_FILES["source_code"]))
{
	$ret = array();

	$error =$_FILES["source_code"]["error"];
	$ret['error'] = $error;
	$ret['success'] = false;

	// Upload single file
	if(!is_array($_FILES["source_code"]["name"])) //single file
	{
 	 	$file_name = $_FILES["source_code"]["name"];
 	 	$target_path = $target_path . basename( $file_name);

 	 	// Store file in server
 		if(move_uploaded_file($_FILES["source_code"]["tmp_name"], $target_path) ){

    		//TODO: file name for specific user
    		$_SESSION['curr_file'] = $target_path;
    		$ret['file_name']= $file_name;
    	}

    	// Read file content
        $file_content = file_get_contents($target_path);
        $ret['content'] = $file_content;
        $ret['success'] = true;
	}
    echo json_encode($ret);
}
?>