<?php
get_header();

while (have_posts()) {
	the_post();
	$start_point = get_field('start');
	$end_point = get_field('end');
?>
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1><?php the_title(); ?></h1>
				</div>
			</div>
			<div id='map'></div>
			<p>Posted at: <?php echo get_the_date(); ?></p>
			<div class="row">
				<div class="col-12">
					<p><strong>Start point:</strong> <?php echo get_field('start'); ?></p>
					<p><strong>End point:</strong> <?php echo get_field('end'); ?></p>
					<?php
					if (!empty(get_the_content())) {
					?>
						<h3>Description:</h3>
						<div class="description"><?php the_content(); ?></div>
					<?php }
					// var_dump(get_field('gallery'));
					$images = get_field('gallery');
					$size = 'full';
					foreach ($images as $image) { ?>
						<img src="<?php echo esc_url($image['url']); ?>" height="150px" width="150px" style="object-fit: cover;"/>

					<?php } ?>

				</div>
			</div>
		</div>
	</div>
<?php } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
<script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-map.js?key=Z60SGZ2Td3fQyvSU9JvRhuyWx7ZkHG7A"></script>
<script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-routing.js?key=Z60SGZ2Td3fQyvSU9JvRhuyWx7ZkHG7A"></script>

<script src="https://unpkg.com/leaflet-responsive-popup@0.6.4/leaflet.responsive.popup.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-responsive-popup@0.6.4/leaflet.responsive.popup.css" />
<script>
	//MQ - MapQuest
	console.log('start point: ' + '<?php echo $start_point; ?>');
	console.log('end point: ' + '<?php echo $end_point; ?>');
	let map = L.map('map', {
		layers: MQ.mapLayer(),
		center: [51, 10],
		zoom: 4
	});

	function runDirections(start, end) {
		//recreating new map layer
		map = L.map('map', {
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

				var custom_popup = L.responsivePopup().setContent('A pretty CSS3 responsive popup.<br> Easily customizable.');
				marker = L.marker(location.latLng, {
					icon: custom_icon
				}).addTo(map).bindPopup(custom_popup);
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

				var custom_popup = L.responsivePopup().setContent('A pretty CSS3 responsive popup.<br> Easily customizable.');

				marker = L.marker(location.latLng, {
					icon: custom_icon
				}).addTo(map).bindPopup(custom_popup);
				return marker;
			}
		});

		map.addLayer(new CustomRouteLayer({
			directions: dir,
			fitBounds: true
		}));
	}

	function load_route() {
		event.preventDefault();

		//delete current map layer
		map.remove();
		start = '<?php echo $start_point; ?>';
		end = '<?php echo $end_point; ?>';
		runDirections(start, end);
	}

	window.onload = load_route;
</script>




<?php get_footer(); ?>