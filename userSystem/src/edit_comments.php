<?php
	require_once('./../conn.php');
	
	if(isset($_SESSION["userId"]) && (isset($_POST['contnet']) && $_POST['contnet'] !== "")){
		$postId = $_POST['commentId'];
		$stmt = $conn->prepare("SELECT COUNT(*) as count FROM marin_comments c WHERE c.crt_user_id = :crt_user_id AND c.id = :id");
		$stmt->execute(array(
			'crt_user_id' => $_SESSION["userId"],
			'id' => $postId
		));
		$count = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($count[0]['count'] == 1){
			$contnet = $_POST['contnet'];
			$stmt = $conn->prepare("UPDATE marin_comments SET contnet = :contnet WHERE id = :id");
			$stmt->execute(array(
				'contnet' => $contnet,
				'id' => $postId
			));
			$stmt = null;
		}
		else{
			$stmt = null;
		}
	}
	$conn = null;

	$url = "index.php";

	header('Location: '.$url);
?>