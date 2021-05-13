<?php
get_header();
?>
<div class="container-fluid">
    <div class="container">
        <div class="row justify-content-center">
            <h1>Listings</h1>
        </div>
        <div class="row list_row">
            <div class="col-2 my-4">
                <?php do_shortcode('[category_filter_shortcode]'); ?>
            </div>
            <div class="col-10">
                <?php
                $cat_id = get_queried_object()->term_id;
                $args = array(
                    'post_type' => 'list',
                    'cat' => $cat_id,
                );
                $wp_query = new WP_Query($args);
                // var_dump($wp_query);
                while ($wp_query->have_posts()) {
                    $wp_query->the_post();
                    $types = get_terms(array(
                        'taxonomy' => 'category',
                        'hide_empty' => true,
                    )); ?>
                    <div class="row my-4 listing_post">
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <?php
                            $i = 0;
                            foreach ($types as $type) {
                                $image = get_field('category_image', 'category_' . $type->term_id . '');
                                // var_dump(in_category($type->term_id));

                                if (in_category($type->term_id)) {
                                    $cat_image[$i] = $image;
                                    $i++;
                                }
                            }

                            $link_image = has_post_thumbnail() ? get_the_post_thumbnail_url() : '/wp-content/uploads/2021/05/no-picture-available.png';

                            echo '<img class="category_image" width="150px" height="150px" src="' . $link_image . ' " /> '; //$cat_image[0] for category image
                            // var_dump($term_id);
                            ?>
                        </div>
                        <div class="col-10 p-3">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><strong>Start point:</strong> <?php echo get_field('start'); ?></p>
                            <p><strong>End point:</strong> <?php echo get_field('end'); ?></p>
                            <p><?php echo get_the_date(); ?></p>
                        </div>
                    </div>
                <?php } ?>
                <div class="row my-4">
                    <?php echo paginate_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>