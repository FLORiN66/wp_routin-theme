<?php get_header(); ?>

<div class="formBlock">
	<form id="form">
		<input type="text" name="start" class="input" id="start_point" placeholder="Choose starting point" autocomplete="off"/>
		<div class="bo_start_point">
			<ul></ul>
		</div>
		<input type="text" name="end" class="input" id="end_point" placeholder="Choose ending point" autocomplete="off"/>
		<div class="bo_end_point">
			<ul></ul>
		</div>
		<button type="submit">Get Directions</button>
	</form>
</div>
<div class="container-fluid">
	<div class="container">
		<div id="home_map"></div>
	</div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
<script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-map.js?key=Z60SGZ2Td3fQyvSU9JvRhuyWx7ZkHG7A"></script>
<script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-routing.js?key=Z60SGZ2Td3fQyvSU9JvRhuyWx7ZkHG7A"></script>
<script>
	// default map layer
	let map = L.map('home_map', {
		layers: MQ.mapLayer(),
		center: [51, 10],
		zoom: 4
	});


	function runDirection(start, end) {

		// recreating new map layer after removal
		map = L.map('home_map', {
			layers: MQ.mapLayer(),
			center: [51, 10],
			zoom: 4
		});

		var dir = MQ.routing.directions();

		dir.route({
			locations: [
				start,
				end
			]
		});


		CustomRouteLayer = MQ.Routing.RouteLayer.extend({
			createStartMarker: (location) => {
				var custom_icon;
				var marker;

				custom_icon = L.icon({
					iconUrl: '/wp-content/uploads/2021/04/red.png',
					iconSize: [20, 29],
					iconAnchor: [10, 29],
					popupAnchor: [0, -29]
				});

				marker = L.marker(location.latLng, {
					icon: custom_icon
				}).addTo(map);

				return marker;
			},

			createEndMarker: (location) => {
				var custom_icon;
				var marker;

				custom_icon = L.icon({
					iconUrl: '/wp-content/uploads/2021/04/blue.png',
					iconSize: [20, 29],
					iconAnchor: [10, 29],
					popupAnchor: [0, -29]
				});

				marker = L.marker(location.latLng, {
					icon: custom_icon
				}).addTo(map);

				return marker;
			}
		});

		map.addLayer(new CustomRouteLayer({
			directions: dir,
			fitBounds: true
		}));
	}


	// function that runs when form submitted
	function submitForm(event) {
		event.preventDefault();

		// delete current map layer
		map.remove();

		// getting form data
		start = document.getElementById("start_point").value;
		end = document.getElementById("end_point").value;

		// run directions function
		runDirection(start, end);

		// reset form
		document.getElementById("form").reset();
	}

	// asign the form to form variable
	const form = document.getElementById('form');

	// call the submitForm() function when submitting the form
	form.addEventListener('submit', submitForm);
</script>
<?php get_footer(); ?>