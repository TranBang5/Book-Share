<?php 
session_start();

if (isset($_POST['email']) && 
	isset($_POST['password'])) {
    
    # Database Connection File
	include "../db_conn.php";
    
    # Validation helper function
	include "func-validation.php";
	
	/** 
	   Get data from POST request 
	   and store them in var
	**/

	$email = $_POST['email'];
	$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $role = "user";

	# simple form validation

	$text = "Email";
	$location = "../login.php";
	$ms = "error";
    is_empty($email, $text, $location, $ms, "");

	$text = "Name";
	$location = "../login.php";
	$ms = "error";
    is_empty($name, $text, $location, $ms, "");

    $text = "Password";
	$location = "../login.php";
	$ms = "error";
    is_empty($password, $text, $location, $ms, "");

    # search for the email
    $sql = "SELECT * FROM admin 
            WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    # if the email is exist
    if ($stmt->rowCount() === 1) {
    	$em = "Email has already been used";
    	header("Location: ../login.php?error=$em");
    }else{
    	$sql  = "INSERT INTO admin (email,full_name,password,role)
			         VALUES ('$email','$name','$password','$role')";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute();

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
	# Redirect to "../login.php"
	header("Location: ../register.php");
}