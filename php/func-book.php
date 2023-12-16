<?php  

# Get All books function
function get_all_books($con){
   $sql  = "SELECT * FROM books ORDER bY id DESC";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}

# Get All books function
function get_user_books($con,$user_id){
   $sql  = "SELECT * FROM books  
   where user_id = ? ORDER BY books.id DESC";
   $stmt = $con->prepare($sql);
   $stmt->execute([$user_id]);

   if ($stmt->rowCount() > 0) {
   	  $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}

# Get favorite books
function get_favorite_book($con, $user_id) {
   $sql  = "SELECT books.* FROM books
   inner join favorite_book on books.id = favorite_book.book_id  
   where favorite_book.user_id = ? ORDER BY books.id DESC";
   $stmt = $con->prepare($sql);
   $stmt->execute([$user_id]);

   if ($stmt->rowCount() > 0) {
   	  $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}

function check_favourite_book($con,$book_id) {
   $sql = "SELECT book_id FROM favorite_book WHERE book_id = ? LIMIT 1";
   $stmt = $con->prepare($sql);
   $stmt->execute([$book_id]);
   if($stmt->rowCount() > 0) {
      return true;
   } else {
      return false;
   }
}

function check_book_from_author($con,$book_id, $author_id) {
   $sql = "SELECT book_id FROM author_library WHERE book_id = ? and author_id = ?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$book_id, $author_id]);
   if($stmt->rowCount() > 0) {
      return true;
   } else {
      return false;
   }
}

function check_book($con,$book_id) {
   $sql = "SELECT book_id FROM author_library WHERE book_id = ?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$book_id]);
   if($stmt->rowCount() > 0) {
      return true;
   } else {
      return false;
   }
}

# Get  book by ID function
function get_book($con, $id){
   $sql  = "SELECT * FROM books WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $book = $stmt->fetch();
   }else {
      $book = 0;
   }

   return $book;
}


# Search books function
function search_books($con, $key){
   # creating simple search algorithm :) 
   $key = "%{$key}%";

   $sql  = "SELECT * FROM books 
            WHERE title LIKE ?
            OR description LIKE ?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$key, $key]);

   if ($stmt->rowCount() > 0) {
        $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}

# get books by category
function get_books_by_category($con, $id){
   $sql  = "SELECT * FROM books WHERE category_id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
        $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}


# get books by author
function get_books_by_author($con, $id){
   $sql  = "SELECT * FROM books 
   inner join author_library on books.id = author_library.book_id 
   inner join authors on author_library.author_id = authors.id
   WHERE authors.id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
        $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}