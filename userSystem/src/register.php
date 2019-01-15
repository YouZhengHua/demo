<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>註冊</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./css/myCss.css">

<header>
	<nav class="navbar navbar-expand navbar-dark fixed-top bg-dark">
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="index.php">留言板</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="login.php">登入</a>
			</li>
		</ul>
	</nav>
</header>

<div class="container haveNavbar">
	<div class="row">
		<div class="col-6 mx-auto text-center">
			<h1 class="h3 mb-3 font-weight-normal">註冊</h1>
			<?php
				if(isset($_COOKIE["errMsg"])){
			?>
					<div class="alert alert-danger" role="alert"><?php echo $_COOKIE["errMsg"]; ?></div>
			<?php		
					setcookie("errMsg", "");
				}
			?>
			
			<form action="add_users.php" method="POST">
				<div class="input-group">
					<div class="input-group-prepend mb-3">
						<span class="input-group-text" id="basic-addon1">帳號</span>
					</div>
					<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="userAccount">
				</div>
				<div class="input-group">
					<div class="input-group-prepend mb-3">
						<span class="input-group-text" id="basic-addon1">密碼</span>
					</div>
					<input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" name="password">
				</div>
				<div class="input-group">
					<div class="input-group-prepend mb-3">
						<span class="input-group-text" id="basic-addon1">暱稱</span>
					</div>
					<input type="text" class="form-control" placeholder="Nickname" aria-label="Nickname" aria-describedby="basic-addon1" name="nickname">
				</div>
				<button class="btn btn-primary .btn-lg mt-3" type="submit">註冊</button>
			</form>
		</div>
	</div>
</div>