<?php
/*
Template Name: New List
*/
acf_form_head();
get_header(); ?>

<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">
		<div class="container">
			<form method="post" enctype="multipart/form-data">
				<div class="form-group">
					<!-- Titile -->
					<label for="title">Post Title:</label>
					<input type="text" class="form-control" id="title" name="title" required>

					<!-- Description -->
					<label for="description">Description:</label>
					<textarea type="text" class="form-control" id="description" name="description" required></textarea>

					<!-- Uopload Image -->
					<label>Select Image:</label>
					<input type="file" name="multiple_attachments[]" id="my_image_upload" multiple="multiple"/>
					<?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>

					<!-- Category -->
					<label for="category">Category:</label>
					<!-- <input type="text" class="form-control" id="category" name="category" required> -->
					<input type="text" class="form-control input-cat" name="category" autocomplete="off" required>
					<ul class="item-list">
						<?php
						$args = array(
							'orderby' => 'name',
							'order'   => 'ASC'
						);
						$cats = get_categories($args);
						foreach ($cats as $cat) { ?>
							<li class="category" name="category"><?php echo $cat->name; ?></li>
						<?php } ?>
					</ul>

					<!-- Start Point -->
					<label for="pwd">Start Point:</label>
					<input type="text" class="form-control" id="start_point" name="start_point" autocomplete="off" required>
					<div class="bo_start_point">
						<ul></ul>
					</div>

					<!-- End Point -->
					<label for="pwd">End Point:</label>
					<input type="text" class="form-control" id="end_point" name="end_point" autocomplete="off" required>
					<div class="bo_end_point">
						<ul></ul>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div><!-- #content -->
</div><!-- #primary -->
<script>
	(function() {
		$(".item-list li").click(function() {
			var inputValue = $('.input-cat');
			var data = $(this).text();
			inputValue.val(data);
			$('.item-list').fadeOut('fast');
		});
		$(".input-cat").focus(function() {
			$(".item-list").fadeIn('fast');
		})
		$(document).mouseup(function(e) {
			if (!$(e.target).is('.item-list') && !$(e.target).is('.input-cat')) {
				$('.item-list').fadeOut('fast');
			}
		});
	})();
</script>
<?php get_footer(); ?>