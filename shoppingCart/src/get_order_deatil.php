<?php
	require_once('./../conn.php');
	$orderPid = $_GET['orderPid'];
	$stmt = $conn->prepare("SELECT a.order_item_price, a.order_item_qty, a.order_item_price * a.order_item_qty as order_sum, b.item_name FROM marin_orderItems a JOIN marin_items b ON b.id = a.order_item_id WHERE a.order_pid = :orderPid");
	$stmt->execute(array(
		'orderPid' => $orderPid
	));
	$dataList = array();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		array_push($dataList, $row);
	}
	$result['dataList'] = $dataList;	
	$result['rtnCde'] = 'success';
	echo json_encode($result);
?>