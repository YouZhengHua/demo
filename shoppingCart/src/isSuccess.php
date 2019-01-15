<?php session_start(); ?>
<div style="text-align:center; margin-top: 30px;">
	<h1 style="color: rgba(0, 200, 0, 1);"><?php print_r($_SESSION['MSG']); ?></h1>
	<h3><span class="time">5</span>&nbsp;秒後自動轉跳至首頁</h3>
</div>
<script type="text/javascript">
	function timeOut() {
		let timeDom = document.querySelector(".time");
		console.log(timeDom.innerHTML);
		if(Number(timeDom.innerHTML) > 0){
			timeDom.innerHTML = Number(timeDom.innerHTML) - 1;
			let t = setTimeout(timeOut, 1000);
		}else{
			window.location.href = "index.php";
		}
	}
	document.addEventListener("DOMContentLoaded", timeOut());
</script>