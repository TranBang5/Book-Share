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
	if (isset($_POST['author_name']) &&
        isset($_POST['author_id']) &&
		isset($_POST['author_bio']) &&
		isset($_FILES['author_portrait'])) {
		/** 
		Get data from POST request 
		and store them in var
		**/
		$name = $_POST['author_name'];
		$bio = $_POST['author_bio'];
		$id = $_POST['author_id'];
		$current_cover = $_POST['current_portrait'];

		#simple form Validation
		if (!empty($_FILES['author_portrait'])) {
			$c_p_book_cover = "../uploads/portraits/$current_cover";
			unlink($c_p_book_cover);

			$allowed_image_exs = array("jpg", "jpeg", "png");
			$path = "portraits";
        	$author_potrait = upload_file($_FILES['author_portrait'], $allowed_image_exs, $path);
			$author_portrait_URL = $author_potrait['data'];
			# UPDATE the Database
			$sql  = "UPDATE authors 
			         SET name=?, author_bio=?, author_portrait=?
			         WHERE id=?";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$name, $bio, $author_portrait_URL, $id]);
			if ($res) {
				# success message
				$sm = "Successfully updated!";
			   header("Location: ../edit-author.php?success=$sm&id=$id");
			   exit;
			}else{
				# Error message
				$em = "Unknown Error Occurred!";
			   header("Location: ../edit-author.php?error=$em&id=$id");
			   exit;
			}
		}else {
			$sql  = "UPDATE authors 
			         SET name=?, author_bio=?
			         WHERE id=?";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$name, $bio, $id]);

			/**
		      If there is no error while 
		      inserting the data
		    **/
		     if ($res) {
		     	# success message
		     	$sm = "Successfully updated!";
				header("Location: ../edit-author.php?success=$sm&id=$id");
	            exit;
		     }else{
		     	# Error message
		     	$em = "Unknown Error Occurred!";
				header("Location: ../edit-author.php?error=$em&id=$id");
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