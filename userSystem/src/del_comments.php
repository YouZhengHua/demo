<?php
	require_once('./../conn.php');
	
	$result = null;
	$rtnCde = "success";

	if(isset($_SESSION["userId"])){
		$postId = $_POST['commentId'];
		$stmt = $conn->prepare("SELECT COUNT(*) as count FROM marin_comments c WHERE c.crt_user_id = :crt_user_id AND c.id = :id");
		$stmt->execute(array(
			'crt_user_id' => $_SESSION["userId"],
			'id' => $postId
		));
		$count = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($count[0]['count'] == 1){
			$stmt = null;
			
			$stmt = $conn->prepare("DELETE FROM marin_comments WHERE id = :id OR parent_id = :id");
			if(!$stmt->execute(array(
				'id' => $postId))){
				$rtnCde = "fail";
			}
			$stmt = null;
		}
		else{
			$stmt = null;
			$rtnCde = "fail";
		}
	}
	$conn = null;

	$result["rtnCde"] = $rtnCde;
	echo json_encode($result);
?>