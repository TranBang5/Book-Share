<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";

    $user_id = $_SESSION['user_id'];
    $locate = $_GET['location'];
    
	$author_id = $_GET['author_id'];
	$sql  = "INSERT INTO favorite_author (user_id,author_id)
			         VALUES (?,?)";
	$stmt = $conn->prepare($sql);
	$res  = $stmt->execute([$user_id, $author_id]);
	 if ($res) {
        $sm = "Added To Your Favorite!";
        if ($locate == "index") {
            header("Location: ../favorite.php?success=$sm");
        } else {
            header("Location: ../author.php?success=$sm&id=$author_id");
        }
        exit;
	 }else{
	 	# Error message
	 	$em = "Unknown Error Occurred!";
         if ($locate == "index") {
             header("Location: ../favorite.php?error=$em");
         } else {
             header("Location: ../author.php?error=$em&id=$author_id");
         }
         exit;
     }
}else{
  header("Location: ../login.php");
  exit;
}