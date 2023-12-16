<?php 

# Get all Author function
function get_all_author($con){
   $sql  = "SELECT * FROM authors";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $authors = $stmt->fetchAll();
   }else {
      $authors = 0;
   }

   return $authors;
}

function get_user_author($con, $id){
   $sql  = "SELECT * FROM authors WHERE user_id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $author = $stmt->fetch();
   }else {
      $author = 0;
   }

   return $author;
}

# Get favorite books
function get_favorite_author($con, $user_id) {
   $sql  = "SELECT * FROM authors
   inner join favorite_author on authors.id = favorite_author.author_id  
   where favorite_author.user_id = ? ORDER BY authors.id DESC";
   $stmt = $con->prepare($sql);
   $stmt->execute([$user_id]);

   if ($stmt->rowCount() > 0) {
   	  $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}

# Get  Author by ID function
function get_author($con, $id){
   $sql  = "SELECT * FROM authors WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $author = $stmt->fetch();
   }else {
      $author = 0;
   }

   return $author;
}

function check_favorite_author($con, $id) {
   $sql = "SELECT author_id FROM favorite_author WHERE author_id = ? LIMIT 1";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);
   if($stmt->rowCount() > 0) {
      return true;
   } else {
      return false;
   }
}

function get_author_by_book($con, $id) {
   $sql  = "SELECT * FROM authors 
   inner join books on books.author_id = authors.id
   WHERE books.id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $author = $stmt->fetch();
   }else {
      $author = 0;
   }

   return $author;
}

