<?php 
	require_once('./../conn.php');

	$orderList = json_decode($_POST['shoppingCart__dataList']);
	$orderTotal = $_POST['shoppingCart__total'];

	$conn->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
	$conn->beginTransaction();
	try{
		//新增訂單
		$stmt = $conn->prepare("INSERT INTO marin_order (order_user, order_total) VALUES (1, :orderTotal)");
		$stmt->execute(array(
			'orderTotal' => $orderTotal
		));

		$order_pid = $conn->lastInsertId();
		$stmt = null;

		foreach ($orderList as $orderItem) {

			// 新增訂單明細
			$stmt = $conn->prepare("INSERT INTO marin_orderItems (order_pid, order_item_id, order_item_price, order_item_qty) VALUES (:order_pid, :order_item_id, :order_item_price, :order_item_qty)");
			$order_item_id = intval($orderItem->itemId);
			$order_item_price = doubleval($orderItem->itemPrice);
			$order_item_qty = $orderItem->itemOrderQty;
			$stmt->execute(array(
				'order_pid' => $order_pid,
				'order_item_id' => $order_item_id,
				'order_item_price' => $order_item_price,
				'order_item_qty' => $order_item_qty
			));
			$stmt = null;

			//更新庫存資料
			$stmt = $conn->prepare("UPDATE marin_items SET quantity = quantity - :order_item_qty WHERE id = :order_item_id");
			$stmt->execute(array(
				'order_item_qty' => $order_item_qty,
				'order_item_id' => $order_item_id
			));
			$stmt = null;

			$stmt = $conn->prepare("SELECT quantity FROM marin_items WHERE id = :order_item_id for update");
			$stmt->execute(array(
				'order_item_id' => $order_item_id
			));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = null;

			// 判斷更新後庫存是否為負數，如為負數則取消訂單。
			if($result['quantity'] < 0){
				$_SESSION['ERROR_MSG'] = "訂單取消，庫存數量不得為負數。";
				throw new Exception();
			}
		}

		$conn->commit();
		$conn = null;
		$_SESSION['MSG'] = "訂單新建完成";
		header("Location: isSuccess.php");
	}
	catch(Exception $e){
		if(!isSet($_SESSION['ERROR_MSG'])){
			$_SESSION['ERROR_MSG'] = $e->getMessage();
		}
		$conn->rollback();
		$conn = null;
		header("Location: isFail.php");
	}
	catch(Throwable $e){
		if(!isSet($_SESSION['ERROR_MSG'])){
			$_SESSION['ERROR_MSG'] = $e->getMessage();
		}
		$conn->rollback();
		$conn = null;
		header("Location: isFail.php");
		
	}
	finally{
		exit;
	}
?>