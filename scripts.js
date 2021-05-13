/**************START FIELD*******************/
let htmlRended = document.querySelector('.bo_start_point ul')
const searchRest = document.getElementById('start_point');

if (searchRest) {
	searchRest.addEventListener('keyup', function () {
		htmlRended.innerHTML = '';
		let start_point = searchRest.value;
		const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${start_point}.json?limit=5&access_token=pk.eyJ1IjoiZmxvcmluNjYiLCJhIjoiY2tuem81YnVxMDdpeDJwb2I2a3phOGV2MSJ9.mGgScexCgqkPfjSr3I5yiA`;

		fetch(url)
			.then((resp) => resp.json())
			.then(function (data) {
				let dataMap = data.features;
				dataMap.forEach((place) => {
					randerHTML(place.place_name)
				})
			})
			.catch(function (error) {
				console.log(error);
			});
	})
}

const randerHTML = (output) => {
	// console.log(output);
	const html = `<li class="data-location" data-location="${output}">${output}</li>`;

	htmlRended.insertAdjacentHTML('beforeend', html);
	document.querySelector(`[data-location ="${output}"]`).addEventListener('click', (element) => {
		let valLocation = document.querySelector(`[data-location ="${output}"]`).dataset.location;
		searchRest.value = valLocation;
		htmlRended.innerHTML = '';
	})
}



/**************END FIELD*******************/
let htmlRended2 = document.querySelector('.bo_end_point ul')
const searchRest2 = document.getElementById('end_point');

if (searchRest2) {
	searchRest2.addEventListener('keyup', function () {
		htmlRended2.innerHTML = '';
		let end_point = searchRest2.value;
		const url2 = `https://api.mapbox.com/geocoding/v5/mapbox.places/${end_point}.json?limit=5&access_token=pk.eyJ1IjoiZmxvcmluNjYiLCJhIjoiY2tuem81YnVxMDdpeDJwb2I2a3phOGV2MSJ9.mGgScexCgqkPfjSr3I5yiA`;

		fetch(url2)
			.then((resp) => resp.json())
			.then(function (data) {
				let dataMap2 = data.features;
				dataMap2.forEach((place) => {
					randerHTML2(place.place_name)
				})
			})
			.catch(function (error) {
				console.log(error);
			});
	})
}

const randerHTML2 = (output) => {
	// console.log(output);
	const html2 = `<li class="data-location" data-location="${output}">${output}</li>`;

	htmlRended2.insertAdjacentHTML('beforeend', html2);
	document.querySelector(`[data-location ="${output}"]`).addEventListener('click', (element) => {
		let valLocation2 = document.querySelector(`[data-location ="${output}"]`).dataset.location;
		searchRest2.value = valLocation2;
		htmlRended2.innerHTML = '';
	})
}


jQuery(document).ready(() => {
	jQuery('#category_order').on('change', () => {
		let link = jQuery('#category_order').val();
		(link == "lists") ? window.open('/lists', "_self") : window.open("/category/" + link, "_self");
	});
	// console.log(window.location.href);
	var url = window.location.href;
	var lastUrl = url.split("/").slice(3,4);
	if(lastUrl == "lists"){
		var link = jQuery('#category_order').val(lastUrl);
	} else {
		var lastUrl = url.split("/").slice(4,5);
		var link = jQuery('#category_order').val(lastUrl);
	}
});




