<?php
	require_once('./../conn.php');
	$result["rtnCde"] = "fail";
	if(isset($_SESSION["userId"]) && (isset($_POST['contnet']) && $_POST['contnet'] !== "")){
		$commentId = 197;
		$contnet = $_POST['contnet'];
		if(isset($_POST['parentId']) && $_POST['parentId'] !== ""){
			$stmt = $conn->prepare("INSERT INTO marin_comments (crt_user_id, contnet, parent_id) VALUES (:crt_user_id, :contnet, :parent_id)");
			if($stmt->execute(array(
				'crt_user_id' => $_SESSION["userId"],
				'contnet' => $contnet,
				'parent_id' => $_POST['parentId']
			))){
				$commentId = $conn->lastInsertId();
			}
			$stmt = null;
		}
		else{
			$stmt = $conn->prepare("INSERT INTO marin_comments (crt_user_id, contnet) VALUES (:crt_user_id, :contnet)");
			if($stmt->execute(array(
				'crt_user_id' => $_SESSION["userId"],
				'contnet' => $contnet,
			))){
				$commentId = $conn->lastInsertId();
			}
			$stmt = null;
		}

		$stmt = $conn->prepare("SELECT a.id, a.crt_time, a.contnet, case when b.nickname IS NULL THEN b.username ELSE b.nickname END AS crt_user FROM marin_comments a JOIN marin_users b ON a.crt_user_id = b.id WHERE a.id = :commentId ");
		$stmt->execute(array(
				'commentId' => $commentId
			));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
		$result["rtnCde"] = "success";
	}
	$conn = null;
	echo json_encode($result);
?>