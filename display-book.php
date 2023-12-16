<?php 
session_start();
if(isset($_SESSION['user_id'])){
	$user_role = $_SESSION['user_role'];}
$pdf_link = $_GET['pdf_link'];
$book_id = $_GET['book_id'];
# Database Connection File
include "db_conn.php";
include "php/func-book.php";
# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="index.php">MyLibrary</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link" 
		             aria-current="page" 
		             href="index.php">Explore</a>
		        </li>
				<?php if(isset($_SESSION['user_id'])) {?>
				<li class="nav-item">
					<?php if($user_role = $_SESSION['user_role'] == "admin") { ?>
		          	<a class="nav-link" 
		             href="admin.php">Admin</a>
					<?php } else { ?> 
					<a class="nav-link" 
		             href="user.php">Your Library</a>
					<?php } ?>
				<li class="nav-item">
		          <a class="nav-link" 
		             href="add-book.php">Upload</a>
		        </li>
				<li>
					<?php if ($user_role == 'admin') { ?>
						<a class="nav-link" 
						href="add-category.php">Category</a>
					<?php } ?>
				</li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-author.php">Author</a>
		        </li>
				<li class="nav-item">
		          <a class="nav-link" 
		             href="logout.php">Logout</a>
		        </li>	
				</li> 
				<?php } else{ ?>
				<li>
		          <a class="nav-link" 
		             href="login.php">Login</a>
		          <?php } ?>
				</li>
		      </ul>
		    </div>
		  </div>
		</nav>
        <a href="uploads/files/<?=$pdf_link?>"
            class="btn btn-success">Full Size</a>

		<?php if (isset($_SESSION['user_id'])) { ?>	
        <a href="uploads/files/<?=$pdf_link?>"
            class="btn btn-primary"
            download="<?=$pdf_link?>">Download</a>
        <?php if (!check_favourite_book($conn,$book_id)) { ?>
            <a href="php/add-favorite-book.php?book_id=<?php echo $book_id?> & pdf_link=<?=$pdf_link?> & location=display"
            class="btn btn-primary">Add to Favorite</a>
        <?php } else { ?>
            <a href="php/remove-favorite-book.php?book_id=<?php echo $book_id?> & pdf_link=<?=$pdf_link?> & location=display"
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
		<?php } }?>
        <div class="d-flex pt-3">
		<embed type="application/pdf" src="uploads/files/<?= $pdf_link ?>" width="1000" height="800">
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