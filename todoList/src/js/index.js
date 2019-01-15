function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

let showType = "all";

//當網頁完成載入時，執行以下動作 
$(document).ready(()=>{

	//新增代辦事項
	$("#items--add").bind("click", ()=>{
		const content = $("#userInput").val();
		if(content){
			$(".items").append(
				`<li class="item list-group-item">
					<div class="row justify-content-between">
						<div class="col-md-8">
							${escapeHtml(content)}
						</div>
						<div class="col-md-4 text-right">
							<button class="item__action item__action--done btn btn-outline-success btn-sm" id="items--add" type="button" value="done">標記完成</button>
							<button class="item__action item__action--del btn btn-outline-danger btn-sm" id="items--add" type="button">刪除</button>
						<div>
					</div>
				</li>`
			);
		}
		$("#userInput").val("");
	});

	//改變顯示類別
	$(".itmes--showtype").bind("click", (element)=>{
		$(".itmes--showtype").removeClass("active");
		$(element.target).addClass("active");
		showType = $(element.target).attr("value");
		$(".item").each((index, value) => {
			$(value).hide()
			if(showType === "done" && $(value).hasClass("item--done")){
				$(value).show();
			}
			else if(showType === "undone" && !$(value).hasClass("item--done")){
				$(value).show();
			}
			else if(showType === "all"){
				$(value).show();
			}
		})
	});

	//已完成
	$(".items").on("click", ".item__action--done", (element)=>{
		const domElement = element.target;
		if($(domElement).val() === "done"){
			$(domElement).val("undone");
			$(domElement).text("取消標記");
			$(domElement).parents(".item").addClass("item--done").add;
			if(showType === "undone"){
				$(domElement).parents(".item").hide();
			}
		}
		else if($(domElement).val() === "undone"){
			$(domElement).val("done");
			$(domElement).text("標記完成");
			$(domElement).parents(".item").removeClass("item--done");
			if(showType === "done"){
				$(domElement).parents(".item").hide();
			}
		};
	});

	//刪除代辦事項
	$(".items").on("click", ".item__action--del", (element)=>{
		$(element.target).parents(".item").remove();
	});
})