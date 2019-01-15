<?php 
	require_once('./../conn.php');
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>留言板</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="./css/myCss.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="./js/myJS.js"></script>
</head>

<body>

	<!-- 頂端列 -->
	<header>
		<nav class="navbar navbar-expand navbar-dark fixed-top bg-dark">
			<ul class="navbar-nav">
			<?php if(!isset($_SESSION["userName"])) {?>
				<li class="nav-item active">
					<a class="nav-link" href="login.php">登入</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="register.php">註冊</a>
				</li>
			<?php } else { ?>
				<li class="nav-item active">
					<a class="nav-link" href="logout.php">登出</a>
				</li>
			<?php } ?>
			</ul>
		</nav>
	</header>

	<!-- 網站內容 -->
	<div class="container haveNavbar">
		<!-- 標題 -->
		<div class="row">
			<div class="col mx-auto">
				<h3 class="text-center">留言板</h3>
			</div>
		</div>

		<!-- 留言區 -->
		<div class="row">
			<div class="main__from col div-border">
				<div class="main__nickname">
					<?php echo isset($_SESSION["userName"]) ? $_SESSION["userName"] : "請先登入"; ?>
				</div>
				<div>
					<textarea class="wt-100" name="contnet" placeholder="留言內容"></textarea>
				</div>
				<div>
				<?php if(!isset($_SESSION["userName"])) {?>
					<a href="login.php">
						<input class="btn btn-primary btn-lg" type="button" value="請先登入" />
					</a>
				<?php } else { ?>
					<input class="btn btn-primary btn-lg" type="button" value="留言">
				<?php }?>
				</div>
			</div>
		</div>

		<!-- 顯示留言 -->
		<div class="main__posts">
		<?php
			require('get_comments.php');
		?>
		</div>

		<!-- 換頁按鈕 -->
		<div class="row">
			<div class="main__pages col">
				<?php
					$stmt = $conn->prepare("SELECT COUNT(id) AS COUNT  FROM marin_comments a WHERE parent_id IS NULL");
					$stmt->execute();
					$result = $stmt->fetchColumn();
					$stmt = null;
					$maxPage = ceil($result / 10);
					$page = 1;
					do{
				?>
					<div class="main__pages--btn">
						<button class="btn btn-secondary btn-sm" onclick="location.href='index.php?page=<?php echo $page; ?>';" <?php echo $page == $showPage ? "disabled" : ""; ?>>Page.<?php echo $page; ?></button>
					</div>
				<?php
					$page++;
					}while($page <= $maxPage);
				?>
			</div>
		</div>
	</div>
	<?php
		$conn = null;
	?>
</body>