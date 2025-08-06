<?php

add_action('init', 'alc_register_testimonial_cpt');
function alc_register_testimonial_cpt() {
    register_post_type('testimonial', [
        'labels' => [
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial',
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor'],
        'show_in_rest' => true,
    ]);
}

add_action('add_meta_boxes', 'alc_add_rating_metabox');
function alc_add_rating_metabox() {
    add_meta_box('alc_rating', 'Client Rating (1–5)', 'alc_rating_metabox_cb', 'testimonial');
}

function alc_rating_metabox_cb($post) {
    $value = get_post_meta($post->ID, '_alc_rating', true);
    echo '<input type="number" name="alc_rating" value="' . esc_attr($value) . '" min="1" max="5" />';
}

add_action('save_post', 'alc_save_rating_meta');
function alc_save_rating_meta($post_id) {
    if (isset($_POST['alc_rating'])) {
        update_post_meta($post_id, '_alc_rating', intval($_POST['alc_rating']));
    }
}

add_shortcode('alc_testimonials', 'alc_render_testimonials');
function alc_render_testimonials() {
    ob_start();
    ?>
    <div id="alc-testimonials"></div>
    <button id="load-more">Load More</button>
    <?php
    wp_enqueue_script('alc-loadmore', plugin_dir_url(__FILE__) . 'js/load-more.js', ['jquery'], null, true);
    wp_localize_script('alc-loadmore', 'alc_ajax', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
    return ob_get_clean();
}

add_action('wp_ajax_alc_load_testimonials', 'alc_ajax_load_testimonials');
add_action('wp_ajax_nopriv_alc_load_testimonials', 'alc_ajax_load_testimonials');

function alc_ajax_load_testimonials() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $query = new WP_Query([
        'post_type' => 'testimonial',
        'posts_per_page' => 6,
        'paged' => $paged
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="testimonial">';
            echo '<h4>' . get_the_title() . '</h4>';
            echo '<p>' . get_the_content() . '</p>';
            echo '<strong>Rating: ' . get_post_meta(get_the_ID(), '_alc_rating', true) . '/5</strong>';
            echo '</div>';
        }
    }

    wp_die();
}

add_action('rest_api_init', function () {
    register_rest_route('alc/v1', '/testimonials', [
        'methods' => 'GET',
        'callback' => 'alc_rest_testimonials',
        'args' => [
            'page' => ['default' => 1],
            'per_page' => ['default' => 6],
        ],
    ]);
});

function alc_rest_testimonials($request) {
    $paged = $request['page'];
    $pp = $request['per_page'];

    $query = new WP_Query([
        'post_type' => 'testimonial',
        'posts_per_page' => $pp,
        'paged' => $paged,
    ]);

    $results = [];
    foreach ($query->posts as $post) {
        $results[] = [
            'name' => $post->post_title,
            'content' => $post->post_content,
            'rating' => get_post_meta($post->ID, '_alc_rating', true),
        ];
    }

    return rest_ensure_response($results);
}