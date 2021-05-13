<?php
function routing_scripts()
{
	wp_enqueue_style('routing-style', get_stylesheet_uri());


	wp_enqueue_style('bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css', false, NULL, 'all');
	wp_enqueue_script('routing-jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js');
	wp_enqueue_script('bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js');
	wp_enqueue_script('script-name', get_template_directory_uri() . '/scripts.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'routing_scripts');


// ************* Remove default Posts type since no blog *************

// Remove side menu
function remove_default_post_type()
{
	remove_menu_page('edit.php');
}
add_action('admin_menu', 'remove_default_post_type');

// Remove +New post in top Admin Menu Bar
function remove_default_post_type_menu_bar($wp_admin_bar)
{
	$wp_admin_bar->remove_node('new-post');
}
add_action('admin_bar_menu', 'remove_default_post_type_menu_bar', 999);

// Remove Quick Draft Dashboard Widget
function remove_draft_widget()
{
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
}
add_action('wp_dashboard_setup', 'remove_draft_widget', 999);

// End remove post type


add_action('after_setup_theme', 'bacau_features');
function bacau_features()
{
	add_theme_support('title-tag');
}

function bacau_post_types()
{
	register_post_type('list', array(
		'show_in_rest' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
		'rewrite' => array('slug' => 'lists'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
			'name' => 'Listings',
			'add_new_item' => 'Add New Listing',
			'edit_item' => 'Edit Listing',
			'all_items' => 'All Listings',
			'singular_name' => 'Listing',
			'view_items' => 'View Listings',
			'view_item' => 'View Listing'
		),
		'taxonomies'          => array('category'),
		'menu_icon' => 'dashicons-location-alt'
	));
	add_theme_support('post-thumbnails', array('list'));
	set_post_thumbnail_size(300, 300, true);
}
add_action('init', 'bacau_post_types');

function create_post_from_fields()
{
	if (isset($_POST['title'])) {
		// 	print_r($_POST);

		// create post object
		$my_post = array(
			'post_type'		=> 'list',
			'post_title'	=> $_POST['title'],
			'post_content'	=> $_POST['description'],
			'post_category'	=> $_POST['category'],
			'post_status' 	=> 'publish'
		);

		$postID = wp_insert_post($my_post);
		// 	var_dump($postID);
		wp_set_object_terms($postID, $_POST['category'], 'category');

		//upload featured image

		if ('POST' == $_SERVER['REQUEST_METHOD']) {
			if ($_FILES) {
				$files = $_FILES["multiple_attachments"];
				foreach ($files['name'] as $key => $value) {
					if ($files['name'][$key]) {
						$file = array(
							'name' => $files['name'][$key],
							'type' => $files['type'][$key],
							'tmp_name' => $files['tmp_name'][$key],
							'error' => $files['error'][$key],
							'size' => $files['size'][$key]
						);
						$_FILES = array("multiple_attachments" => $file);
						foreach ($_FILES as $file => $array) {
							$newupload = handle_attachment($file, $postID);
							$gallery[$i] = $newupload;
							$i++;
						}
					}
				}
			}
		}

		//update fields
		update_field('field_608a5bc9ef3e1', $_POST['start_point'], $postID);
		update_field('field_608a5bd6ef3e2', $_POST['end_point'], $postID);
		update_field('field_6094ee79cc7d0', $gallery, $postID);
		set_post_thumbnail($postID, end($gallery));

		wp_redirect(get_permalink($postID));
		die; // stop script after form submit
	}
}
add_action('init', 'create_post_from_fields');



function handle_attachment($file_handler, $post_id, $set_thu = true)
{
	// check to make sure its a successful upload
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	$attach_id = media_handle_upload($file_handler, $post_id);
	return $attach_id;
}


function select_filter()
{ ?>
	<select id="category_order">
		<option value="lists" class="category" name="category">All Lists</option>
		<?php
		$args = array(
			'orderby' => 'name',
			'order'   => 'ASC'
		);
		$cats = get_categories($args);
		foreach ($cats as $cat) {
			//remove & sign from string and vor value from option replace special characters and white spaces with "-"
			$value = str_replace('&amp;', '', $cat->name);
			?>
			<option value="<?php echo strtolower(preg_replace('/[^a-zA-Z0-9-_\.&]+/','-', $value)); ?>" class="category" name="category"><?php echo $cat->name; ?></option>
		<?php } ?>
	</select>
<?php
}
add_shortcode('category_filter_shortcode', 'select_filter');
