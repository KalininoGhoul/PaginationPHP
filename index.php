<?php
	session_start();

	$db = new PDO('mysql:host=localhost;dbname=reviews', 'root');

    $page = $_GET['page'] ?? 1;
    $perPage = 5;
    $limitOffset = $perPage * ( $page - 1 );
	$total = $db->query("SELECT COUNT(*) AS count FROM reviews")->fetch(PDO::FETCH_ASSOC);
	$lastPage = ceil( $total['count'] / $perPage );

	if ($lastPage == 0) $lastPage = 1;

    $reviews = $db->query("SELECT * FROM reviews ORDER BY `date` DESC limit {$limitOffset}, {$perPage}")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">  
		<title>Гостевая книга</title>
		<link rel="stylesheet" href="/css/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="/css/styles.css">
	</head>
	<body>
		<div id="wrapper">
			<h1>Гостевая книга</h1>
			<div>
				<nav>
				  <ul class="pagination">
				  	<li <?php if($page == 1):?>class="disabled"<?php endif;?> >
						<a href="?page=1"  aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>

					<?php for ($i = 1; $i <= $lastPage; $i++): ?>
						<li <?php if($i == $page):?>class="active"<?php endif;?> >
							<a href="?page=<?=$i?>"><?=$i?></a>
						</li>
					<?php endfor; ?>

					<li <?php if($lastPage == $page):?>class="disabled"<?php endif;?>>
						<a href="?page=<?=$lastPage?>" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				  </ul>
				</nav>
			</div>

			<?php foreach($reviews as $review):?>
				<div class="note">
					<p>
						<span class="date"><?=$review['date']?></span>
						<span class="name"><?=$review['user']?></span>
					</p>
					<p><?=$review['review']?></p>
				</div>
			<?php endforeach; ?>

			<?php if( isset($_SESSION['message']) ):?>
				<div class="info alert alert-info"><?=$_SESSION['message']?></div>
			<?php endif; ?>

			<?php unset($_SESSION['message']);?>
			
			<div id="form">
				<form action="/reviews.php" method="POST">
					<p><input class="form-control" placeholder="Ваше имя" name="user"></p>
					<p><textarea class="form-control" placeholder="Ваш отзыв" name="review"></textarea></p>
					<p><input type="submit" class="btn btn-info btn-block" value="Сохранить"></p>
				</form>
			</div>
		</div>
	</body>
</html>

