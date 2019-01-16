<?php require_once('./../conn.php'); ?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>購物</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/myJS.js"></script>
</head>

<body>

	<!-- 網站內容 -->
	<div class="container mt-5">
		<!-- 標題 -->
		<div class="row">
			<div class="col mx-auto">
				<h3 class="webTitle text-center">商品清單</h3>
			</div>
		</div>

		<!-- 商品清單 -->
		<div class="itemList row">
			<?php 
				$stmt = $conn->prepare("SELECT * FROM marin_items a ORDER BY id");
				$stmt->execute();
				while($resultRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
			?>
			<div class="col-lg-4 mb-3">
				<div class="item card" value="<?php echo $resultRow['id']; ?>">
					<div class="item__name card-header" value="<?php echo $resultRow['item_name']; ?>"><?php echo $resultRow['item_name']; ?></div>
					<div class="card-body">
						<h5 class="item__price card-title text-truncate" value="<?php echo isset($resultRow['discount']) ? $resultRow['discount'] : $resultRow['price']; ?>">價格：<?php echo isset($resultRow['discount']) ? $resultRow['discount'] : $resultRow['price']; ?></h5>
						<p class="item__quantity card-text" value="<?php echo $resultRow['quantity']; ?>">庫存數量：<?php echo $resultRow['quantity']; ?></p>
						<p class="card-text"><?php echo $resultRow['content']; ?></p>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1">訂購數量</span>
							</div>
							<input type="text" class="item__orderQty form-control" placeholder="0" aria-label="0" aria-describedby="basic-addon1">
							<button type="button" class="addItem btn btn-outline-success">加入購物車</button>
						</div>
					</div>
				</div>
			</div>
			<?php 
				}
				$stmt = null;
			?>
		</div>

		<!-- 購物車 -->
		<div class="shoppingCart row mb-3" style="display: none">
			<div class="card mx-auto col-lg-10 p-0">
				<table class="table table-responsive-lg mb-0 table-hover">
					<thead>
						<tr class="align-middle">
							<th scope="col">#</th>
							<th scope="col">商品名稱</th>
							<th scope="col" class="text-right">價格</th>
							<th scope="col" class="text-right">訂購數量</th>
							<th scope="col" class="text-right">小計</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody class="shoppingCart__items">
					</tbody>
				</table>
			</div>
		</div>

		<!-- 訂單資訊 -->
		<div>
			<!-- 訂單主檔 -->
			<div class="orderList row mb-3" style="display: none">
				<div class="card mx-auto col-lg-10 p-0">
					<table class="table table-responsive-lg mb-0 table-hover">
						<thead>
							<tr class="align-middle">
								<th scope="col">#</th>
								<!-- <th scope="col">訂購者</th> -->
								<th scope="col" class="text-center">下單日期及時間</th>
								<th scope="col" class="text-right">訂單金額</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$stmt = $conn->prepare("SELECT a.id, a.order_date, a.order_total, CASE WHEN b.nickname IS NULL OR b.nickname = '' THEN b.username ELSE b.nickname END AS nickname FROM marin_order a LEFT JOIN marin_users b ON b.id = a.order_user ORDER BY a.id");
								$stmt->execute();
								$index = 1;
								while($resultRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
							?>
							<tr class="orderList--dataRow">
								<th scope="row"><?php echo $index++; ?></th>
								<!-- <td><?php echo $resultRow['nickname']; ?></td> -->
								<td class="text-center"><?php echo $resultRow['order_date']; ?></td>
								<td class="text-right"><?php echo $resultRow['order_total']; ?></td>
								<td class="text-center"><button class="btn--showOrderDetail btn btn-sm btn-outline-info" data-orderId="<?php echo $resultRow['id']; ?>">顯示明細</button></td>
							</tr>
							<?php 
								}
								$stmt = null;
							?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- 訂單明細 -->
			<div class="orderDetail row mb-3" style="display: none;">
				<div class="card mx-auto col-lg-10 p-0">
					<div class="card-header">訂單明細</div>
					<div class="card-body">
						<table class="table table-responsive-lg mb-0 table-hover">
							<thead>
								<tr class="align-middle">
									<th scope="col">#</th>
									<th scope="col">商品</th>
									<th scope="col" class="text-right">價格</th>
									<th scope="col" class="text-right">數量</th>
									<th scope="col" class="text-right">小計</th>
								</tr>
							</thead>
							<tbody class="orderDetail--items">
								<tr>
									<th scope="row"><?php echo $index++; ?></th>
									<td><?php echo $resultRow['nickname']; ?></td>
									<td class="text-right"><?php echo $resultRow['order_date']; ?></td>
									<td class="text-right"><?php echo $resultRow['order_price']; ?></td>
									<td class="text-right"><button class="btn--showOrderDetail btn btn-sm btn-outline-info" data-orderId="<?php echo $resultRow['id']; ?>">顯示明細</button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="text-center">
			<button class="btn--showShoppingCart btn but-lg btn-outline-info">查看購物車&nbsp;(&nbsp;<span class="shoppingCart--length">0</span>&nbsp;)</button>
			<button class="btn--showOrders btn but-lg btn-outline-info">查看訂單</button>
			<form class="form__order" action="create_order.php" method="POST">
				<button class="btn--checkout btn but-lg btn-outline-success" style="display: none;">我要結帳</button>
				<input type="hidden" name="shoppingCart__dataList" class="form__order--dataList">
				<input type="hidden" name="shoppingCart__total" class="form__order--total">
				<button class="btn--cancel btn but-lg btn-outline-danger" style="display: none;">繼續購買</button>
			</form>
		</div>

	</div>
	<?php
		$conn = null;
	?>
</body>