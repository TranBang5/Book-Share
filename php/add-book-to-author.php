<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";
  
  include "func-book.php";

    /** 
	  check if category 
	  name is submitted
	**/
	if (isset($_POST['book'])) {
        $book_id = $_POST['book'];
        $author_id = $_POST['author_id'];

		if (empty($book_id)) {
            # Error message
            $em = "A book is required";
            header("Location: ../add-book-to-author.php?error=$em&author_id=$author_id");
            exit;
       } else { 
        $check = check_book_from_author($conn, $book_id, $author_id);
          if ($check) {
            $em = "Book is already in the author library";
            header("Location: ../add-book-to-author.php?error=$em &author_id=$author_id");
            exit;
          } else {
            $sql  = "INSERT INTO author_library (author_id, book_id)
                         VALUES (?,?)";
                $stmt = $conn->prepare($sql);
			    $res  = $stmt->execute([$author_id, $book_id]);
          if ($res) {
            # success message
            $sm = "Successfully added!";
         header("Location: ../add-book-to-author.php?success=$sm&author_id=$author_id");
               exit;
          }else{
            # Error message
            $em = "Unknown Error Occurred!";
         header("Location: ../add-book-toauthor.php?error=$em&author_id=$author_id");
               exit;
          }
          }
        }
    } else {
      header("Location: ../admin.php");
      exit;
	}

}else{
  header("Location: ../login.php");
  exit;
}
  