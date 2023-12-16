<?php 
session_start();

# If not author ID is set
if (!isset($_GET['id'])) {
	header("Location: index.php");
	exit;
}
if (isset($_SESSION['user_id'])) {
	$user_role = $_SESSION['user_role'];
}
# Get author ID from GET request
$id = $_GET['id'];

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_books_by_author($conn, $id);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);
$current_author = get_author($conn, $id);


# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$current_author['name']?></title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
	<?php include "nav-bar.php" ?>
		<h1 class="display-4 p-3 fs-3"> 
			<a href="index.php"
			   class="nd">
				<img src="img/back-arrow.PNG" 
				     width="35">
			</a>
		   <?=$current_author['name']?>
		   <?php if (isset($_SESSION['user_id'])) {
			if (!check_favorite_author($conn,$id)) { ?>
            <a href="php/add-favorite-author.php?author_id=<?php echo $id?> & location=display"
            class="btn btn-primary">Add to Favorite</a>
        <?php } else { ?>
            <a href="php/remove-favorite-author.php?author_id=<?php echo $id?> & location=display"
		    class="btn btn-primary">Remove from Favorite</a>
        <?php } ?>
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
		<a href="add-book-to-author.php?author_id=<?php echo $id?>"
            class="btn btn-primary">Add Book</a>
		<?php } ?>
		</h1>
		<div style="display: inline-block; border: 2px solid #000; padding: 10px;"><img width="200" height="200" src="uploads/portraits/<?=$current_author['author_portrait']?>"></div>
		<div style="display: inline-block; width: 800px; border: 2px; padding 10px; font-family:'Times New Roman', Times, serif; font-size: 16px; line-height:25px"><?php echo $current_author['author_bio']; ?></div>
		
		<div class="d-flex pt-3">
		<?php if ($books == 0){ ?>
				<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/empty.png" 
        	          width="100">
        	     <br>
			    There is no book in the database
		       </div>
			<?php }else{ ?>
			<div class="pdf-list d-flex flex-wrap">
				<?php foreach ($books as $book) { ?>
				<div class="card m-1" >
					<img src="uploads/covers/<?=$book['cover']?>"
					     class="card-img-top" style="width:100%; max-width: 300px; max-height:400px">
					<div class="card-body">
						<h5 class="card-title">
							<?=$book['title']?>
						</h5>
						<p class="card-text" style="max-height: 300px; overflow:scroll">
							<i><b>By:
								<?php foreach($authors as $author){ 
									if ($author['id'] == $book['author_id']) {
										echo $author['name'];
										break;
									}
								 } ?>
							<br></b></i>
							<i><?=$book['description']?></i>
							<br><i><b>Category:
								<?php foreach($categories as $category){ 
									if ($category['id'] == $book['category_id']) {
										echo $category['name'];
										break;
									}
								?>

								<?php } ?>
							<br></b></i>
						</p>
                       <a href="display-book.php?pdf_link=<?=$book['file']?> & book_id=<?php echo $book['id'] ?>"
                          class="btn btn-success">Read</a>
						<?php if (isset($_SESSION['user_id'])) { ?>
                        <a href="uploads/files/<?=$book['file']?>"
                          class="btn btn-primary"
                          download="<?=$book['title']?>">Download</a>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php } ?>

		<div class="category">
			<!-- List of categories -->
			<div class="list-group">
				<?php if ($categories == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Category</a>
				   <?php foreach ($categories as $category ) {?>
				  
				   <a href="category.php?id=<?=$category['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$category['name']?></a>
				<?php } } ?>
			</div>

			<!-- List of authors -->
			<div class="list-group mt-5">
				<?php if ($authors == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Author</a>
				   <?php foreach ($authors as $author ) {?>
				  
				   <a href="author.php?id=<?=$author['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$author['name']?></a>
				<?php } } ?>
			</div>
		</div>
		</div>
	</div>
</body>
</html>