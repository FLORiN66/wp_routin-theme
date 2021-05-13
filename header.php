<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>


</head>

<body <?php body_class(); ?>>
	<header class="site-header">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
				<a class="navbar-brand" href="<?php echo  site_url();?>">Home</a>
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item active">
						<a class="nav-link" href="<?php echo site_url('/lists'); ?>">Lists</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="<?php echo site_url('/add-list'); ?>">Add New List</a>
					</li>
				</ul>

				<!-- 					<div class="formBlock">
<form id="form">
<input type="text" name="start" class="input" id="start" placeholder="Choose starting point" />
<input type="text" name="end" class="input" id="destination" placeholder="Choose starting point" />
<button style="display: none;" type="submit">Get Directions</button>
</form>
</div> -->
			</div>
		</nav>
	</header>