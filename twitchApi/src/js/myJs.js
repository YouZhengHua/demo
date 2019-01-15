function getTop20ByGame(gameName){
	const httpRequest = new XMLHttpRequest();
	httpRequest.open('GET', `https://api.twitch.tv/kraken/streams/?game=${gameName}&limit=20`);
	httpRequest.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
	httpRequest.setRequestHeader('Client-ID', 'lmm9wtat2k144soztf2pslqw6tvsuj');
	httpRequest.onload = () => {
		if(httpRequest.status >= 200 && httpRequest.status < 400){
			document.querySelector(".preview").innerHTML = "";
			const reObj = JSON.parse(httpRequest.responseText);
			reObj.streams.forEach((element, index, array) => {
				document.querySelector(".preview").innerHTML += `
					<div class="preview__box">
						<div class="preview__liveImg">
							<a href="${reObj.streams[index].channel.url}" target="_blank">
								<img src="${reObj.streams[index].preview.medium}">
							</a>
						</div>
						<div class="preview__info">
							<a href="${reObj.streams[index].channel.url}" target="_blank">
								<div class="preview__logo">
									<img class="preview__logo--img" src="${reObj.streams[index].channel.logo}">
								</div>
							</a>
							<div class="preview__nameAndTitle">
								<a href="${reObj.streams[index].channel.url}" target="_blank">
									<div class="preview__title">
										${reObj.streams[index].channel.status}
									</div>
								</a>
								<div class="preview__name">
									${reObj.streams[index].channel.display_name}
								</div>
								<div class="preview__viewers">
									viewers: ${reObj.streams[index].viewers}
								</div>
							</div>
						</div>
					</div>
					`;
			});
		}
		else{
			document.querySelector(".preview").innerText = httpRequest.status + " 錯誤。"
		}
	}
	httpRequest.onerror = () => {
		document.querySelector(".preview").innerText = httpRequest.status + " 錯誤。"
	}
	httpRequest.send();
}