<?php
session_start();

require_once __DIR__ . '/backend/conection.php';


$category_id = null;
if (isset($_GET['category_id'])) {
	$category_id = $_GET['category_id'];
}

$category_query = "";

if ($category_id === null || $category_id == "") {
	$category_query = "";
} else {
	$category_query = " AND books.category_id = {$category_id}";
}


try {
	$sql = "SELECT books.id, books.title, books.img_url, CONCAT(authors.firstname, ' ', authors.lastname) as author_name, categories.title as category_title 
	FROM books JOIN authors ON books.author_id = authors.id JOIN categories ON books.category_id = categories.id WHERE books.deleted_at IS NULL {$category_query}";

	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo 'Error: ' . $e->getMessage();
}

try {
	$sql = 'SELECT categories.id, categories.title FROM categories WHERE categories.deleted_at IS NULL';

	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Library</title>
	<meta charset="utf-8" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<!-- Local CSS -->
	<link rel="stylesheet" href="./css/style.css" />
	<!-- Latest compiled and minified Bootstrap 4.4.1 CSS -->
	<link rel="stylesheet" href="./css/assets/bootstrap.min.css" />
	<!-- jQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- custom font -->
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
	<!-- Latest Font-Awesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous" />
	<script src="https://kit.fontawesome.com/3b2a155ba0.js" crossorigin="anonymous"></script>
</head>

<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg--nav px-5 position-fixed w-100">
			<div class="container">
				<a class="navbar-brand flex mx-lg-auto" href="index.php"><img src="./images/Logo.png" alt="logo image" class="logo d-block mx-auto mb-1">
					<p class="mb-0 font-weight-bold text-uppercase h6">brainster</p>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<div class=" mr-auto"></div>
					<div class="form-inline my-2 my-lg-0">
						<ul class="navbar-nav mr-auto text-center mx-auto">
							<?php if (isset($_SESSION['is_admin'])) { ?>
								<li class="nav-item mr-5">
									<a class="nav-link" href="./admin/dashboard.php">Dashboard</a>
								</li>
							<?php } ?>
							<?php if (!isset($_SESSION['username'])) { ?>
								<li class="nav-item nav--btn mr-2 mb-2 mb-md-0">
									<a class="nav-link" href="login.php">Login</a>
								</li>
								<li class="nav-item nav--btn">
									<a class="nav-link" href="register.php">Sign Up</a>
								</li>
							<?php } else { ?>
								<li class="nav-item nav--btn">
									<a class="nav-link" href="logout.php">Sign out</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</header>
	<main class="container">
		<div id="books" class="mt-3">
			<div class="mb-3">
				<p class="mb-1">Category</p>
				<form class="form-inline mb-2" action="" method="GET">
					<div>
						<select class="form-control d-inline-block" name="category_id" id="category_id">
							<option value="" selected>All</option>
							<?php
							foreach ($categories as $category) { ?>
								<option <?php if ($category['id'] == $category_id) { ?> selected <?php } ?> value="<?= $category['id'] ?>"> <?= $category['title'] ?></option>
							<?php } ?>
						</select>
					</div>
					<button type="submit" class="btn btn-info ml-2">Filter</button>
				</form>
			</div>
			<div class="row">
				<?php foreach ($books as $book) { ?>
					<a href="./book/book.php?id=<?= $book['id'] ?>" id="book">
						<div class="col-12 col-md-6 col-lg-4 mb-5 px-5 px-md-4">
							<div id="grow" class="card">
								<img class="card-img-top" src="<?= $book['img_url'] ?>" alt="Card image cap">
								<div class="card-body">
									<h2 id="title" class="card-title"><?= $book['title'] ?></h2>
									<h6 class="card-text mb-4 text-muted"><?= $book['author_name'] ?></h6>
									<p class="card-text"><?= $book['category_title'] ?></p>
									<div>
										<a href=""><i class="fa-regular fa-star"></i></a>
										<a href=""><i class="fa-regular fa-star"></i></a>
										<a href=""><i class="fa-regular fa-star"></i></a>
										<a href=""><i class="fa-regular fa-star"></i></a>
										<a href=""><i class="fa-regular fa-star"></i></a>
									</div>
								</div>
							</div>
						</div>
					</a>
				<?php } ?>
			</div>
		</div>
	</main>
	<footer class="text-center fixed-bottom py-3 bg-info">
		<div class="container">
			<p id="content" class="m-0 font-italic text-right">&nbsp;</p>
			<p class="mb-1 text-right">
				<span class="font-italic text-dark blockquote-footer font-weight-bolder" id="author-name">&nbsp;</span>
			</p>
		</div>
	</footer>

	<script src="./js/footer.js"></script>
	<!-- jQuery library -->
	<script src="./js/jquery-3.5.1.min.js"></script>
	<!-- Latest Compiled Bootstrap 4.4.1 JavaScript -->
	<script src="./js/popper.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
</body>

</html>