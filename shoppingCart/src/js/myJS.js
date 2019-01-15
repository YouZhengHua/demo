const shoppingCart = new Array();

/**
	增加訂購商品資訊至購物車
**/
function addItemToShoppingCart(element){
	const regExp = new RegExp('^\\d+$');
	if($(element).find(".item__orderQty").prop("value") !== "" && regExp.test($(element).find(".item__orderQty").prop("value")) && Number($(element).find(".item__orderQty").prop("value")) > 0){
		const itemId = $(element).attr("value");
		const itemName = $(element).find(".item__name").attr("value");
		const itemPrice = Number($(element).find(".item__price").attr("value"));
		// let itemQuantity = Number($(element).find(".item__quantity").attr("value"));
		const itemOrderQty = Number($(element).find(".item__orderQty").prop("value"));
		const itemCost = itemPrice * itemOrderQty;

		const orderItem = {
			itemId:itemId,
			itemName:itemName,
			itemPrice:itemPrice,
			itemOrderQty,itemOrderQty,
			itemCost,itemCost
		}

		shoppingCart.push(orderItem);
		$(".shoppingCart--length").text(shoppingCart.length);
		$(element).find(".item__orderQty").prop("value", "");
		$(".btn--showShoppingCart").focus();
	}
	else{
		alert("請輸入大於 0 的整數");
	}
}

/**
	產生購物車內容
**/
function createShoppingCart(){

	// 先將前次的總金額
	let orderTotal = 0;

	// 將現有清單清空
	$(".shoppingCart__items").empty();

	// 重新產出購物車清單
	shoppingCart.map((element, index) => {

		orderTotal += element.itemCost;

		$(".shoppingCart__items").append(`
			<tr>
				<th scope="row">${index+1}</th>
				<td>${element.itemName}</td>
				<td class="text-right">${element.itemPrice}</td>
				<td class="text-right">${element.itemOrderQty}</td>
				<td class="text-right">${element.itemCost}</td>
				<td class="text-center"><button type="button" class="delItem btn btn-sm btn-outline-danger" value="${index}">刪除</button></td>
			</tr>
		`);
	});

	// 產生總計
	$(".form__order--total").val(orderTotal);
	$(".shoppingCart__items").append(`
		<tr>
			<td></td>
			<th scope="row" >合計</th>
			<th colspan="3" scope="row" class="text-right" >${orderTotal}</th>
			<td></td>
		</tr>
	`);
}

/**
	刪除購物車內容
**/
function delItemFromShoppingCart(index){
	shoppingCart.splice(index, 1);
	createShoppingCart();
	$(".shoppingCart--length").text(shoppingCart.length);
}

/**
	重設顯示訂單頁面
**/
function resetOrderViewPage(){
	$(".orderList--dataRow").removeClass("table-info");
	$(".orderDetail--items").empty();
	$(".orderDetail").hide();
}

/**
	取得訂單明細
**/
function getOrderDeatil(order_pid){
	$.ajax({
		type:'GET',
		url:'get_order_deatil.php',
		data:{
			orderPid:order_pid
		},
		success: function(resp){
			$(".orderDetail").show();
			$(".orderDetail--items").empty();
			let res = JSON.parse(resp);
			if(res.rtnCde === "success"){
				res.dataList.map((element, index) => {
					$(".orderDetail--items").append(`
						<tr>
							<th scope="row">${index+1}</th>
							<td>${element.item_name}</td>
							<td class="text-right">${element.order_item_price}</td>
							<td class="text-right">${element.order_item_qty}</td>
							<td class="text-right">${element.order_sum}</td>
						</tr>
					`);	
				});
			}
			
		},
		error: function(){
			console.log("error");
		}
	});
}

$(document).ready(function(){
	/**
		新增商品至購物車
	**/
	$(".itemList").on("click", ".addItem", (element)=>{
		addItemToShoppingCart($(element.currentTarget).parents(".item"));
	});

	/**
		刪除購物車的商品
	**/
	$(".shoppingCart").on("click", ".delItem", (element) => {
		delItemFromShoppingCart(element.currentTarget.value);
	});

	/**
		顯示購物車
	**/
	$(".btn--showShoppingCart").bind("click", (element) => {
		const domElement = element.currentTarget;
		$(".itemList").hide();
		$(".orderList").hide();
		$(".webTitle").text("購物車");
		createShoppingCart();
		$(".shoppingCart").show();
		$(domElement).hide();
		$(".btn--checkout").show();
		$(".btn--cancel").show();
		$(".btn--showOrders").hide();
	});

	/**
		繼續購買
	**/
	$(".btn--cancel").bind("click", (element) => {
		const domElement = element.currentTarget;
		$(".shoppingCart").hide();
		$(".orderList").hide();
		$(".webTitle").text("商品清單");
		$(".itemList").show();
		$(".btn--showShoppingCart").show();
		$(".btn--checkout").hide();
		$(domElement).hide();
		$(".btn--showOrders").show();
		return false;
	});

	/**
		查看訂單
	**/
	$(".btn--showOrders").bind("click", (element) => {
		const domElement = element.currentTarget;
		if($(domElement).text() === "查看訂單"){
			$(".shoppingCart").hide();
			$(".itemList").hide();
			$(".webTitle").text("當前所有訂單");
			$(".orderList").show();
			$(".btn--showShoppingCart").hide();
			$(".btn--checkout").hide();
			$(".btn--cancel").hide();
			$(domElement).text("返回商品清單");
		}
		else{
			$(".shoppingCart").hide();
			$(".orderList").hide();
			$(".webTitle").text("商品清單");
			$(".itemList").show();
			$(".btn--showShoppingCart").show();
			$(".btn--checkout").hide();
			$(".btn--cancel").hide();
			$(domElement).text("查看訂單");
		}
		resetOrderViewPage();
	});

	/**
		我要結帳
	**/
	$(".btn--checkout").bind("click", (element) => {
		const domElement = element.currentTarget;
		if(shoppingCart.length === 0){
			$(domElement).text("至少購買一個商品才能進行結帳");
			$(domElement).addClass("btn-outline-danger");
			$(domElement).mouseout(() => {
				$(domElement).text("我要結帳");
				$(domElement).removeClass("btn-outline-danger");
			});
			$(domElement).focusout(() => {
				$(domElement).text("我要結帳");
				$(domElement).removeClass("btn-outline-danger");
			});
			return false;
		}
		else{
			$(".form__order--dataList").val(JSON.stringify(shoppingCart));
			$(".form__order").submit();
		}
	});

	/**
		顯示訂單明細
	**/
	$(".btn--showOrderDetail").bind("click", (element) => {
		const domElement = element.currentTarget;
		$(".orderList--dataRow").removeClass("table-info");
		$(domElement).parents(".orderList--dataRow").addClass("table-info");
		getOrderDeatil($(domElement).attr("data-orderId"));
	})
});