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
                <?php if (isset($_SESSION['user_id'])) { ?>
				<li class="nav-item">
                <li class="nav-item">
		          <a class="nav-link" 
		             href="add-book.php">Upload</a>
		        </li>
                <li class="nav-item">
		          <a class="nav-link" 
		             href="add-author.php">Add Author</a>
		        </li>
					<?php if($user_role = $_SESSION['user_role'] == "admin") { ?>
		          	<a class="nav-link" 
		             href="admin.php">Admin</a>
					<?php } else { ?> 
					<a class="nav-link" 
		             href="user.php">Your Library</a>
					<?php } ?> 
                </li>
                <li class="nav-item">
		          <a class="nav-link" 
		             href="favorite.php">Favorite</a>
		        </li>
                <li class="nav-item">
		          <a class="nav-link" 
		             href="logout.php">Logout</a>
		        </li>
				<?php }else{ ?>
                <li>
		          <a class="nav-link" 
		             href="login.php">Login</a>
		          <?php } ?>
		        </li>
                <?php ?>
		      </ul>
		    </div>
		  </div>
		</nav>