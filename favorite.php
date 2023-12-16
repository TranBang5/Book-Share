<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {
	$user_role=$_SESSION['user_role'];
    
    $user_id = $_SESSION['user_id'];
	# Database Connection File
	include "db_conn.php";

	# Book helper function
	include "php/func-book.php";
    $books = get_favorite_book($conn,$user_id);

    # author helper function
	include "php/func-author.php";
    $fav_authors = get_favorite_author($conn,$user_id);
	$authors = get_all_author($conn);


	include "php/func-category.php";
    $categories = get_all_categories($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>USER PAGE</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
<?php include "nav-bar.php" ?>
       <div class="mt-5"></div>
        <?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
			  <?=htmlspecialchars($_GET['error']); ?>
		  </div>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
			  <?=htmlspecialchars($_GET['success']); ?>
		  </div>
		<?php } ?>


        <?php  if ($books == 0) { ?>
        	<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/empty.png" 
        	          width="100">
        	     <br>
                You don't have any favorite books
		  </div>
        <?php }else {?>


        <!-- List of all books -->
		<h4>All Books</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Author</th>
					<th>Description</th>
					<th>Category</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			  <?php 
			  $i = 0;
			  foreach ($books as $book) {
			    $i++;
			  ?>
			  <tr>
				<td><?=$i?></td>
				<td>
					<img width="100"
					     src="uploads/covers/<?=$book['cover']?>" >
					<a  class="link-dark d-block
					           text-center"
					    href="uploads/files/<?=$book['file']?>">
					   <?=$book['title']?>	
					</a>
						
				</td>
				<td><?=$book['author_name']?>
				</td>
				<td><?=$book['description']?></td>
				<td>
					<?php if ($categories == 0) {
						echo "Undefined";}else{ 

					    foreach ($categories as $category) {
					    	if ($category['id'] == $book['category_id']) {
					    		echo $category['name'];
					    	}
					    }
					}
					?>
				</td>
				<td>
					<a href="display-book.php?pdf_link=<?=$book['file']?> & book_id=<?php echo $book['id'] ?>" 
					   class="btn btn-warning">
					   Read</a>

					<a href="php/remove-favorite-book.php?book_id=<?=$book['id']?> & location=index" 
					   class="btn btn-danger">
				       Remove</a>
				</td>
			  </tr>
			  <?php } ?>
			</tbody>
		</table>
	   <?php }?>

	    <?php  if ($fav_authors == 0) { ?>
        	<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/empty.png" 
        	          width="100">
        	     <br>
			  You don't have any favorite authors
		    </div>
        <?php }else {?>
	    <!-- List of all Authors -->
		<h4 class="mt-5">All Authors</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Author</th>
					<th>Bio</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$k = 0;
				foreach ($fav_authors as $fav_author ) {
				$k++;	
				?>
				<tr>
					<td><?=$k?></td>
					<td>
					<img width="100"
					     src="uploads/portraits/<?=$fav_author['author_portrait']?>" >
					<a  class="link-dark d-block
					           text-center"
					    href="author.php?id=<?=$fav_author['id']?>">
					   <?=$fav_author['name']?>	
					</a>
						
				</td>
					<td><?=$fav_author['author_bio']?></td>
					<td>
						<a href="author.php?id=<?=$fav_author['id']?>" 
						   class="btn btn-warning">
						   Visit</a>

						<a href="php/remove-favorite-author.php?author_id=<?=$fav_author['id']?>&location=index" 
						   class="btn btn-danger">
					       Remove</a>
					</td>
				</tr>
			    <?php } ?>
			</tbody>
		</table> 
		<?php } ?>
	</div>
</body>
</html>

<?php }else{
  header("Location: login.php");
  exit;
} ?>