<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";

	# File Upload helper function
    include "func-file-upload.php";
    /** 
	  check if author 
	  name is submitted
	**/
	if (isset($_POST['author_name']) && isset($_POST['author_bio']) && isset($_FILES['portrait'])) {
		/** 
		Get data from POST request 
		and store it in var
		**/
		$name = $_POST['author_name'];
		$bio = $_POST['author_bio'];
		$user_id = $_SESSION['user_id'];
		$allowed_image_exs = array("jpg", "jpeg", "png");

        $path = "portraits";
        $author_potrait = upload_file($_FILES['portrait'], $allowed_image_exs, $path);
		$author_potrait_URL = $author_potrait['data'];

		#simple form Validation
		if (empty($name)) {
			$em = "The author name is required";
			header("Location: ../add-author.php?error=$em");
            exit;
		}else {
			# Insert Into Database
			$sql  = "INSERT INTO authors (name, user_id, author_bio, author_portrait)
			         VALUES (?,?,?,?)";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$name, $user_id, $bio, $author_potrait_URL]);

			/**
		      If there is no error while 
		      inserting the data
		    **/
		     if ($res) {
		     	# success message
		     	$sm = "Successfully created!";
				header("Location: ../add-author.php?success=$sm");
	            exit;
		     }else{
		     	# Error message
		     	$em = "Unknown Error Occurred!";
				header("Location: ../add-author.php?error=$em");
	            exit;
		     }
		}
	}else {
      header("Location: ../admin.php");
      exit;
	}

}else{
  header("Location: ../login.php");
  exit;
}