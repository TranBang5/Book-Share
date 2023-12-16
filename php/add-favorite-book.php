<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";

    $user_id = $_SESSION['user_id'];
    
	$book_id = $_GET['book_id'];
    $pdf_link = $_GET['pdf_link'];
	$sql  = "INSERT INTO favorite_book (user_id,book_id)
			         VALUES (?,?)";
	$stmt = $conn->prepare($sql);
	$res  = $stmt->execute([$user_id, $book_id]);
	 if ($res) {
        $sm = "Added To Your Favorite!";
        if ($location == "index") {
            header("Location: ../favorite.php?success=$sm");
        } else {
            header("Location: ../display-book.php?success=$sm & pdf_link=$pdf_link & book_id=$book_id");
        }
        exit;
	 }else{
	 	# Error message
	 	$em = "Unknown Error Occurred!";
         if ($location == "index") {
             header("Location: ../favorite.php?error=$em");
         } else {
             header("Location: ../display-book.php?error=$em & pdf_link=$pdf_link & book_id=$book_id");
         }
         exit;
     }
}else{
  header("Location: ../login.php");
  exit;
}