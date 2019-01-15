<?php
	require_once('./../conn.php');
	$userAccount = $_POST['userAccount'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$nickname = (!isset($_POST['nickname']) || $_POST['nickname'] === '') ? null : $_POST['nickname'];
	$stmt = $conn->prepare("SELECT COUNT(*) FROM marin_users WHERE username = :userAccount OR (nickname IS NOT NULL AND nickname = :nickname)");
	$stmt->execute(array(
		'userAccount' => $userAccount,
		'nickname' => $nickname
	));
	if($stmt->fetchColumn() == 0){
		$stmt = null;
		$stmt = $conn->prepare("INSERT INTO marin_users (username, password, nickname) VALUES (:userAccount, :password, :nickname)");
		if($stmt->execute(array(
			'userAccount' => $userAccount,
			'password' => $password,
			'nickname' => $nickname
		))){
			$_SESSION["userId"] = $conn ->lastInsertId();
			$_SESSION["userName"] = $nickname === null ? $userAccount : $nickname;

			header('Location: index.php');
		}
		else{
			$errMsg = "註冊失敗";
			setcookie("errMsg", $errMsg);
			header('Location: register.php');
		}
	}
	else{
		$errMsg = "帳號或暱稱已被註冊";
		setcookie("errMsg", $errMsg);
		header('Location: register.php');
	}
	$stmt = null;
	$conn = null;
	exit;
?>