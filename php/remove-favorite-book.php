<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";

    /** 
	  check if the category 
	  id set
	**/
	if (isset($_GET['book_id'])) {
		/** 
		Get data from GET request 
		and store it in var
		**/
        $location = $_GET['location'];
		$id = $_GET['book_id'];
        $pdf_link = $_GET['pdf_link'];
		#simple form Validation
		if (empty($id)) {
			$em = "Error Occurred!";
			header("Location: ../admin.php?error=$em");
            exit;
		}else {
            # DELETE the category from Database
			$sql  = "DELETE FROM favorite_book
			         WHERE book_id=?";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$id]);

			/**
		      If there is no error while 
		      Deleting the data
		    **/
		     if ($res) {
		     	# success message
		     	$sm = "Removed From Your Favorite!";
                if ($location == "index") {
                    header("Location: ../favorite.php?succes=$sm");
                } else {
		            header("Location: ../display-book.php?success=$sm & pdf_link=$pdf_link & book_id=$book_id");
                }
	            exit;
			 }else {
                $em = "Unknown Error Occurred!";
                if ($location = 'index') {
                    header("Location: ../favorite.php?error=$em");
                } else {
                    header("Location: ../display-book.php?error=$em & pdf_link=$pdf_link & book_id=$book_id");
                }
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