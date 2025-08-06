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
